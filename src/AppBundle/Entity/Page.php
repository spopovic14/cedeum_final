<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 5:34 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="page")
 */
class Page
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string")
     */
    private $titleEn;

    /**
     * @ORM\Column(type="text")
     */
    private $contentEn;

    /**
     * @ORM\Column(type="boolean")
     */
     private $raw = false;



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getTitleEn()
    {
        return $this->titleEn;
    }

    /**
     * @param mixed $title
     */
    public function setTitleEn($title)
    {
        $this->titleEn = $title;
    }

    /**
     * @return mixed
     */
    public function getContentEn()
    {
        return $this->contentEn;
    }

    /**
     * @param mixed $content
     */
    public function setContentEn($content)
    {
        $this->contentEn = $content;
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
