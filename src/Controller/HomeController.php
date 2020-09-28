<?php
namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * Page d'accueil
     * 
     * @Route("/", name="homepage")
     */
    public function home(){
        return $this->render(
            'Accueil/home.html.twig'
        );
    }

    /**
     * Liste des articles
     *
     * @Route("/articles", name = "listearticle")
     */
    public function liste_article(ArticleRepository $repo){

        //$repo = $this->getDoctrine()->getRepository(Article::class);
        $liste = $repo->findAll();

        return $this->render(
            'Article/liste_article.html.twig',
            ['liste' => $liste]
        );
    }

    /**
     * Fiche détaillé d'un article
     *
     * @Route("/article/{id}", name = "fichearticle")
     */
    public function fichearticle(Article $article){

        // $article = $repo->findById($id);

        return $this->render(
            'Article/article.html.twig',
            ['article' => $article]
        );
    }
}
?>