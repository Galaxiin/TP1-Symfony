<?php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/article", name = "liste_article")
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
     * formulaire de création d'article
     *
     * @Route("/article/creation", name = "creation_article")
     * 
     * @return Response
     */
    public function creation_article(Request $request, EntityManagerInterface $manager){
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($article->getImages() as $images){
                $images->setArticle($article);
                $manager->persist($images);
            }
            
            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce {$article->getLibelle()} a bien été enregistré"
            );            
        }

        return $this->render(
            'Article/creation_article.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Formulaire de modification d'un article
     *
     * @Route("/article/{libelle}/edition", name = "edition_article")
     * 
     * @return Response
     */
    public function editionarticle(Request $request, Article $article, EntityManagerInterface $manager){
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($article->getImages() as $images){
                $images->setArticle($article);
                $manager->persist($images);
            }
            
            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications ont bien étés enregistrés"
            );            
        }

        return $this->render(
            'Article/edition_article.html.twig',[
                'form' => $form->createView(),
                'article' => $article

            ]
        );
    }

    /**
     * Fiche détaillé d'un article
     *
     * @Route("/article/{libelle}", name = "fiche_article")
     */
    public function fichearticle(Article $article){

        // $article = $repo->findById($id);

        return $this->render(
            'Article/fiche_article.html.twig',
            ['article' => $article]
        );
    }
}
?>