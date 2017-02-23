<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 3:52 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Page;
use AppBundle\Form\ArticleFormType;
use AppBundle\Form\PageFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin_panel")
     */
    public function index(Request $request)
    {
        $pages = $this->getDoctrine()->getManager()->getRepository(Page::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'pages' => $pages
        ]);
    }


    /**
     * @Route("/admin/pages/{id}", name="page_edit")
     */
    public function editPageAction(Request $request, Page $page)
    {
        $form = $this->createForm(PageFormType::class, $page);

        $form->handleRequest($request);
        if($form->isValid()) {
            $page = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $this->addFlash('success', 'Stranica sacuvana');
            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('page/edit.html.twig', [
           'form' => $form->createView()
        ]);
    }


    // -- ARTICLE --


    /**
     * @Route("admin/article/new", name="new_article")
     */
    public function newArticleAction(Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if($form->isValid()) {
            $article = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $file = $article->getPicture();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $file->move(
                $this->getParameter('article_pictures_directory'),
                $filename
            );

            $article->setPicture($filename);

            $em->persist($article);
            $em->flush($article);

            $this->addFlash('success', 'Uspeno dodat dogadjaj');
            return $this->redirectToRoute('admin_panel');
        }

        return $this->render('admin/new_article.html.twig', [
            'form' => $form->createView()
        ]);
    }


}