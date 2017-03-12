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

class PagesController extends Controller
{

    /**
     * @Route("/contact", name="contact_page")
     */
    public function contactAction()
    {
        $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'Kontakt']);
        return $this->render('page/page.html.twig', [
           'page' => $page
        ]);
    }

    /**
     * @Route("/about", name="about_page")
     */
    public function aboutAction()
    {
        $page = $this->getDoctrine()->getManager()->getRepository('AppBundle:Page')->findOneBy(['title' => 'O nama']);
        return $this->render('page/page.html.twig', [
            'page' => $page
        ]);
    }

}