<?php

namespace Code\Sistema\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AlunoController
 *
 * @author eduardo
 */
class AlunoController implements ControllerProviderInterface{
    
    public function connect(Application $app) {
        $controller = $app['controllers_factory'];
        
        return $controller;
    }
}
