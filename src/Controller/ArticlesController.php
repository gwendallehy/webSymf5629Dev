<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\PortfolioRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{

    #[Route("/articles", name: "articles", methods: ["GET"])]
    public function articles(ArticleRepository $articleRepository) : Response {
        $articles = $articleRepository->findAll();

        return $this->render('displays/articles.html.twig', [
            'articles' => $articles,
        ]);

    }

    #[Route("/portfolio", name: "portfolio", methods: ["GET"])]
    public function portfolio(PortfolioRepository $portfolioRepository) : Response
    {
        $portfolio = $portfolioRepository->findAll();
        return $this->render('displays/portfolio.html.twig',[
            'portfolio' => $portfolio,
        ]);
    }

    #[Route("/team", name: "team", methods: ["GET"])]
    public function team(TeamRepository $teamRepository) : Response {
        $team = $teamRepository->findAll();
        return $this->render('displays/team.html.twig',[
            'team' => $team,
        ]);
    }

}
