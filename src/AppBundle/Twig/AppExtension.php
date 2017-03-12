<?php

namespace AppBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;


class AppExtension extends \Twig_Extension
{

    private $requestStack;



    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('localize', array($this, 'localizeFilter'))
        );
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

}
