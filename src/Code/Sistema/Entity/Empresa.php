<?php

namespace Code\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe que representa as empresas parceiras
 *
 * @author eduardo
 */

/**
 * @ORM\Entity(repositoryClass="Code\Sistema\EntityRepository\EmpresaRepository")
 * @ORM\Table(name="contrate_empresas")
 * @ORM\HasLifecycleCallbacks
 */
class Empresa {
    
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
     * @ORM\Column(type="string", length=255, name="endereco", nullable=false)     
     */
    private $endereco;
    
    /**
     * @ORM\Column(type="string", length=155, name="cidade", nullable=false)     
     */
    private $cidade;
    
    /**
     * @ORM\Column(type="string", length=2, name="estado", nullable=false)     
     */
    private $estado;
    
    /**
     * @ORM\Column(type="string", length=14, name="fone", nullable=false)     
     */
    private $fone;
        
    /**
     * @ORM\Column(type="string", length=255, name="email", nullable=false)     
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", length=50, nullable=true)
     */
    private $createdAt;
    
    /**
     * @ORM\Column(type="datetime", length=50, nullable=true)
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

    public function getEndereco() {
        return $this->endereco;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFone() {
        return $this->fone;
    }

    public function getEmail() {
        return $this->email;
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

    public function setEndereco($endereco) {
        $this->endereco = $endereco;
        return $this;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
        return $this;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
        return $this;
    }

    public function setFone($fone) {
        $this->fone = $fone;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }
        
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt() {
        $this->createdAt = new \Datetime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \Datetime();
    }
    
    public function __toString(){
        return $this->nome;
    }
}