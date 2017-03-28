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
use AppBundle\Entity\Project;
use AppBundle\Form\ArticleFormType;
use AppBundle\Form\PageFormType;
use AppBundle\Form\ImageFormType;
use AppBundle\Form\ProjectFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

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
        // $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->getAllOrderByDate();
        // $projects = $this->getDoctrine()->getManager()->getRepository(Project::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'pages' => $pages,
            // 'articles' => $articles,
            // 'projects' => $projects,
        ]);
    }

    /**
     * @Route("/admin/project/new", name="new_project")
     */
     public function newProjectAction(Request $request)
     {
         $form = $this->createForm(ProjectFormType::class);
         $form->handleRequest($request);

         if($form->isValid()) {
             $project = $form->getData();
             $em = $this->getDoctrine()->getManager();

             $file = $project->getPicture();
             $filename = md5(uniqid()) . '.' . $file->guessExtension();

             $file->move(
                 $this->getParameter('article_pictures_directory'),
                 $filename
             );

             $project->setPicture($filename);

             $em->persist($project);
             $em->flush($project);

             return $this->redirectToRoute('admin_panel');
         }

         return $this->render('admin/new_project.html.twig', [
             'form' => $form->createView()
         ]);
     }

     /**
      * @Route("/admin/project/{id}", name="edit_project")
      */
     public function editProjectAction(Request $request, Project $project)
     {
         $originalPicture = $project->getPicture();
         $project->setPicture(null);

         $form = $this->createForm(ProjectFormType::class, $project);
         $form->handleRequest($request);

         if($form->isValid()) {
             $project = $form->getData();
             $em = $this->getDoctrine()->getManager();

             if($project->getPicture() == null) {
                 $project->setPicture($originalPicture);
             }
             else {
                 $fs = new Filesystem();
                 $old = 'uploads/article_pictures/' . $originalPicture;
                 if(file_exists($old) && !is_dir($old)) {
                     $fs->remove($old);
                 }
                 $file = $project->getPicture();
                 $filename = md5(uniqid()) . '.' . $file->guessExtension();

                 $file->move(
                     $this->getParameter('article_pictures_directory'),
                     $filename
                 );

                 $project->setPicture($filename);
             }

             $em->persist($project);
             $em->flush($project);

             return $this->redirectToRoute('admin_panel');
         }

         return $this->render('admin/new_project.html.twig', [
             'form' => $form->createView()
         ]);
     }

    /**
     * @Route("/admin/list_images", name="list_images")
     */
     public function listImagesAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
         $images = $em->getRepository('AppBundle:Image')->findAll();

         return $this->render('admin/image_list.html.twig', [
             'images' => $images
         ]);
     }

    /**
     * @Route("/admin/upload_image", name="upload_image")
     */
     public function uploadImageAction(Request $request)
     {
         $form = $this->createForm(ImageFormType::class);
         $form->handleRequest($request);

         if($form->isValid()) {
             $image = $form->getData();
             $em = $this->getDoctrine()->getManager();

             $file = $image->picture;
             $filename = $image->getName() . '.' . $file->guessExtension();

             $file->move(
                 $this->getParameter('upload_pictures_directory'),
                 $filename
             );

             $image->setName($filename);


             try {
                $em->persist($image);
                $em->flush($image);
             }
             catch(UniqueConstraintViolationException $e) {
                 return $this->render('admin/admin_error.html.twig', [
                     'message' => 'Slika sa zadatim imenom vec postoji'
                 ]);
             }

            //  $file = $article->getPicture();
            //  $filename = md5(uniqid()) . '.' . $file->guessExtension();
             //
            //  $file->move(
            //      $this->getParameter('upload_pictures_directory'),
            //      $filename
            //  );
             //
            //  $image->setName($filename);
             //
            //  $em->persist($article);
            //  $em->flush($article);

             return $this->redirectToRoute('admin_panel');
         }

         return $this->render('admin/upload_image.html.twig', [
             'form' => $form->createView()
         ]);
     }


    /**
     * @Route("/admin/pages/{id}/{raw}", name="page_edit", defaults={"raw" = "editor"})
     */
    public function editPageAction(Request $request, Page $page, $raw)
    {
        $form = $this->createForm(PageFormType::class, $page);

        $form->handleRequest($request);
        if($form->isValid()) {
            $page = $form->getData();

            if($raw == 'editor') {
                $page->setRaw(false);
            }
            else {
                $page->setRaw(true);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $this->addFlash('success', 'Stranica sacuvana');
            return $this->redirectToRoute('admin_panel');
        }

        if($raw == 'raw') {
            return $this->render('page/edit_raw.html.twig', [
                'form' => $form->createView()
            ]);
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

            if($raw == 'editor') {
                $article->setRaw(false);
            }
            else {
                $article->setRaw(true);
            }

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

            if($raw == 'editor') {
                $article->setRaw(false);
            }
            else {
                $article->setRaw(true);
            }

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
