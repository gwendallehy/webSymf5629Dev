<?php

// src/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        return $this->render('admin/index.html.twig');
    }
}


