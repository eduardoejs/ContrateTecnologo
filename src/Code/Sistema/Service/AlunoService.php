<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Code\Sistema\Service;

use Silex\Application;
use Doctrine\ORM\EntityManager;
use Code\Sistema\Entity\Aluno;
use Code\Sistema\Entity\AlunoCurriculo;
use Code\Sistema\Serializer\AlunoSerializer;
use Code\Sistema\Helper\DateHelper;
/**
 * Description of AlunoService
 *
 * @author EduardoTI
 */
class AlunoService {
    
    private $em;
    
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    
    public function importarCSV(\Symfony\Component\HttpFoundation\File\UploadedFile $arquivo){
        $this->em->beginTransaction();
        $arquivo_nome = null;
        try{             
            $arquivo = $arquivo;            
            if(!in_array($arquivo->getClientOriginalExtension(), ['csv'])){
                return 'Tipo de arquivo inválido';
            }
            
            $arquivo_nome = sha1($arquivo->getClientOriginalName().date('Y-m-d H:i:s')).'.'.$arquivo->getClientOriginalExtension();
            $arquivo->move(__DIR__ . '/../../../../public/uploads/csv', $arquivo_nome);            
            
            $row = 0;            
            $handle = fopen(__DIR__ . '/../../../../public/uploads/csv/'.$arquivo_nome, 'r');
            while($arrayData = fgetcsv($handle, 1000, ';')){                   
                if($row > 0){
                    $aluno = new Aluno();
                    $aluno->setRa($arrayData[0]);
                    $aluno->setNome($arrayData[1]);
                    $aluno->setCpf($arrayData[2]);
                    $aluno->setSexo($arrayData[3]);                    
                    $aluno->setDataNasc(new \DateTime(DateHelper::setDate($arrayData[4])));
                    $aluno->setEstadoCivil(null);
                    $aluno->setNacionalidade(null);
                    $aluno->setFilhos(0);
                    $aluno->setEmail($arrayData[5]);
                    $aluno->setFone1(null);
                    $aluno->setFone2(null);
                    $aluno->setFile(null);
                    
                    $curso = $this->em->getReference("Code\Sistema\Entity\Curso", $arrayData[6]);
                    $aluno->setCurso($curso);
                    $aluno->setTermo($arrayData[7]);
                    $aluno->setPeriodo($arrayData[8]);
                    $aluno->setDataInicio(null);
                    $aluno->setDataConclusao(null);
                    
                    $this->em->persist($aluno);                                        
                    
                    // Insert do Currículo
                    $cv = new AlunoCurriculo();
                    $cv->setAluno($aluno);            
                    $cv->setLattesUrl(null);
                    $cv->setResumoProfissional(null);
                    $cv->setFormacaoA1(null);
                    $cv->setFormacaoA2(null);
                    $cv->setFormacaoA3(null);
                    $cv->setInicioA1(null);
                    $cv->setInicioA2(null);
                    $cv->setInicioA3(null);
                    $cv->setConclusaoA1(null);
                    $cv->setConclusaoA2(null);
                    $cv->setConclusaoA3(null);

                    $this->em->persist($cv);
                    
                }
                $row++;
            }
            
            fclose($handle);            
            unlink(__DIR__ . '/../../../../public/uploads/csv/'.$arquivo_nome);
            
            $this->em->flush();
            $this->em->commit();
        }catch (\Doctrine\DBAL\DBALException $ex) {
            $this->em->rollback();
            if($arquivo_nome != null and file_exists(__DIR__ . '/../../../../public/uploads/csv/'.$arquivo_nome)){
                unlink(__DIR__ . '/../../../../public/uploads/csv/'.$arquivo_nome);
            }
            $erros[] = ['Campo' => $ex->getPrevious()->getMessage()];
            return ['ERROS' => $erros];
        }        
    }

    public function insert($arrayData, Application $app){
        $this->em->beginTransaction();
        try {
            $aluno = new Aluno();
            $aluno->setRa($arrayData['ra']);
            $aluno->setNome($arrayData['nome']);
            $aluno->setCpf($arrayData['cpf']);
            $aluno->setSexo($arrayData['sexo']);
            $aluno->setDataNasc($arrayData['dataNasc']);
            $aluno->setEstadoCivil($arrayData['estadoCivil']);
            $aluno->setNacionalidade($arrayData['nacionalidade']);
            $aluno->setFilhos($arrayData['filhos']);
            $aluno->setEmail($arrayData['email']);
            $aluno->setFone1($arrayData['fone1']);
            $aluno->setFone2($arrayData['fone2']);
            $aluno->setFile($arrayData['foto']);
            
            $curso = $this->em->getReference('Code\Sistema\Entity\Curso', $arrayData['curso']);
            $aluno->setCurso($curso);
            
            $aluno->setTermo($arrayData['termo']);
            $aluno->setPeriodo($arrayData['periodo']);
            $aluno->setDataInicio($arrayData['dataInicio']);
            $aluno->setDataConclusao($arrayData['dataConclusao']);            
                        
            $this->em->persist($aluno);
            $this->em->flush();
            
            // Insert do Currículo
            $cv = new AlunoCurriculo();
            $cv->setAluno($aluno);            
            $cv->setLattesUrl($arrayData['lattes']);
            $cv->setResumoProfissional($arrayData['resumoProfissional']);
            $cv->setFormacaoA1($arrayData['fa1']);
            $cv->setFormacaoA2($arrayData['fa2']);
            $cv->setFormacaoA3($arrayData['fa3']);
            $cv->setInicioA1($arrayData['ia1']);
            $cv->setInicioA2($arrayData['ia2']);
            $cv->setInicioA3($arrayData['ia3']);
            $cv->setConclusaoA1($arrayData['ca1']);
            $cv->setConclusaoA2($arrayData['ca2']);
            $cv->setConclusaoA3($arrayData['ca3']);
            
            $this->em->persist($cv);
            $this->em->flush();
            
            $this->em->commit();
        } catch (Exception $exc) {
            $this->em->rollback();
            echo $exc->getTraceAsString();
        }
    }
    
    public function getCountAlunos(){
        $repository = $this->em->getRepository('Code\Sistema\Entity\Aluno')->findAll();
        return count($repository);
    }
    
    public function getAlunos($page, $limitRegs){        
        $inicial = ($page > 1) ? ($page - 1) * $limitRegs : 0;
        $repository = $this->em->getRepository('Code\Sistema\Entity\Aluno')->listarAlunos($inicial, $limitRegs);

        $alunos = [];
        foreach ($repository as $aluno){
            $serializer = new AlunoSerializer($aluno);
            $alunos[] = $serializer->serialize();
        }
        return $alunos;
    }

    static public function uploadImage(Aluno $aluno){
        if(null === $aluno->getFile()){
            return;
        }
        
        if(!in_array($aluno->getFile()->getClientOriginalExtension(), $aluno->getUploadAcceptedTypes())){
            throw new \InvalidArgumentException('Tipo de arquivo não permitido');
        }
        
        $filename = sha1($aluno->getFile()->getClientOriginalName() . date('Y-m-d H:i:s')) . '.' . $aluno->getFile()->getClientOriginalExtension();        
        $aluno->getFile()->move($aluno->getUploadRootDir(), $filename);
        return $filename;
    }
    
    static public function removeImage(Aluno $aluno){
        if(null === $aluno->getFoto()){
            return;
        }
        
        if(file_exists($aluno->getAbsolutePath())){
            unlink($aluno->getAbsolutePath());
        }
        return true;
    }
}
