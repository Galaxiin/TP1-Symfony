<?php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController {

    /**
     * Liste des articles
     *
     * @Route("/article/liste", name = "liste_article")
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
     * @IsGranted("ROLE_USER")
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
            
            $article->setAuteur($this->getUser());

            $manager->persist($article);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'article {$article->getLibelle()} a bien été enregistré"
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
     * @Security("is_granted('ROLE_USER') and user === article.getAuteur()", message ="Vous ne pouvez pas modifier cet article")
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

    /**
     * Suppression de l'article
     *
     * @Route("/article/{libelle}/suppression", name = "suppression_article")
     * @Security("is_granted('ROLE_USER') and user === article.getAuteur()", message ="Vous ne pouvez pas acceder a cette action")
     * 
     * @return Response
     */
    public function suppressionArticle(Request $request, Article $article, EntityManagerInterface $manager){
        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'success',
            "La suppresssion a bien été faite"
        );
        return $this->redirectToRoute("article_index");
    }
}
?>