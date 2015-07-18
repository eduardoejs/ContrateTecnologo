<?php

namespace Code\Sistema\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Code\Sistema\Service\AlunoService;

/**
 * Description of Aluno
 *
 * @author EduardoTI
 */
/**
 * @ORM\Entity(repositoryClass="Code\Sistema\EntityRepository\AlunoRepository")
 * @ORM\Table(name="contrate_alunos")
 * @ORM\HasLifecycleCallbacks
 */
class Aluno {
    
    /**     
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue 
     */
    private $id;
    
    /**
    * @ORM\Column(type="string", length=40, nullable=false, unique=true)
    */
    private $ra;
    
    /**
    * @ORM\Column(type="string", length=255, nullable=false)
    */
    private $nome;
    
    /**
    * @ORM\Column(type="string", length=14, nullable=false)
    */
    private $cpf;
    
    /**
    * @ORM\Column(type="string", length=1, nullable=false)
    */
    private $sexo;
    
    /**
    * @ORM\Column(type="date", nullable=true)
    */
    private $dataNasc;
    
    /**
    * @ORM\Column(type="string", length=1, nullable=true)
    */
    private $estadoCivil;
    
    /**
    * @ORM\Column(type="string", length=100, nullable=true)
    */
    private $nacionalidade;
    
    /**
    * @ORM\Column(type="string", length=1, nullable=false)
    */
    private $filhos;
    
    /**
    * @ORM\Column(type="string", length=255, nullable=false)
    */
    private $email;
    
    /**
    * @ORM\Column(type="string", length=15, nullable=true)
    */
    private $fone1;
    
    /**
    * @ORM\Column(type="string", length=15, nullable=true)
    */
    private $fone2;
    
    /**
    * @ORM\ManyToOne(targetEntity="Code\Sistema\Entity\Curso")
    * @ORM\JoinColumn(name="curso_id", referencedColumnName="id", onDelete="SET NULL")
    */
    private $curso;
    
    /**
    * @ORM\Column(type="integer", length=1, nullable=false)
    */
    private $termo;
    
    /**
    * @ORM\Column(type="string", length=1, nullable=false)
    */
    private $periodo;
    
    /**
    * @ORM\Column(type="date", nullable=true)
    */
    private $dataInicio;
    
    /**
    * @ORM\Column(type="date", nullable=true)
    */
    private $dataConclusao;
    
    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $foto;
    
    private $file;
    
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

    public function getRa() {
        return $this->ra;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getDataNasc() {
        return $this->dataNasc;
    }

    public function getEstadoCivil() {
        return $this->estadoCivil;
    }

    public function getNacionalidade() {
        return $this->nacionalidade;
    }

    public function getFilhos() {
        return $this->filhos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFone1() {
        return $this->fone1;
    }

    public function getFone2() {
        return $this->fone2;
    }

    public function getCurso() {
        return $this->curso;
    }

    public function getTermo() {
        return $this->termo;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getDataConclusao() {
        return $this->dataConclusao;
    }
    
    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setRa($ra) {
        $this->ra = $ra;
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

    public function setSexo($sexo) {
        $this->sexo = $sexo;
        return $this;
    }

    public function setDataNasc($dataNasc) {
        $this->dataNasc = $dataNasc;
        return $this;
    }

    public function setEstadoCivil($estadoCivil) {
        $this->estadoCivil = $estadoCivil;
        return $this;
    }

    public function setNacionalidade($nacionalidade) {
        $this->nacionalidade = $nacionalidade;
        return $this;
    }

    public function setFilhos($filhos) {
        $this->filhos = $filhos;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setFone1($fone1) {
        $this->fone1 = $fone1;
        return $this;
    }

    public function setFone2($fone2) {
        $this->fone2 = $fone2;
        return $this;
    }

    public function setCurso(Curso $curso) {
        $this->curso = $curso;        
    }

    public function setTermo($termo) {
        $this->termo = $termo;
        return $this;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
        return $this;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    public function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
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
    
    public function getFoto() {
        return $this->foto;
    }
                
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
    */
    public function criarFoto(){
        if($this->file != null){
            $this->foto = AlunoService::uploadImage($this);
        }
    }
    
    public function removerFoto(){
        return AlunoService::removeImage($this);
    }
    
    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;        
    }
    
    public function getAbsolutePath(){
        return null === $this->foto ? null : $this->getUploadRootDir() . '/' . $this->foto;
    }
    
    public function getWebPath(){
        return null === $this->foto ? null : $this->getUploadDir() . '/' . $this->foto;
    }
    
    public function getUploadRootDir(){
        return __DIR__ . '/../../../../public/' . $this->getUploadDir();
    }
    
    public function getUploadDir(){
        return 'upload/fotos';
    }
    
    public function getUploadAcceptedTypes(){
        return ['jpg', 'jpeg', 'png'];
    }
}