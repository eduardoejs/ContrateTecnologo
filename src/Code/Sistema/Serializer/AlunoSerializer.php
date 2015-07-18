<?php

namespace Code\Sistema\Serializer;

use Code\Sistema\Entity\Aluno;
/**
 * Description of AlunoSerializer
 *
 * @author EduardoTI
 */
class AlunoSerializer {
    
    private $aluno;
    
    public function __construct(Aluno $aluno){
        $this->aluno = $aluno;
    }
    
    public function serialize(){
        
        $aluno['id'] = $this->aluno->getId();
        $aluno['ra'] = $this->aluno->getRa();
        $aluno['nome'] = $this->aluno->getNome();
        $aluno['cpf'] = $this->aluno->getCpf();
        $aluno['sexo'] = $this->aluno->getSexo();
        $aluno['dataNasc'] = $this->aluno->getDataNasc();
        $aluno['estadoCivil'] = $this->aluno->getEstadoCivil();
        $aluno['nacionalidade'] = $this->aluno->getNacionalidade();
        $aluno['filhos'] = $this->aluno->getFilhos();
        $aluno['email'] = $this->aluno->getEmail();
        $aluno['fone1'] = $this->aluno->getFone1();
        $aluno['fone2'] = $this->aluno->getFone2();
        
        if(!is_null($this->aluno->getCurso())){
            $cursoSerialize = new CursoSerializer($this->aluno->getCurso());
            $aluno['curso'] = $cursoSerialize->serialize();            
        }else{
            $aluno['curso'] = null;
        }
        
        $aluno['termo'] = $this->aluno->getTermo();
        $aluno['periodo'] = $this->aluno->getPeriodo();
        $aluno['dataInicio'] = $this->aluno->getDataInicio();
        $aluno['dataConclusao'] = $this->aluno->getDataConclusao();
        $aluno['foto'] = $this->aluno->getFoto();
        $aluno['createdAt'] = $this->aluno->getCreatedAt();
        $aluno['updatedAt'] = $this->aluno->getUpdatedAt();
        
        return $aluno;
    }
}
