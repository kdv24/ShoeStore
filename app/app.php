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

    //displays all brands
    $app->get("/brands", function () use ($app)
    {
        return $app['twig']->render('/brands.twig');
    });

    //displays one brand and all stores associated with that brand
    $app->get("/brand", function () use ($app)
    {
        return $app['twig']->render('/brand.twig');
    });

    //displays brand to be updated or deleted
    $app->get("/brand_edit", function () use ($app)
    {
        return $app['twig']->render('/brand_edit.twig');
    });

    //displays all stores
    $app->get("/stores", function () use ($app)
    {
        return $app['twig']->render('/stores.twig');
    });

    //displays one store and all brands associated with that store
    $app->get("/store", function () use ($app)
    {
        return $app['twig']->render('/store.twig');
    });

    //displays store to be updated or deleted
    $app->get("/store_edit", function () use ($app)
    {
        return $app['twig']->render('/store_edit.twig');
    });
    return $app;
?>