<?php

namespace Code\Sistema\EntityRepository;
use Doctrine\ORM\EntityRepository;

/**
 * Description of CurriculumRepository
 *
 * @author eduardo
 */
class CurriculumRepository extends EntityRepository{
    
    public function searchCurriculo($nome){
        return $this
                ->createQueryBuilder("c")
                ->where('c.nome LIKE :busca')
                ->setParameter('busca', "%{$nome}%")
                ->getQuery()
                ->getResult();
    }
}