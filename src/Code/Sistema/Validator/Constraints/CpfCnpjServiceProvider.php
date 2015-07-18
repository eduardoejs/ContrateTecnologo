<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Code\Sistema\Validator\Constraints;

/**
 * Description of CpfCnpjServiceProvider
 *
 * @author EduardoTI
 */
class CpfCnpjServiceProvider implements \Silex\ServiceProviderInterface {
    
    public function register(\Silex\Application $app) {
        $app['cpf_validator'] = $app->share(function ($app) {
            return new CpfCnpjValidator();
        });
    }
    
    public function boot(\Silex\Application $app) {
        
    }
}
