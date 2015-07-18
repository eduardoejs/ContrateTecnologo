<?php

namespace Code\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Silex\Application;
use Code\Sistema\Entity\Responsavel;
use Code\Sistema\Validator\ResponsavelValidator;
use Code\Sistema\Serializer\ResponsavelSerializer;


/**
 * Description of ResponsavelService
 *
 * @author EduardoTI
 */
class ResponsavelService {
    
    private $em;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
    
    public function insert($arrayData, Application $app){
        try {
            $responsavel = new Responsavel();
            $responsavel->setNome($arrayData['nome']);
            $responsavel->setCpf($arrayData['cpf']);
            $responsavel->setEmail($arrayData['email']);
            
            if($arrayData['empresa'] == null){
                throw new \InvalidArgumentException('A Empresa deve ser informada!');
            }            
            $empresa = $this->em->getReference("Code\Sistema\Entity\Empresa", $arrayData['empresa']);                        
            $responsavel->setEmpresa($empresa);
            
            $validator = new ResponsavelValidator($responsavel, $app);
            $erros = $validator->validate();

            if(is_array($erros)){
                return ['ERROS' => $erros];
            }
            
            $this->em->persist($responsavel);
            $this->em->flush();
        } catch (\Doctrine\DBAL\DBALException $exc) {            
            $erros[] = ['Campo' => $exc->getPrevious()->getMessage()];
            return ['ERROS' => $erros];            
        }
    }
    
    public function update($arrayData, Application $app){
        try {            
            $responsavel = new Responsavel();
            
            $responsavel = $this->em->getReference("Code\Sistema\Entity\Responsavel", $arrayData['id']);
            $empresa = $this->em->getReference("Code\Sistema\Entity\Empresa", $arrayData['empresa']);
            
            $responsavel->setNome($arrayData['nome']);
            $responsavel->setCpf($arrayData['cpf']);
            $responsavel->setEmail($arrayData['email']);            
            $responsavel->setEmpresa($empresa);
            
            $validator = new ResponsavelValidator($responsavel, $app);
            $erros = $validator->validate();

            if(is_array($erros)){
                return ['ERROS' => $erros];
            }            
            $this->em->persist($responsavel);
            $this->em->flush();
        } catch (\Doctrine\DBAL\DBALException $exc) {            
            $erros[] = ['Campo' => $exc->getPrevious()->getMessage()];
            return ['ERROS' => $erros];            
        }
    }
    
    public function findById($id){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Responsavel')->find($id);

        $responsaveis = [];
        if($repository != null){            
            $serializer = new ResponsavelSerializer($repository);
            $responsaveis[] = $serializer->serialize();            
        }
        return $responsaveis;
    }
    
    public function pesquisar($page, $limitRegs, $search, $empresa_id){
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;        
        $repository = $this->em->getRepository('Code\Sistema\Entity\Responsavel')->pesquisarResponsavel($inicial, $limitRegs, $search, $empresa_id);        
        return $repository;
    }

    public function getCountResponsavel($empresa_id, $search){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Responsavel')->listarNumResponsaveis($empresa_id, $search);
        return count($repository);
    }
    
    public function getResponsavel($page, $limitRegs, $empresa_id){
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;
        $repository = $this->em->getRepository('Code\Sistema\Entity\Responsavel')->listarResponsaveis($inicial, $limitRegs, $empresa_id);

        $responsaveis = [];
        foreach ($repository as $responsavel){
            $serializer = new ResponsavelSerializer($responsavel);
            $responsaveis[] = $serializer->serialize();
        }
        return $responsaveis;
    }
}
