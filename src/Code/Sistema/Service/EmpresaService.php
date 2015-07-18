<?php

namespace Code\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Silex\Application;
use Code\Sistema\Entity\Empresa;
use Code\Sistema\Validator\EmpresaValidator;
use Code\Sistema\Serializer\EmpresaSerializer;

/**
 * Service: CRUD e Selects
 *
 * @author eduardo
 */

class EmpresaService {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function insert($arrayData, Application $app){
        try {
            $empresa = new Empresa();

            $empresa->setNome($arrayData['nome']);
            $empresa->setEndereco($arrayData['endereco']);
            $empresa->setCidade($arrayData['cidade']);
            $empresa->setEstado($arrayData['estado']);
            $empresa->setFone($arrayData['fone']);
            $empresa->setEmail($arrayData['email']);

            $validator = new EmpresaValidator($empresa, $app);
            $erros = $validator->validate();

            if(is_array($erros)){
                return ['ERROS' => $erros];
            }            
            $this->em->persist($empresa);
            $this->em->flush();            
        } catch (\Doctrine\DBAL\DBALException $exc) {            
            $erros[] = ['Campo' => $exc->getPrevious()->getMessage()];
            return ['ERROS' => $erros];            
        }
    }

    public function update($arrayData, Application $app){
        try {
            $empresa = new Empresa();

            $empresa = $this->em->getReference('Code\Sistema\Entity\Empresa', $arrayData['id']);

            $empresa->setNome($arrayData['nome']);
            $empresa->setEndereco($arrayData['endereco']);
            $empresa->setCidade($arrayData['cidade']);
            $empresa->setEstado($arrayData['estado']);
            $empresa->setFone($arrayData['fone']);
            $empresa->setEmail($arrayData['email']);

            $validator = new EmpresaValidator($empresa, $app);
            $erros = $validator->validate();

            if(is_array($erros)){
                return ['Erros' => $erros];
            }

            $this->em->persist($empresa);
            $this->em->flush();
            return ['OK' => 'Registro alterado com sucesso!'];

        } catch (Exception $exc) {
            return ['Erros' => $exc->getMessage()];
        }
    }

    public function delete($id){
        try {
            $empresa = $this->em->getReference('Code\Sistema\Entity\Empresa', $id);
            $this->em->remove($empresa);
            $this->em->flush();            
        } catch (\Doctrine\DBAL\DBALException $exc) {            
            if($exc->getPrevious()->getCode() == 23000)
                return ['Erros' => "Não é possível excluir a empresa, pois ela possui Responsáveis vinculados!"];
            
            return ['Erros' => $exc->getMessage()];            
        }
    }

    public function getEmpresas($page, $limitRegs){        
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;
        $repository = $this->em->getRepository('Code\Sistema\Entity\Empresa')->listarEmpresas($inicial, $limitRegs);

        $empresas = [];
        foreach ($repository as $empresa){
            $serializer = new EmpresaSerializer($empresa);
            $empresas[] = $serializer->serialize();
        }
        return $empresas;
    }

    public function findById($id){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Empresa')->find($id);

        $empresas = [];
        if($repository != null){            
            $serializer = new EmpresaSerializer($repository);
            $empresas[] = $serializer->serialize();            
        }
        return $empresas;
    }

    //Retorna quantidade de registros no DB
    public function getCountEmpresas(){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Empresa')->findAll();
        return count($repository);
    }
    
    //Retorna quantidade de registros após uma consulta
    public function getCountPesquisa($search){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Empresa')->pesquisarNumEmpresa($search);
        return count($repository);
    }

    public function pesquisar($page, $limitRegs, $search){
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;        
        $repository = $this->em->getRepository('Code\Sistema\Entity\Empresa')->pesquisarEmpresa($inicial, $limitRegs, $search);
        
        return $repository;
    }
}