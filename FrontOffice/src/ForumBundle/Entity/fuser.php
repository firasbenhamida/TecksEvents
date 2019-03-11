<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * fuser
 *
 * @ORM\Table(name="fuser")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\fuserRepository")
 */
class fuser
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
     * @ORM\Column(name="idm", type="integer")
     */
    private $idm;

    /**
     * @var int
     *
     * @ORM\Column(name="nbc", type="integer")
     */
    private $nbc;

    /**
     * @var string
     *
     * @ORM\Column(name="activite", type="string", length=255)
     */
    private $activite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lactiv", type="datetime")
     */
    private $lactiv;

    /**
     * @var bool
     *
     * @ORM\Column(name="ban", type="boolean")
     */
    private $ban;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dban", type="datetime", nullable=true)
     */
    private $dban;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fban", type="datetime", nullable=true)
     */
    private $fban;


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
     * Set idm
     *
     * @param integer $idm
     *
     * @return fuser
     */
    public function setIdm($idm)
    {
        $this->idm = $idm;

        return $this;
    }

    /**
     * Get idm
     *
     * @return int
     */
    public function getIdm()
    {
        return $this->idm;
    }

    /**
     * Set nbc
     *
     * @param integer $nbc
     *
     * @return fuser
     */
    public function setNbc($nbc)
    {
        $this->nbc = $nbc;

        return $this;
    }

    /**
     * Get nbc
     *
     * @return int
     */
    public function getNbc()
    {
        return $this->nbc;
    }

    /**
     * Set activite
     *
     * @param string $activite
     *
     * @return fuser
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;

        return $this;
    }

    /**
     * Get activite
     *
     * @return string
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * Set lactiv
     *
     * @param \DateTime $lactiv
     *
     * @return fuser
     */
    public function setLactiv($lactiv)
    {
        $this->lactiv = $lactiv;

        return $this;
    }

    /**
     * Get lactiv
     *
     * @return \DateTime
     */
    public function getLactiv()
    {
        return $this->lactiv;
    }

    /**
     * Set ban
     *
     * @param boolean $ban
     *
     * @return fuser
     */
    public function setBan($ban)
    {
        $this->ban = $ban;

        return $this;
    }

    /**
     * Get ban
     *
     * @return bool
     */
    public function getBan()
    {
        return $this->ban;
    }

    /**
     * Set dban
     *
     * @param \DateTime $dban
     *
     * @return fuser
     */
    public function setDban($dban)
    {
        $this->dban = $dban;

        return $this;
    }

    /**
     * Get dban
     *
     * @return \DateTime
     */
    public function getDban()
    {
        return $this->dban;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return fuser
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set fban
     *
     * @param \DateTime $fban
     *
     * @return fuser
     */
    public function setFban($fban)
    {
        $this->fban = $fban;

        return $this;
    }

    /**
     * Get fban
     *
     * @return \DateTime
     */
    public function getFban()
    {
        return $this->fban;
    }
}

