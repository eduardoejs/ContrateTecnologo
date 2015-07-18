<?php

namespace Code\Sistema\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Silex\Application;
use Code\Sistema\Entity\Curso;

/**
 * Validação de dados do objeto
 *
 * @author eduardo
 */

class CursoValidator {

    private $curso;
    private $app;

    public function __construct(Curso $curso, Application $app) {
        $this->curso = $curso;
        $this->app = $app;

        $metadata = $this->app['validator.mapping.class_metadata_factory']->getMetadataFor('\Code\Sistema\Entity\Curso');
        $metadata->addPropertyConstraint('nome', new Assert\NotBlank(array('message' => 'O nome do curso não foi informado')));
    }

    public function validate(){
        $arrayErros = [];
        $erros = $this->app['validator']->validate($this->curso);

        if(count($erros) > 0){
          foreach ($erros as $erro) {
            $arrayErros[] = ['Campo' => $erro->getMessage()];
          }
          return $arrayErros;
        }     
    }
}