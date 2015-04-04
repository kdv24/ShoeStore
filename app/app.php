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


//HOME

    //displays links to brands and stores pages
    $app->get("/", function () use ($app)
    {
        return $app['twig']->render('/index.twig');
    });

//BRANDS
    //displays all brands
    $app->get("/brands", function () use ($app)
    {
        return $app['twig']->render('/brands.twig');
    });

    //receives all info from the form (add a brand) on the brands page
    $app->post("/brands", function () use ($app)
    {
        return $app['twig']->render('/brands.twig');
    });

    //displays one brand and all stores associated with that brand($id)
    $app->get("/brand/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('/brand.twig');
    });

    //receives all info from the form (add a store to the brand) on the brand page
    $app->post("/brand/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('/brand.twig');
    });

//NOT NECESSARY FOR THIS ASSIGNMENT
    //displays brand to be updated or deleted- maybe don't really need GET?  see note with store patch below
    // $app->get("/brand/{id}/edit", function ($id) use ($app)
    // {
    //     return $app['twig']->render('/brand_edit.twig');
    // });

 
    //updates the specific brand by id from the brand{id}.
    // $app->patch("/brand/{id}/edit", function ($id) use ($app)
    // {
    //     return $app['twig']->render('brand.twig');
    // });

//STORES
    //displays all stores
    $app->get("/stores", function () use ($app)
    {
        return $app['twig']->render('/stores.twig');
    });

    //receives all info from the form (add a store) on the stores page
    $app->post("/stores", function () use ($app)
    {
        return $app['twig']->render('/stores.twig');
    });

    //displays one store and all brands associated with that store
    $app->get("/store/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('/store.twig');
    });

    //receives all info from the form (add a brand to the store) on the store page
    $app->post("/store/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('store.twig');
    });

    //displays store to be updated or deleted- maybe don't really need GET unless this is where form displays to enter changed info? could also put that on store page with path to /store{id}/edit and never display store_edit.twig?
    $app->get("/store/{id}/edit", function ($id) use ($app)
    {
        return $app['twig']->render('store_edit.twig');
    });

    //updates the specific store name using id from store{id}
    $app->patch("/store/{id}/edit", function ($id) use ($app)
    {
        return $app['twig']->render('store.twig');;
    });

    return $app;
?>