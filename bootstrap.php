<?php

require_once "vendor/autoload.php";

$app = new Silex\Application();

$app['debug'] = true;

/* Doctrine configuration */
use Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\EventManager as EventManager,
    Doctrine\ORM\Events,
    Doctrine\ORM\Configuration,
    Doctrine\Common\Cache\ArrayCache as Cache,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\ClassLoader;

use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;

$cache = new Doctrine\Common\Cache\ArrayCache;
$annotationReader = new Doctrine\Common\Annotations\AnnotationReader;

$cachedAnnotationReader = new Doctrine\Common\Annotations\CachedReader(
    $annotationReader, // use reader
    $cache // and a cache driver
);

$annotationDriver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    $cachedAnnotationReader, // our cached annotation reader
    array(__DIR__ . DIRECTORY_SEPARATOR . 'src')
);

$driverChain = new Doctrine\ORM\Mapping\Driver\DriverChain();
$driverChain->addDriver($annotationDriver,'Code');

$config = new Doctrine\ORM\Configuration;
$config->setProxyDir('/tmp');
$config->setProxyNamespace('Proxy');
$config->setAutoGenerateProxyClasses(true); // this can be based on production config.
// register metadata driver
$config->setMetadataDriverImpl($driverChain);
// use our allready initialized cache driver
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);

AnnotationRegistry::registerFile(__DIR__. DIRECTORY_SEPARATOR . 'vendor' 
        . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'orm' 
        . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Doctrine' 
        . DIRECTORY_SEPARATOR . 'ORM' . DIRECTORY_SEPARATOR . 'Mapping' 
        . DIRECTORY_SEPARATOR . 'Driver' . DIRECTORY_SEPARATOR 
        . 'DoctrineAnnotations.php');

$evm = new Doctrine\Common\EventManager();
$em = EntityManager::create(
    array(
        'driver'  => 'pdo_mysql',
        'host'    => '127.0.0.1',
        'port'    => '3306',
        'user'    => 'root',
        'password'  => 'root',
        'dbname'  => 'contrate',
    ),
    $config,
    $evm
);

/* Provider Register */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/src/Code/Sistema/Views',
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new Code\Sistema\Validator\Constraints\CpfCnpjServiceProvider());
/*$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'admin' => array(
            'anonymous' => true,
            'pattern' => '^/',
            'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check'),
            'users' => $app->share(function() use($app){
                return $app['user_repository'];
            }),
            'logout' => array('logout_path' => '/admin/logout')
        )
    )
));*/

/* Access Rules */
/*$app['security.access_rules'] = array(
    array('^/admin', 'ROLE_ADMIN')
);*/

/* Shared Functions */
/*$app['user_repository'] = $app->share(function($app) use($em){
    
    $user = new Code\Sistema\Entity\User;
    
    $repo = $em->getRepository('Code\Sistema\Entity\User');
    $repo->setPasswordEncoder($app['security.encoder_factory']->getEncoder($user));
    
    return $repo;
});*/

/* -- Container de Serviços */
$app['empresaService'] = function() use($em){
    $empresaService = new Code\Sistema\Service\EmpresaService($em);
    return $empresaService;
};

$app['cursoService'] = function() use($em){
    $cursoService = new Code\Sistema\Service\CursoService($em);
    return $cursoService;
};

$app['responsavelService'] = function() use($em){
    $responsavelService = new Code\Sistema\Service\ResponsavelService($em);
    return $responsavelService;
};

$app['alunoService'] = function() use($em){
    $alunoService = new Code\Sistema\Service\AlunoService($em);
    return $alunoService;
};
/* -- Fim Container de Serviços */

return $app;