<?php

namespace Code\Sistema\Service;

use Doctrine\ORM\EntityManager;
use Code\Sistema\Entity\Curso;
use Code\Sistema\Validator\CursoValidator;
use Code\Sistema\Serializer\CursoSerializer;
use Silex\Application;

/**
 * Service: CRUD e Selects
 *
 * @author eduardo
 */

class CursoService {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function insert($arrayData, Application $app){
        try {
            $curso = new Curso();
            $curso->setNome($arrayData['nome']);
            
            $validator = new CursoValidator($curso, $app);
            $erros = $validator->validate();
            if(is_array($erros)){
                return ['ERROS' => $erros];
            }            
            $this->em->persist($curso);
            $this->em->flush();            
        } catch (Exception $exc) {
            return ['ERROS' => $exc->getMessage()];
        }
    }

    public function update($arrayData, Application $app){
        try {
            $curso = new Curso();
            $curso = $this->em->getReference('Code\Sistema\Entity\Curso', $arrayData['id']);
            $curso->setNome($arrayData['nome']);

            $validator = new CursoValidator($curso, $app);
            $erros = $validator->validate();

            if(is_array($erros)){
                return ['Erros' => $erros];
            }

            $this->em->persist($curso);
            $this->em->flush();
            return ['OK' => 'Registro alterado com sucesso!'];

        } catch (Exception $exc) {
            return ['Erros' => $exc->getMessage()];
        }
    }

    public function delete($id){
        try {
            $curso = $this->em->getReference('Code\Sistema\Entity\Curso', $id);
            $this->em->remove($curso);
            $this->em->flush();
            return $curso;
        } catch (Exception $exc) {
            return ['Erros' => $exc->getMessage()];
        }
    }

    public function getCursos($page, $limitRegs){        
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;
        $repository = $this->em->getRepository('Code\Sistema\Entity\Curso')->listarCursos($inicial, $limitRegs);

        $cursos = [];
        foreach ($repository as $curso){
            $serializer = new CursoSerializer($curso);
            $cursos[] = $serializer->serialize();
        }
        return $cursos;
    }

    public function findById($id){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Curso')->find($id);

        $curso = [];
        if($repository != null){            
            $serializer = new CursoSerializer($repository);
            $curso[] = $serializer->serialize();            
        }
        return $curso;
    }

    //Retorna quantidade de registros no DB
    public function getCountCursos(){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Curso')->findAll();
        return count($repository);
    }
    
    //Retorna quantidade de registros após uma consulta
    public function getCountPesquisa($search){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Curso')->pesquisarNumCurso($search);
        return count($repository);
    }

    public function pesquisar($page, $limitRegs, $search){
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;        
        $repository = $this->em->getRepository('Code\Sistema\Entity\Curso')->pesquisarCurso($inicial, $limitRegs, $search);
        
        return $repository;
    }
}