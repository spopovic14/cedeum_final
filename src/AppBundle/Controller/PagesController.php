<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 5:29 PM
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction(Request $request)
    {
        $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Kontakt']);
        return $this->render('page/page.html.twig', [
           'page' => $page
        ]);
    }

    /**
     * @Route("/about", name="about_page")
     */
    public function aboutAction(Request $request)
    {
        $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'O nama']);
        return $this->render('page/page.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @Route("/bitef", name="bitef_page")
     */
     public function bitefAction(Request $request)
     {
         $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Bitef']);
         $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findPublishedBitef();
         return $this->render('page/festival.html.twig', [
             'page' => $page,
             'articles' => $articles
         ]);
     }

     /**
      * @Route("/mater-terra", name="mater_page")
      */
      public function materAction(Request $request)
      {
          $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Mater-Terra']);
          $articles = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findPublishedMaterTerra();
          return $this->render('page/festival.html.twig', [
              'page' => $page,
              'articles' => $articles
          ]);
      }

      /**
       * @Route("/archive", name="archive_page")
       */
       public function archiveAction(Request $request)
       {
           $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Arhiva']);
           return $this->render('page/archive.html.twig', [
               'page' => $page
           ]);
       }

}
