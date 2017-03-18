<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 10:04 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 * @ORM\Table(name="article")
 */
class Article
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     */
    private $titleEn;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="text")
     */
     private $contentEn;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
     private $descriptionEn;

    /**
     * @ORM\Column(type="date")
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="string")
     */
    private $picture;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
     private $festival;

     /**
      * @ORM\Column(type="boolean")
      */
     private $raw = false;






    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


    public function getTitleEn()
    {
        return $this->titleEn;
    }

    public function setTitleEn($titleEn)
    {
        $this->titleEn = $titleEn;
    }

    public function getContentEn()
    {
        return $this->contentEn;
    }

    public function setContentEn($titleEn)
    {
        $this->contentEn = $titleEn;
    }

    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

    public function setDescriptionEn($titleEn)
    {
        $this->descriptionEn = $titleEn;
    }

    public function getFestival()
    {
        return $this->festival;
    }

    public function setFestival($titleEn)
    {
        $this->festival = $titleEn;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    public function setRaw($raw)
    {
        $this->raw = $raw;
    }


}
