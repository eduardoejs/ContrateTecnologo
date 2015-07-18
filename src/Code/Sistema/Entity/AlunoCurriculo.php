<?php

namespace Code\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AlunoCurriculo
 *
 * @author EduardoTI
 */
/**
 * @ORM\Entity(repositoryClass="Code\Sistema\EntityRepository\AlunoRepository")
 * @ORM\Table(name="contrate_curriculos")
 * @ORM\HasLifecycleCallbacks
 */
class AlunoCurriculo {
    
    /**     
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue 
     */
    private $id;
    
    /**
     * @ORM\OneToOne(targetEntity="Code\Sistema\Entity\Aluno")
     * @ORM\JoinColumn(name="aluno", referencedColumnName="id")
     */
    private $aluno;
    
    /**          
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $lattesUrl;
    
    /**          
     * @ORM\Column(type="text", nullable=true)     
     */
    private $resumoProfissional;
    
    /**          
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $formacaoA1;
    
    /**          
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $formacaoA2;
    
    /**          
     * @ORM\Column(type="string", length=255, nullable=true)     
     */
    private $formacaoA3;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $inicioA1;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $inicioA2;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $inicioA3;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $conclusaoA1;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $conclusaoA2;
    
    /**          
     * @ORM\Column(type="date", nullable=true)     
     */
    private $conclusaoA3;
    
    /**          
     * @ORM\Column(type="datetime", nullable=true)     
     */
    private $createdAt;
    
    /**          
     * @ORM\Column(type="datetime", nullable=true)     
     */
    private $updatedAt;
 
    public function getId() {
        return $this->id;
    }
    
    public function getAluno(){
        return $this->aluno;
    }

    public function getLattesUrl() {
        return $this->lattesUrl;
    }

    public function getResumoProfissional() {
        return $this->resumoProfissional;
    }

    public function getFormacaoA1() {
        return $this->formacaoA1;
    }

    public function getFormacaoA2() {
        return $this->formacaoA2;
    }

    public function getFormacaoA3() {
        return $this->formacaoA3;
    }

    public function getInicioA1() {
        return $this->inicioA1;
    }

    public function getInicioA2() {
        return $this->inicioA2;
    }

    public function getInicioA3() {
        return $this->inicioA3;
    }

    public function getConclusaoA1() {
        return $this->conclusaoA1;
    }

    public function getConclusaoA2() {
        return $this->conclusaoA2;
    }

    public function getConclusaoA3() {
        return $this->conclusaoA3;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    public function setAluno(Aluno $aluno){
        $this->aluno = $aluno;
    }

    public function setLattesUrl($lattesUrl) {
        $this->lattesUrl = $lattesUrl;
        return $this;
    }

    public function setResumoProfissional($resumoProfissional) {
        $this->resumoProfissional = $resumoProfissional;
        return $this;
    }

    public function setFormacaoA1($formacaoA1) {
        $this->formacaoA1 = $formacaoA1;
        return $this;
    }

    public function setFormacaoA2($formacaoA2) {
        $this->formacaoA2 = $formacaoA2;
        return $this;
    }

    public function setFormacaoA3($formacaoA3) {
        $this->formacaoA3 = $formacaoA3;
        return $this;
    }

    public function setInicioA1($inicioA1) {
        $this->inicioA1 = $inicioA1;
        return $this;
    }

    public function setInicioA2($inicioA2) {
        $this->inicioA2 = $inicioA2;
        return $this;
    }

    public function setInicioA3($inicioA3) {
        $this->inicioA3 = $inicioA3;
        return $this;
    }

    public function setConclusaoA1($conclusaoA1) {
        $this->conclusaoA1 = $conclusaoA1;
        return $this;
    }

    public function setConclusaoA2($conclusaoA2) {
        $this->conclusaoA2 = $conclusaoA2;
        return $this;
    }

    public function setConclusaoA3($conclusaoA3) {
        $this->conclusaoA3 = $conclusaoA3;
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
        $this->updatedAt = new \Datetime();        
    }
}
