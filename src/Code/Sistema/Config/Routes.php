<?php

namespace Code\Sistema\Config;

use Silex\Application;
use Doctrine\ORM\EntityManager;

use Code\Sistema\Controller\EmpresaController;
use Code\Sistema\Controller\AlunoController;
use Code\Sistema\Controller\AdminController;

/**
 * Classe onde é definida as rotas juntamente com seus controllers
 *
 * @author eduardo
 */

class Routes {
    
    public function init(Application $app, EntityManager $em){
        $app->mount('/empresa', new EmpresaController());
        $app->mount('/aluno', new AlunoController());
        $app->mount('/administrador', new AdminController());
    }
}