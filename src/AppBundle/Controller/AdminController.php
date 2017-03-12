<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 3:52 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Page;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleFormType;
use AppBundle\Form\PageFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
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
        /*
         * TODO:
         * Napraviti posebne stranice za Page i za Article. Za Article napraviti izlistavanje po stranicama i
         * pretragu po imenu (i datumu?).
         */

        $pages = $this->getDoctrine()->getManager()->getRepository(Page::class)->findAll();
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->getAllOrderByDate();
        return $this->render('admin/index.html.twig', [
            'pages' => $pages,
            'articles' => $articles,
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
     * @Route("admin/article/new/{raw}", name="new_article", defaults={"raw" = "editor"})
     */
    public function newArticleAction(Request $request, $raw)
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

        if($raw == 'editor') {

            return $this->render('admin/new_article.html.twig', [
                'form' => $form->createView()
            ]);

        }

        return $this->render('admin/new_article_raw.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/{id}/{raw}", name="edit_article", defaults={"raw" = "editor"})
     */
    public function editArticleAction(Request $request, Article $article, $raw)
    {
//        $path = 'uploads/article_pictures/' . $article->getPicture();
//        if (file_exists($path) && !is_dir($path)) {
//            $article->setPicture(new File($path));
//        }
//        else {
//            $article->setPicture(null);
//        }
        $originalPicture = $article->getPicture();
        $article->setPicture(null);
        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);
        if($form->isValid()) {

            $article = $form->getData();

            if($article->getPicture() == null) {
                $article->setPicture($originalPicture);
            }
            else {
                $fs = new Filesystem();
                $old = 'uploads/article_pictures/' . $originalPicture;
                if(file_exists($old) && !is_dir($old)) {
                    $fs->remove($old);
                }
                $file = $article->getPicture();
                $filename = md5(uniqid()) . '.' . $file->guessExtension();

                $file->move(
                    $this->getParameter('article_pictures_directory'),
                    $filename
                );

                $article->setPicture($filename);
            }

//            $file = $article->getPicture();
//            $filename = md5(uniqid()) . '.' . $file->guessExtension();
//
//            $file->move(
//                $this->getParameter('article_pictures_directory'),
//                $filename
//            );
//
//            $article->setPicture($filename);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Dogadjaj sacuvana');
            return $this->redirectToRoute('admin_panel');
        }

        if($raw == 'editor') {

            return $this->render('admin/new_article.html.twig', [
                'form' => $form->createView()
            ]);

        }

        return $this->render('admin/new_article_raw.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
