<?php

namespace Code\Sistema\Serializer;

use Code\Sistema\Entity\Responsavel;

/**
 * Description of ResponsavelSerializer
 *
 * @author EduardoTI
 */
class ResponsavelSerializer {
    
    private $responsavel;
    
    public function __construct(Responsavel $responsavel){
        $this->responsavel = $responsavel;
    }
    
    public function serialize(){
        $responsavel['id'] = $this->responsavel->getId();                
        $responsavel['nome'] = $this->responsavel->getNome();
        $responsavel['cpf'] = $this->responsavel->getCpf();
        $responsavel['email'] = $this->responsavel->getEmail();
        if(!is_null($this->responsavel->getEmpresa())){
            $empresaSerialize = new EmpresaSerializer($this->responsavel->getEmpresa());
            $responsavel['empresa'] = $empresaSerialize->serialize();            
        }else{
            $responsavel['empresa'] = null;
        }
        $responsavel['createdAt'] = $this->responsavel->getCreatedAt();
        $responsavel['updatedAt'] = $this->responsavel->getUpdatedAt();
        return $responsavel;
    }
}
