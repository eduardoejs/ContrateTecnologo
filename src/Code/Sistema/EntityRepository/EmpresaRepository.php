<?php

namespace Code\Sistema\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Repository de Empresas. Métodos DQL ou QueryBuilder
 *
 * @author eduardo
 */
class EmpresaRepository extends EntityRepository{
    
    public function pesquisarEmpresa($inicio, $limit, $busca){
        return $this
                ->createQueryBuilder("e")
                ->where('e.nome LIKE :busca')
                ->setParameter('busca', "%{$busca}%")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }    
    
    public function pesquisarNumEmpresa($busca){
        return $this
                ->createQueryBuilder("e")
                ->where('e.nome LIKE :busca')
                ->setParameter('busca', "%{$busca}%")                
                ->getQuery()
                ->getResult();
    } 
    
    public function listarEmpresas($inicio, $limit){
        return $this
                ->createQueryBuilder("e")
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }
}