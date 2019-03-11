<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vue
 *
 * @ORM\Table(name="vue")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\VueRepository")
 */
class Vue
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idq", type="integer")
     */
    private $idq;

    /**
     * @var array
     *
     * @ORM\Column(name="tab", type="array")
     */
    private $tab;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idq
     *
     * @param integer $idq
     *
     * @return Vue
     */
    public function setIdq($idq)
    {
        $this->idq = $idq;

        return $this;
    }

    /**
     * Get idq
     *
     * @return int
     */
    public function getIdq()
    {
        return $this->idq;
    }

    /**
     * Set tab
     *
     * @param array $tab
     *
     * @return Vue
     */
    public function setTab($tab)
    {
        $this->tab = $tab;

        return $this;
    }

    /**
     * Get tab
     *
     * @return array
     */
    public function getTab()
    {
        return $this->tab;
    }
}

