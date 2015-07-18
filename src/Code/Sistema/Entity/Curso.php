<?php

namespace Code\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe que representa os cursos da instituição
 *
 * @author eduardo
 */

/**
 * @ORM\Entity(repositoryClass="Code\Sistema\EntityRepository\CursoRepository")
 * @ORM\Table(name="contrate_cursos")
 * @ORM\HasLifecycleCallbacks
 */
class Curso {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="nome", nullable=false)
     */
    private $nome;

    /**
     * @ORM\Column(type="datetime", length=100, nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", length=100, nullable=true)
     */
    private $updatedAt;

    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt() {
        $this->createdAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime();
    }

    public function __toString(){
        return $this->getNome();
    }
}