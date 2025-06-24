<?php



namespace App\Controller;

use App\Entity\Article;
use App\Entity\Portfolio;
use App\Entity\Team;
use App\Entity\Event;
use App\Form\ArticleType;
use App\Form\PortfolioType;
use App\Form\TeamType;
use App\Form\EventType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin')]
class AdminContentController extends AbstractController
{
    private function handleFormImageUpload($form, $entity, string $uploadDir, SluggerInterface $slugger): void
    {
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

            try {
                $imageFile->move($uploadDir, $newFilename);
                $entity->setImgLink('/storage/images/' . $newFilename);
            } catch (FileException $e) {
                throw new \Exception('Image upload failed: ' . $e->getMessage());
            }
        }
    }

    #[Route('/{type}', name: 'admin_entity_list')]
    public function index(string $type, EntityManagerInterface $em): Response
    {
        $repository = match ($type) {
            'article' => $em->getRepository(Article::class),
            'portfolio' => $em->getRepository(Portfolio::class),
            'team' => $em->getRepository(Team::class),
            'event' => $em->getRepository(Event::class),
            default => throw $this->createNotFoundException()
        };

        return $this->render('admin/content/index.html.twig', [
            'items' => $repository->findAll(),
            'type' => $type,
        ]);
    }

    #[Route('/{type}/new', name: 'admin_entity_new')]
    public function new(string $type, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        [$entity, $formClass] = match ($type) {
            'article' => [new Article(), ArticleType::class],
            'portfolio' => [new Portfolio(), PortfolioType::class],
            'team' => [new Team(), TeamType::class],
            'event' => [new Event(), EventType::class],
            default => throw $this->createNotFoundException()
        };

        $form = $this->createForm($formClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleFormImageUpload($form, $entity, $this->getParameter('kernel.project_dir') . '/public/storage/images', $slugger);
            $em->persist($entity);
            $em->flush();
            return $this->redirectToRoute('admin_entity_list', ['type' => $type]);
        }

        return $this->render('admin/content/form.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
            'editMode' => false,
        ]);
    }

    #[Route('/{type}/{id}/edit', name: 'admin_entity_edit')]
    public function edit(string $type, int $id, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        [$repository, $formClass] = match ($type) {
            'article' => [$em->getRepository(Article::class), ArticleType::class],
            'portfolio' => [$em->getRepository(Portfolio::class), PortfolioType::class],
            'team' => [$em->getRepository(Team::class), TeamType::class],
            'event' => [$em->getRepository(Event::class), EventType::class],
            default => throw $this->createNotFoundException()
        };

        $entity = $repository->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Entity not found.');
        }

        $form = $this->createForm($formClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleFormImageUpload($form, $entity, $this->getParameter('kernel.project_dir') . '/public/storage/images', $slugger);
            $em->flush();
            return $this->redirectToRoute('admin_entity_list', ['type' => $type]);
        }

        return $this->render('admin/content/form.html.twig', [
            'form' => $form->createView(),
            'type' => $type,
            'editMode' => true,
        ]);
    }

    #[Route('/{type}/{id}/delete', name: 'admin_entity_delete', methods: ['POST'])]
    public function delete(string $type, int $id, Request $request, EntityManagerInterface $em): Response
    {
        $entityClass = match ($type) {
            'article' => Article::class,
            'portfolio' => Portfolio::class,
            'team' => Team::class,
            'event' => Event::class,
            default => throw $this->createNotFoundException()
        };

        $entity = $em->getRepository($entityClass)->find($id);
        if (!$entity) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete_' . $type . '_' . $id, $request->request->get('_token'))) {
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirectToRoute('admin_entity_list', ['type' => $type]);
    }
}



