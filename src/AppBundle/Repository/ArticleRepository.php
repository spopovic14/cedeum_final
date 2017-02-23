<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 10:31 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Article;

class ArticleRepository extends EntityRepository
{

    /**
     * @return Article[]
     */
    public function getPublished()
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.releaseDate <= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('article.releaseDate', 'DESC')
            ->getQuery()->execute();
    }

}