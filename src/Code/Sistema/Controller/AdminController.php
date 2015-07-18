<?php

namespace Code\Sistema\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AdminController
 *
 * @author eduardo
 */
class AdminController implements ControllerProviderInterface{
    
    public function connect(Application $app) {
        $controller = $app['controllers_factory'];
        
        /********************* Curso Action *********************/
        $controller->get('/curso/index/{page}', function($page) use($app){
            return $this->indexActionCurso($app, $page);
        })->bind('list-curso')->value('page', '');
        
        $controller->match('/curso/novo', function(Request $request) use($app){
            return $this->createActionCurso($app, $request);
        })->bind('new-curso')->method('GET|POST');
        
         $controller->match('/curso/editar/{id}', function(Request $request, $id) use($app){
            return $this->updateActionCurso($app, $request, $id);
        })->bind('edit-curso')->method('GET|PUT');

        $controller->match('/curso/remover/{id}', function(Request $request, $id) use($app){
            return $this->deleteActionCurso($app, $request, $id);
        })->bind('delete-curso')->method('GET|DELETE');
        
        $controller->get('/curso/pesquisar/{page}', function(Request $request, $page) use($app){
            return $this->searchActionCurso($app, $request, $page);
        })->bind('search-curso')->value('page', '');
        
        /********************* Empresa Action *********************/
        $controller->get('/empresa/index/{page}', function($page) use($app){
            return $this->indexActionEmpresa($app, $page);
        })->bind('list-empresa')->value('page', '');
        
        $controller->match('/empresa/novo', function(Request $request) use($app){
            return $this->createActionEmpresa($app, $request);
        })->bind('new-empresa')->method('GET|POST');
        
         $controller->match('/empresa/editar/{id}', function(Request $request, $id) use($app){
            return $this->updateActionEmpresa($app, $request, $id);
        })->bind('edit-empresa')->method('GET|PUT');

        $controller->match('/empresa/remover/{id}', function(Request $request, $id) use($app){
            return $this->deleteActionEmpresa($app, $request, $id);
        })->bind('delete-empresa')->method('GET|DELETE');
        
        $controller->get('/empresa/pesquisar/{page}', function(Request $request, $page) use($app){
            return $this->searchActionEmpresa($app, $request, $page);
        })->bind('search-empresa')->value('page', '');
        
        /********************* Responsavel Empresa Action *********************/
        $controller->get('/empresa/{empresa_id}/responsavel/index/{page}', function($page, $empresa_id) use($app){
            return $this->indexActionEmpresaResp($app, $page, $empresa_id);
        })->bind('list-empresa-resp')->value('page', '');
        
        $controller->match('/empresa/{empresa_id}/responsavel/novo', function(Request $request, $empresa_id) use($app){
            return $this->createActionEmpresaResp($app, $request, $empresa_id);
        })->bind('new-empresa-resp')->method('GET|POST');
        
         $controller->match('/empresa/{empresa_id}/responsavel/editar/{id}', function(Request $request, $id, $empresa_id) use($app){
            return $this->updateActionEmpresaResp($app, $request, $id, $empresa_id);
        })->bind('edit-empresa-resp')->method('GET|PUT');

        /*$controller->match('/empresa/responsavel/remover/{id}', function(Request $request, $id) use($app){
            return $this->deleteActionEmpresaResp($app, $request, $id);
        })->bind('delete-empresa-resp')->method('GET|DELETE');*/
        
        $controller->get('/empresa/{empresa_id}/responsavel/pesquisar/{page}', function(Request $request, $page, $empresa_id) use($app){
            return $this->searchActionEmpresaResp($app, $request, $page, $empresa_id);
        })->bind('search-empresa-resp')->value('page', '');
        
        /********************* Aluno Action *********************/
        $controller->get('/aluno/index/{page}', function($page) use($app){
            return $this->indexActionAluno($app, $page);
        })->bind('list-aluno')->value('page', '');
        
        $controller->get('/aluno/import', function(Request $request) use($app){
            return $this->importActionAluno($app, $request);
        })->bind('import-aluno')->method('GET|POST');
        
        $controller->match('/aluno/novo', function(Request $request, $id) use($app){
            return $this->createActionAluno($app, $request, $id);
        })->bind('new-aluno')->method('GET|POST');
        
         $controller->match('/aluno/editar/{id}', function(Request $request, $id) use($app){
            return $this->updateActionAluno($app, $request, $id);
        })->bind('edit-aluno')->method('GET|PUT');

        $controller->match('/aluno/remover/{id}', function(Request $request, $id) use($app){
            return $this->deleteActionAluno($app, $request, $id);
        })->bind('delete-aluno')->method('GET|DELETE');
        
        $controller->get('/aluno/pesquisar/{page}', function(Request $request) use($app){
            return $this->searchActionAluno($app, $request);
        })->bind('search-aluno')->value('page', '');
        
        /* Administrador */
        $controller->get('/', function() use($app){
            return $this->indexActionAdmin($app);
        })->bind('index-admin');
        
        return $controller;
    }
    
