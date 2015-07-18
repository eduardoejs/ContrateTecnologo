<?php

namespace Code\Sistema\Validator;

use Code\Sistema\Entity\Empresa;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;

/**
 * Validação de dados do objeto
 *
 * @author eduardo
 */

class EmpresaValidator {

    private $empresa;
    private $app;

    public function __construct(Empresa $empresa, Application $app) {
        $this->empresa = $empresa;
        $this->app = $app;

        $metadata = $this->app['validator.mapping.class_metadata_factory']->getMetadataFor('\Code\Sistema\Entity\Empresa');
        $metadata->addPropertyConstraint('nome', new Assert\NotBlank(array('message' => 'O nome da empresa não foi informado')));        
        $metadata->addPropertyConstraint('endereco', new Assert\NotBlank(array('message' => 'O endereço não foi informado')));
        $metadata->addPropertyConstraint('cidade', new Assert\NotBlank(array('message' => 'A cidade não foi informada')));
        $metadata->addPropertyConstraint('estado', new Assert\NotBlank(array('message' => 'O estado não foi informado')));
        $metadata->addPropertyConstraint('fone', new Assert\NotBlank(array('message' => 'O telefone não foi informado')));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank(array('message' => 'O email não foi informado')));
        $metadata->addPropertyConstraint('email', new Assert\Email(array('message' => 'O email informado é inválido!')));
    }

    public function validate(){
        $arrayErros = [];
        $erros = $this->app['validator']->validate($this->empresa);

        if(count($erros) > 0){
          foreach ($erros as $erro) {
            $arrayErros[] = ['Campo' => $erro->getMessage()];
          }
          return $arrayErros;
        }     
    }
}