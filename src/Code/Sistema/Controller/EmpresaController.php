<?php

namespace Code\Sistema\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller de Empresas
 *
 * @author eduardo
 */

class EmpresaController implements ControllerProviderInterface{

    public function connect(Application $app) {
        $controller = $app['controllers_factory'];

        $controller->match('/editar/{id}', function(Request $request, $id) use($app){
            return $this->updateAction($app, $request, $id);
        })->bind('edit-empresa')->method('GET|PUT');

        //listar CV
        
        //selecionar CV
        
        //listar Responsaveis Cadastrados
        
        return $controller;
    }

    public function updateAction(Application $app, Request $request, $id){
        if($request->isMethod('PUT')){
            $data['id'] = $id;
            $data['nome'] = $request->get('nome');
            $data['endereco'] = $request->get('endereco');
            $data['cidade'] = $request->get('cidade');
            $data['estado'] = $request->get('estado');
            $data['fone'] = $request->get('fone');
            $data['email'] = $request->get('email');
            $app['empresaService']->update($data, $app);

            return $app->redirect($app['url_generator']->generate('index-empresa'));
        }

        $empresa = $app['empresaService']->findById($id);
        return $app['twig']->render('empresa/editar.twig', ['empresa' => $empresa]);
    }    
}