<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Code\Sistema\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of AlunoRepository
 *
 * @author EduardoTI
 */
class AlunoRepository extends EntityRepository{
        
    public function listarAlunos($inicio, $limit){
        return $this
                ->createQueryBuilder("a")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->orderBy("a.nome")
                ->getQuery()
                ->getResult();
    }
}
