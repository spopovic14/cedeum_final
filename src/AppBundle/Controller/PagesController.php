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
        if($page == null) {
            $page = $this->createPage('Kontakt');
        }
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
        if($page == null) {
            $page = $this->createPage('O nama');
        }
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
         if($page == null) {
             $page = $this->createPage('Bitef');
         }
         return $this->render('page/festival.html.twig', [
             'page' => $page
         ]);
     }

      /**
       * @Route("/archive", name="archive_page")
       */
       public function archiveAction(Request $request)
       {
           $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Arhiva']);
           if($page == null) {
               $page = $this->createPage('Arhiva');
           }
           return $this->render('page/archive.html.twig', [
               'page' => $page
           ]);
       }




       private function createPage($title)
       {
           $page = new \AppBundle\Entity\Page();
           $page->setTitle($title);
           $page->setTitleEn($title);
           $page->setContent('<p>Sadrzaj</p>');
           $page->setContentEn('<p>Content</p>');
           $page->setRaw(false);
           $this->getDoctrine()->getManager()->persist($page);
           $this->getDoctrine()->getManager()->flush();
           return $page;
       }

}
