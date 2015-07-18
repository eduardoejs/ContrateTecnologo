<?php

namespace Code\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Context\ExecutionContext;
use Symfony\Component\Validator\Constraints\Callback;
/**
 * Classe que representa as pessoas responsáveis pela seleção de currículos
 *
 * @author eduardo
 */

/**
 * @ORM\Entity(repositoryClass="Code\Sistema\EntityRepository\ResponsavelRepository")
 * @ORM\Table(name="contrate_responsaveis")
 * @ORM\HasLifecycleCallbacks
 */
class Responsavel{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**     
     * @ORM\Column(type="string", length=255, nullable=false)     
     */
    private $nome;

    /**     
     * @ORM\Column(type="string", length=15, nullable=false, unique=true)
     */
    private $cpf;

    /**
    * @ORM\ManyToOne(targetEntity="Code\Sistema\Entity\Empresa")
    * @ORM\JoinColumn(name="empresa_id", referencedColumnName="id", onDelete="NO ACTION")
    */    
    private $empresa;

    /**     
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $email;

    /**     
     * @ORM\Column(type="datetime", length=100, nullable=true)     
     */
    private $createdAt;

    /**     
     * @ORM\Column(type="datetime", length=100, nullable=true)     
     */
    private $updatedAt;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getEmpresa() {
        return $this->empresa;
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

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
        return $this;
    }

    public function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
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
        $this->createdAt = new \DateTime();
    }

    /**     
     * @ORM\PreUpdate
     */
    public function setUpdatedAt() {
        $this->updatedAt = new \DateTime();
    }
    
    public function __toString() {
        return $this->nome;
    }    
    
    public function validateCpf(ExecutionContext $context)
    {
        //$context->addViolationAt('cpf', 'CPF inválido');
    }

    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Callback(array('validateCpf')));
        $metadata->addPropertyConstraint('cpf', new \Code\Sistema\Validator\Constraints\CpfCnpj());
    }
}