<?php

namespace AppBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;


class AppExtension extends \Twig_Extension
{

    private $requestStack;
    private $container;



    public function __construct(RequestStack $requestStack, ContainerInterface $container)
    {
        $this->requestStack = $requestStack;
        $this->container = $container;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('localize', array($this, 'localizeFilter')),
            new \Twig_SimpleFilter('localizePage', array($this, 'localizePageFilter')),
            new \Twig_SimpleFilter('localizeProject', array($this, 'localizeProjectFilter')),
            new \Twig_SimpleFilter('insertImages', array($this, 'insertImages')),
        );
    }

    public function localizePageFilter($page, $field)
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();

        if($locale == 'en') {
            switch($field) {
                case 'title':
                    return $page->getTitleEn();
                    break;

                case 'content':
                    return $page->getContentEn();
                    break;
            }
        }

        elseif($locale == 'rs') {
            switch($field) {
                case 'title':
                    return $page->getTitle();
                    break;

                case 'content':
                    return $page->getContent();
                    break;
            }
        }

        return '';
    }

    public function localizeFilter($article, $field)
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();

        if($locale == 'en') {
            switch($field) {
                case 'title':
                    return $article->getTitleEn();
                    break;

                case 'description':
                    return $article->getDescriptionEn();
                    break;

                case 'content':
                    return $article->getContentEn();
                    break;
            }
        }

        elseif($locale == 'rs') {
            switch($field) {
                case 'title':
                    return $article->getTitle();
                    break;

                case 'description':
                    return $article->getDescription();
                    break;

                case 'content':
                    return $article->getContent();
                    break;
            }
        }

        return '';
    }

    public function localizeProjectFilter($project, $field)
    {
        $request = $this->requestStack->getCurrentRequest();
        $locale = $request->getLocale();

        if($locale == 'en') {
            switch($field) {
                case 'name':
                    return $project->getNameEn();
                    break;

                case 'description':
                    return $project->getDescriptionEn();
                    break;

                case 'longDescription':
                    return $project->getLongDescriptionEn();
                    break;
            }
        }

        elseif($locale == 'rs') {
            switch($field) {
                case 'name':
                    return $project->getName();
                    break;

                case 'description':
                    return $project->getDescription();
                    break;

                case 'longDescription':
                    return $project->getLongDescription();
                    break;
            }
        }

        return '';
    }


    /**
     * #!ime-slike.jpg!# - slika
     * %!ime-pdfa.pdf!% - pdf
     * $!ime-logoa.jpg!$ - logo
     */

    public function insertImages($text)
    {
        $loc = $this->container->getParameter('upload_pictures_directory') . '/';
        $new_text = str_replace('#!', '<img class="img-full img-responsive" src="/uploads/uploaded_pictures/', $text);
        $new_text = str_replace('!#', '">', $new_text);

        $new_text = preg_replace('/[$]!([^\s$]*)![$]/', '<img class="logo-img" src="/uploads/uploaded_pictures/$1">', $new_text);
        $new_text = preg_replace('/%!(.*)[.](.*)!%/', '<a href="/uploads/uploaded_pictures/$1.$2">$1</a>', $new_text);

        return $new_text;
    }

}
