<?php
	require_once __DIR__."/../vendor/autoload.php";
	require_once __DIR__."/../src/Brand.php";
	require_once __DIR__."/../src/Store.php";

	$app = new Silex\Application();
	$app['debug']= true;

	$DB = new PDO('pgsql:host=localhost; dbname=shoes');

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));


    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();


//READ

    //displays links to brands and stores pages
    $app->get("/", function () use ($app)
    {
        return $app['twig']->render('/index.twig');
    });

    return $app;
?>