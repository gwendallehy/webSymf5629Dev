<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route("/contact", name: "contact", methods: ["GET"])]
    public function contact(ContactRepository $contactRepository) : Response {
        return $this->render('displays/contact.html.twig');
    }
}
