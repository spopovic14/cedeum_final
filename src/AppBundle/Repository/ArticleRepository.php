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

    public function getAllOrderByDate()
    {
        return $this->createQueryBuilder('article')
            ->orderBy('article.releaseDate', 'DESC')
            ->getQuery()->execute();
    }

    public function getLatest()
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.releaseDate <= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('article.releaseDate', 'DESC')
            ->setMaxResults(3)
            ->getQuery()->execute();
    }

    public function getBatch($offset, $size)
    {
        return $this->createQueryBuilder('article')
            ->orderBy('article.releaseDate', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->getQuery()->execute();
    }

    public function getPage($num, $size)
    {
        return $this->getBatch(($num-1) * $size, $size);
    }

    public function getPublishedBatch($offset, $size)
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.releaseDate <= :date')
            ->setParameter('date', new \DateTime())
            ->orderBy('article.releaseDate', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($size)
            ->getQuery()->execute();
    }

    public function getPublishedPage($num, $size)
    {
        return $this->getPublishedBatch(($num-1) * $size, $size);
    }

    public function getPublishedCount()
    {
        return $this->createQueryBuilder('article')
            ->select('count(article.id)')
            ->andWhere('article.releaseDate <= :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()->getSingleScalarResult();
    }

    public function getCount()
    {
        return $this->createQueryBuilder('article')
            ->select('count(article.id)')
            ->getQuery()->getSingleScalarResult();
    }

    public function findTitleLike($str)
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.title LIKE :title')
            ->setParameter('title', '%' . $str . '%')
            ->getQuery()->execute();
    }

    public function findPublishedTitleLike($str)
    {
        return $this->createQueryBuilder('article')
            ->andWhere('article.title LIKE :title')
            ->setParameter('title', '%' . $str . '$')
            ->andWhere('article.releaseDate <= :date')
            ->setParameter('date', new \DateTime())
            ->getQuery()->execute();
    }

}
