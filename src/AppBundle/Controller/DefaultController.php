<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/{_locale}/articles", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // $article = new Article();
        // $article->setTitle('Togetherness in Zarkovo');
        // $article->setContent('Lorem ipsum');
        // $article->setDescription('Opis');
        // $article->setPicture('741625d73772d3aece8f361b991dbce9.jpeg');
        // $article->setReleaseDate(new \DateTime());
        // $this->getDoctrine()->getManager()->persist($article);
        // $this->getDoctrine()->getManager()->flush();

        $user = new \AppBundle\Entity\User();
        $user->setUsername('stefan');
        $user->setPlainPassword('sifra1');
        $user->setRoles(['ROLE_USER']);
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        // echo "saved user";die;

        // echo $this->get('translator')->getLocale();die;

        $articles = $this->getDoctrine()->getRepository(Article::class)->getLatest();

        return $this->render('default/index.html.twig', [
              'articles' => $articles,
              'size' => count($articles),
        ]);

        return $this->redirect($this->generateUrl('articles_page', array('num' => 1)));

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
//            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getPublished()
              'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getLatest()
        ]);
    }

    /**
     * @Route("/pages/{num}", name="articles_page")
     */
    public function testAction(Request $request, $num)
    {
        $articles_per_page = $this->getParameter('articles_per_page');
        $count = intval($this->getDoctrine()->getRepository(Article::class)->getPublishedCount());
        $pages_allowed = $count / $articles_per_page;
        if($count % $articles_per_page > 0) {
            $pages_allowed = $pages_allowed+ 1;
        }

        $first = false;
        $last = false;

        if($pages_allowed == $num) {
            $last = true;
        }

        if($num == 1) {
            $first = true;
        }

        if($num == 1) {
            return $this->render('default/index.html.twig', [
                'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getPublishedPage($num, $articles_per_page),
                'first' => $first,
                'last' => $last,
                'num' => $num
            ]);
        }

        if($pages_allowed < $num || $num < 1) {
            throw $this->createNotFoundException('Bad page number');
        }

        /*
         * TODO:
         * Proslediti broj stranice u view, koji ce da napravi link (strelicu) za sledecu i prethodnu stranicu ako
         * one postoje. Proslediti i maksimalan broj stranice, a u view-u porediti trenutni sa maksimalnim i sa
         * nulom da bi se utvrdilo da koje strelice treba iscrtavati.
         * Napraviti pretragu za Article.
         * Prebaciti sve ovo u ArticleController.
         */

        return $this->render('default/index.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository(Article::class)->getPublishedPage($num, $articles_per_page),
            'first' => $first,
            'last' => $last,
            'numb' => $num
        ]);
    }
}
