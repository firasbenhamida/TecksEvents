<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\reponseRepository")
 */
class reponse
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
     * @ORM\Column(name="id_m", type="integer")
     */
    private $idM;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * Set nom
     *
     * @param string $titre
     *
     * @return Question
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
     * @return reponse
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
     * Set idM
     *
     * @param integer $idM
     *
     * @return reponse
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return reponse
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

}

