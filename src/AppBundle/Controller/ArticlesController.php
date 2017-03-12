<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/24/2017
 * Time: 12:11 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends Controller
{


    /**
     * @Route("/article/search", name="search_article")
     */
    public function searchAction(Request $request)
    {
        $title = $request->get('_title');
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findTitleLike($title);
//        dump($articles); die;
        return $this->render('default/index.html.twig', [
           'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{id}", name="show_article")
     */
    public function showAction(Request $request, Article $article)
    {
        return $this->render('article/show.html.twig', [
           'article' => $article
        ]);
    }

}