    public function indexActionAdmin(Application $app){
        return $app['twig']->render('administrador/index.twig',[]);
    }
    
    /**** Actions de Curso ****/
    public function indexActionCurso(Application $app, $page){
        $limitRegister = 10;
        $numCursos = $app['cursoService']->getCountCursos();
        
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegister, $numCursos, $app['url_generator']->generate('list-curso'));
        $cursos = $app['cursoService']->getCursos($page, $limitRegister);
        
        return $app['twig']->render('administrador/curso/index.twig',['cursos' => $cursos, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numCursos]);
    }
    
    public function createActionCurso(Application $app, Request $request){
        if($request->isMethod('POST')){
            $data['nome'] = $request->get('nome');            
            $msgErros = $app['cursoService']->insert($data, $app);
            
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/curso/novo.twig', ['msg' => $msgErros]);
            }
            
            return $app->redirect($app['url_generator']->generate('list-curso'));
        }
        
        return $app['twig']->render('administrador/curso/novo.twig', []);
    }
    
    public function searchActionCurso(Application $app, Request $request, $page){
        $search = $request->get('search');        
        $limitRegs = 5;        
        if(!empty($search)){        
            $limitRegs = 2;
        }        
        $numCursos = $app['cursoService']->getCountPesquisa($search);         
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegs, $numCursos, $app['url_generator']->generate('search-curso'), ['search' => $search]);
        $cursos = $app['cursoService']->pesquisar($page, $limitRegs, $search); 
        
        return $app['twig']->render('administrador/curso/index.twig',['cursos' => $cursos, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numCursos,
                                                                      'search' => $search]);        
    }
    
    public function deleteActionCurso(Application $app, Request $request, $id){
        if($request->isMethod('DELETE')){
            $app['cursoService']->delete($id);
            return $app->redirect($app['url_generator']->generate('list-curso'));
        }
        $curso = $app['cursoService']->findById($id);        
        return $app['twig']->render('administrador/curso/remover.twig', ['curso' => $curso]);
    }
    
    public function updateActionCurso(Application $app, Request $request, $id){
        if($request->isMethod('PUT')){
            $data['id'] = $id;
            $data['nome'] = $request->get('nome');
            $app['cursoService']->update($data, $app);
            return $app->redirect($app['url_generator']->generate('list-curso'));
        }
        $curso = $app['cursoService']->findById($id);
        return $app['twig']->render('administrador/curso/editar.twig', ['curso' => $curso]);
    }
    /**** Fim actions de curso ****/

    /**** Actions de Empresas ****/
    public function indexActionEmpresa(Application $app, $page){
        $limitRegister = 15;
        $numRegistros = $app['empresaService']->getCountEmpresas();        
        
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegister, $numRegistros, $app['url_generator']->generate('list-empresa'));
        $empresas = $app['empresaService']->getEmpresas($page, $limitRegister);        
        
        return $app['twig']->render('administrador/empresa/index.twig',['empresas' => $empresas, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros]);
    }
    
    public function createActionEmpresa(Application $app, Request $request){
        if($request->isMethod('POST')){
            $data['nome'] = $request->get('nome');
            $data['endereco'] = $request->get('endereco');
            $data['cidade'] = $request->get('cidade');
            $data['estado'] = $request->get('estado');
            $data['fone'] = $request->get('fone');
            $data['email'] = $request->get('email');

            $msgErros = $app['empresaService']->insert($data, $app);
            
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/empresa/novo.twig', ['msg' => $msgErros]);
            }
            
            return $app->redirect($app['url_generator']->generate('list-empresa'));
        }
        
        return $app['twig']->render('administrador/empresa/novo.twig', []);
    }
    
    public function searchActionEmpresa(Application $app, Request $request, $page){
        $search = $request->get('search');        
        $limitRegs = 15;        
        if(!empty($search)){        
            $limitRegs = 15;
        }        
        $numRegistros = $app['empresaService']->getCountPesquisa($search);         
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegs, $numRegistros, $app['url_generator']->generate('search-empresa'), ['search' => $search]);
        $empresas = $app['empresaService']->pesquisar($page, $limitRegs, $search); 
        
        return $app['twig']->render('administrador/empresa/index.twig',['empresas' => $empresas, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros,
                                                                      'search' => $search]);
    }
    
    public function deleteActionEmpresa(Application $app, Request $request, $id){
        $empresa = $app['empresaService']->findById($id);
        if($request->isMethod('DELETE')){
            $msgErros = $app['empresaService']->delete($id);
            
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/empresa/remover.twig', ['msg' => $msgErros, 'empresa' => $empresa]);
            }
            return $app->redirect($app['url_generator']->generate('list-empresa'));
        }                
        return $app['twig']->render('administrador/empresa/remover.twig', ['empresa' => $empresa]);
    }
    
    public function updateActionEmpresa(Application $app, Request $request, $id){
        if($request->isMethod('PUT')){
            $data['id'] = $id;
            $data['nome'] = $request->get('nome');
            $data['endereco'] = $request->get('endereco');
            $data['cidade'] = $request->get('cidade');
            $data['estado'] = $request->get('estado');
            $data['fone'] = $request->get('fone');
            $data['email'] = $request->get('email');

            $app['empresaService']->update($data, $app);
            return $app->redirect($app['url_generator']->generate('list-empresa'));
        }
        $empresa = $app['empresaService']->findById($id);
        return $app['twig']->render('administrador/empresa/editar.twig', ['empresa' => $empresa]);
    }
    /**** Fim actions de Empresa ****/
    
    /**** Actions dos Responsaveis ****/
    public function indexActionEmpresaResp(Application $app, $page, $empresa_id){
        $limitRegister = 15;        
        
        $responsaveis = $app['responsavelService']->getResponsavel($page, $limitRegister, $empresa_id);
        $numRegistros = count($responsaveis);
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegister, $numRegistros, $app['url_generator']->generate('list-empresa-resp', ['empresa_id' => $empresa_id]));
        $empresa = $app['empresaService']->findById($empresa_id);
                
        return $app['twig']->render('administrador/responsavel/index.twig',['responsaveis' => $responsaveis, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros,
                                                                      'empresa' => $empresa]);
    }
    
    public function createActionEmpresaResp(Application $app, Request $request, $empresa_id){
        $empresa = $app['empresaService']->findById($empresa_id);
        
        if($request->isMethod('POST')){
            $data['nome'] = $request->get('nome');
            $data['cpf'] = $request->get('cpf');
            $data['email'] = $request->get('email');
            $data['empresa'] = $request->get('empresa_id');
            
            $msgErros = $app['responsavelService']->insert($data, $app);            
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/responsavel/novo.twig', ['msg' => $msgErros, 'empresa' => $empresa]);
            }            
            return $app->redirect($app['url_generator']->generate('list-empresa-resp', ['empresa_id' => $empresa_id]));
        }        
        return $app['twig']->render('administrador/responsavel/novo.twig', ['empresa' => $empresa]);
    }
    
    public function updateActionEmpresaResp(Application $app, Request $request, $id, $empresa_id){
        $responsavel = $app['responsavelService']->findById($id);
        $empresa = $app['empresaService']->findById($empresa_id);
        
        if($request->isMethod('PUT')){
            $data['id'] = $id;
            $data['nome'] = $request->get('nome');
            $data['cpf'] = $request->get('cpf');            
            $data['email'] = $request->get('email');
            $data['empresa'] = $request->get('empresa_id');            
            
            $msgErros = $app['responsavelService']->update($data, $app);
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/responsavel/editar.twig', ['msg' => $msgErros, 'empresa' => $empresa, 'responsavel' => $responsavel]);
            }            
            return $app->redirect($app['url_generator']->generate('list-empresa-resp', ['empresa_id' => $empresa_id]));
        }        
        return $app['twig']->render('administrador/responsavel/editar.twig', ['empresa' => $empresa, 'responsavel' => $responsavel]);
    }
    
    public function searchActionEmpresaResp(Application $app, Request $request, $page, $empresa_id){
        $search = $request->get('search');        
        $limitRegs = 15;
        $empresa = $app['empresaService']->findById($empresa_id);
        $numRegistros = $app['responsavelService']->getCountResponsavel($empresa_id, $search);
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegs, $numRegistros, $app['url_generator']->generate('search-empresa-resp', ['empresa_id' => $empresa_id]), ['search' => $search]);
        $responsaveis = $app['responsavelService']->pesquisar($page, $limitRegs, $search, $empresa_id);   
        
        return $app['twig']->render('administrador/responsavel/index.twig',['responsaveis' => $responsaveis, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros,
                                                                      'empresa' => $empresa,
                                                                      'search' => $search]);
    }
    
    public function indexActionAluno(Application $app, $page) {
        $limitRegister = 20;
        $numRegistros = $app['alunoService']->getCountAlunos();        
        
        $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegister, $numRegistros, $app['url_generator']->generate('list-aluno'));
        $alunos = $app['alunoService']->getAlunos($page, $limitRegister);     
        
        return $app['twig']->render('administrador/aluno/index.twig', ['alunos' => $alunos, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros]);
    }
    
    public function importActionAluno(Application $app, Request $request) {
        if($request->isMethod('POST') and $request->files->get('file_csv') != null){
            
            $msgErros = $app['alunoService']->importarCSV($request->files->get('file_csv'));
            $limitRegister = 15;
            $numRegistros = $app['alunoService']->getCountAlunos();        
            $page = null;
            $paginator = new \Code\Sistema\Helper\Paginator($page, $limitRegister, $numRegistros, $app['url_generator']->generate('list-aluno'));
            $alunos = $app['alunoService']->getAlunos($page, $limitRegister);
            
            if(count($msgErros) > 0){
                return $app['twig']->render('administrador/aluno/index.twig', ['msg' => $msgErros,
                                                                      'alunos' => $alunos, 
                                                                      'paginacao' => $paginator->createLinks(),
                                                                      'totalRegistros' => $numRegistros]);
            } 
            return $app->redirect($app['url_generator']->generate('list-aluno'));

            return 'falhou';
        }
        
        return 'envie arquivo';
    }
}
