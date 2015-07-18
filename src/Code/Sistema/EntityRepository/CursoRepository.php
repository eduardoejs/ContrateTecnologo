<?php

namespace Code\Sistema\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository de Cursos. Métodos DQL ou QueryBuilder
 *
 * @author eduardo
 */
class CursoRepository extends EntityRepository{
    
    public function pesquisarCurso($inicio, $limit, $busca){
        return $this
                ->createQueryBuilder("c")
                ->where('c.nome LIKE :busca')
                ->setParameter('busca', "%{$busca}%")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }    
    
    public function pesquisarNumCurso($busca){
        return $this
                ->createQueryBuilder("c")
                ->where('c.nome LIKE :busca')
                ->setParameter('busca', "%{$busca}%")                
                ->getQuery()
                ->getResult();
    } 
    
    public function listarCursos($inicio, $limit){
        return $this
                ->createQueryBuilder("C")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }
}