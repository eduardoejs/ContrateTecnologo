<?php

namespace Code\Sistema\Validator;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Code\Sistema\Validator\Constraints\CpfCnpjValidator as AssertCpf;
use Code\Sistema\Entity\Responsavel;
/**
 * Description of ResponsavelValidator
 *
 * @author EduardoTI
 */
class ResponsavelValidator {
    
    private $responsavel;
    private $app;
        
    public function __construct(Responsavel $responsavel, Application $app) {
        $this->responsavel = $responsavel;
        $this->app = $app;
        
        $metadata = $this->app['validator.mapping.class_metadata_factory']->getMetadataFor('\Code\Sistema\Entity\Responsavel');
        $metadata->addPropertyConstraint('nome', new Assert\NotBlank(array('message' => 'O nome do responsável não foi informado')));
        $metadata->addPropertyConstraint('cpf', new Assert\NotBlank(array('message' => 'O CPF do responsável não foi informado')));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank(array('message' => 'O Email do responsável não foi informado')));
        $metadata->addPropertyConstraint('email', new Assert\Email(array('message' => 'O email informado é inválido')));            
    }
    
    public function validate(){
        $arrayErros = [];
        $erros = $this->app['validator']->validate($this->responsavel);
        
        if(count($erros) > 0){
          foreach ($erros as $erro) {
            $arrayErros[] = ['Campo' => $erro->getMessage()];
          }
          return $arrayErros;
        }     
    }
}
