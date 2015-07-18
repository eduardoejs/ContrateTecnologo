<?php

namespace Code\Sistema\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of ResponsavelRepository
 *
 * @author EduardoTI
 */
class ResponsavelRepository extends EntityRepository{
    
    public function pesquisarResponsavel($inicio, $limit, $busca, $empresa_id){
        return $this
                ->createQueryBuilder("r")
                ->leftJoin('r.empresa', 'e')
                ->where('r.nome LIKE :busca')
                ->andWhere('e.id = :empresa_id')
                ->setParameter('busca', "%{$busca}%")
                ->setParameter('empresa_id', $empresa_id)
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }    
    
    public function pesquisarNumResponsavel($busca, $empresa_id){
        return $this
                ->createQueryBuilder("r")
                 ->leftJoin('r.empresa', 'e')
                ->where('r.nome LIKE :busca')
                ->setParameter('busca', "%{$busca}%") 
                ->andWhere('e.empresa = :empresa_id')
                ->setParameter('empresa_id', $empresa_id)
                ->getQuery()
                ->getResult();
    } 
    
    public function listarResponsaveis($inicio, $limit, $empresa_id){
        return $this
                ->createQueryBuilder("r")
                ->leftJoin('r.empresa', 'e')
                ->where('r.empresa = :empresa_id')
                ->setParameter('empresa_id', $empresa_id)
                ->setFirstResult($inicio)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
    }
    
    public function listarNumResponsaveis($empresa_id, $search){
        return $this
                ->createQueryBuilder("r")
                ->leftJoin('r.empresa', 'e')
                ->where('r.empresa = :empresa_id')
                ->andWhere('r.nome LIKE :busca')
                ->setParameter('empresa_id', $empresa_id)
                ->setParameter('busca', "%{$search}%") 
                ->getQuery()
                ->getResult();
    }
}
