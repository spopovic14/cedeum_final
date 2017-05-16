<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/24/2017
 * Time: 12:11 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Project;
use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProjectsController extends Controller
{


    /**
     * @Route("/project", name="projects_page")
     */
    public function indexAction(Request $request)
    {
        $projects = $this->getDoctrine()->getManager()->getRepository(Project::class)->findActive();
        return $this->render('project/index.html.twig', [
           'projects' => $projects
        ]);
    }

    /**
     * @Route("/project/{id}", name="show_project")
     */
    public function showAction(Request $request, Project $project)
    {
        $articles = $this->getDoctrine()->getManager()->getRepository(Article::class)->findPublishedProjectArticles($project->getId());
        return $this->render('project/show.html.twig', [
           'project' => $project,
           'articles' => $articles,
        ]);
    }

    /**
     * @Route("/api/projects/page/{num}", name="json_project_page")
     */
    public function jsonProjectsAction(Request $request, $num)
    {
        // dump($request); die;
        $projects = $this->getDoctrine()->getManager()->getRepository(Project::class)->getPageId($num, 12);
        // $projects = $this->getDoctrine()->getManager()->getRepository(Article::class)->getPublishedPageId($num, 1);
        return new JsonResponse($projects);
    }

}
