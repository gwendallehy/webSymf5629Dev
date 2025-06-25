<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/test-mail')]
    public function testMail(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('contact.gwendal.pro@gmail.com')
            ->to('5629Productions.AutoMail@gmail.com')
            ->subject('Test de mail Symfony le 2506')
            ->text('Ceci est un test. 25/06');

        $mailer->send($email);

        return new Response('Mail envoyé.');
    }

    #[Route("/contact", name: "contact", methods: ["GET", "POST"])]
    public function contact(
        Request $request,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($contact);
            $em->flush();

            $email = (new Email())
                ->from("5629Productions.AutoMail@gmail.com")
                ->to('5629Productions.AutoMail@gmail.com')
                ->subject(
                    'Nouveau message de contact de : ' . $contact->getMail()
                )
                ->text(
                    "📩 Nouvelle prise de contact\n\n" .
                    "👤 Nom : " . $contact->getFirstname() . " " . $contact->getName() . "\n" .
                    "📧 Email : " . $contact->getMail() . "\n\n" .
                    "📝 Message :\n" .
                    "───────────────\n" .
                    $contact->getContent() . "\n" .
                    "───────────────"
                );


            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('displays/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
