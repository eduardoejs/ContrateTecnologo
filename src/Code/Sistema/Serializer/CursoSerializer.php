<?php

namespace Code\Sistema\Serializer;

use Code\Sistema\Entity\Curso;

/**
 * Serializa o objeto em um array
 *
 * @author eduardo
 */

class CursoSerializer {
    
    private $curso;
    
    public function __construct(Curso $curso) {
        $this->curso = $curso;
    }
    
    public function serialize(){
        $curso['id'] = $this->curso->getId();
        $curso['nome'] = $this->curso->getNome();
        $curso['createdAt'] = $this->curso->getCreatedAt();
        $curso['updatedAt'] = $this->curso->getUpdatedAt();        
        return $curso;
    }    
}