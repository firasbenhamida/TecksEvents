<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\commentaireRepository")
 */
class commentaire
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
     * @ORM\Column(name="id_q", type="integer")
     */
    private $idQ;

    /**
     * @var int
     *
     * @ORM\Column(name="id_r", type="integer")
     */
    private $idR;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * Set idQ
     *
     * @param integer $idQ
     *
     * @return commentaire
     */
    public function setIdQ($idQ)
    {
        $this->idQ = $idQ;

        return $this;
    }

    /**
     * Get idQ
     *
     * @return int
     */
    public function getIdQ()
    {
        return $this->idQ;
    }

    /**
     * Set idR
     *
     * @param integer $idR
     *
     * @return commentaire
     */
    public function setIdR($idR)
    {
        $this->idR = $idR;

        return $this;
    }

    /**
     * Get idR
     *
     * @return int
     */
    public function getIdR()
    {
        return $this->idR;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return commentaire
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return commentaire
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Question
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id_m", type="integer")
     */
    private $idM;


    /**
     * Set idM
     *
     * @param integer $idM
     *
     * @return commentaire
     */
    public function setIdM($idM)
    {
        $this->idM = $idM;

        return $this;
    }

    /**
     * Get idM
     *
     * @return int
     */
    public function getIdM()
    {
        return $this->idM;
    }
}

