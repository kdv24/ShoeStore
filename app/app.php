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


//*************HOME**************

    //displays links to brands and stores pages
    $app->get("/", function () use ($app)
    {
        return $app['twig']->render('index.twig');
    });

//*************BRAND**************

//READ- displays ALL brands
    $app->get("/brands", function () use ($app)
    {
        return $app['twig']->render('brands.twig');
    });

//CREATE a new brand- receives ALL info from the form (add a brand) on the brands page
    $app->post("/brands", function () use ($app)
    {
        return $app['twig']->render('brands.twig');
    });

//DELETE- deletes ALL brands
    $app->post("/brands", function ($id) use ($app)
    {
        return $app['twig']->render('brands.twig');
    });

//READ- displays ONE brand and any stores associated with that brand($id)
    $app->get("/brand/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('brand.twig');
    });

//CREATE- receives info from the form (add a store to the brand) on the ONE brand page
    $app->post("/brand/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('brand.twig');
    });

//DELETE- delete ONE brand by {id}
    $app->delete("/brand/{id}/delete", function ($id) use ($app)
    {
        return $app['twig']->render('brands.twig');
    });

//NOT NECESSARY FOR THIS ASSIGNMENT
    //READ- displays brand to be updated or deleted- maybe don't really need GET?  see note with store patch below
    // $app->get("/brand/{id}/edit", function ($id) use ($app)
    // {
    //     return $app['twig']->render('/brand_edit.twig');
    // });

 
    //UPDATE- updates the specific brand by id from the brand{id}.
    // $app->patch("/brand/{id}/edit", function ($id) use ($app)
    // {
    //     return $app['twig']->render('brand.twig');
    // });

//*************STORES**************

//READ- displays ALL stores
    $app->get("/stores", function () use ($app)
    {
        return $app['twig']->render('stores.twig');
    });

//CREATE a new STORE- receives ALL info from the form (add a store) on the stores page
    $app->post("/stores", function () use ($app)
    {
        return $app['twig']->render('stores.twig');
    });

//DELETE- deletes ALL stores
    $app->delete("/stores", function ($id) use ($app)
    {
        return $app['twig']->render('stores.twig');
    });

//READ- displays ONE store and any brands associated with that store
    $app->get("/store/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('store.twig');
    });

//CREATE- receives info from the form (add a brand to the store) on the ONE store page- CAREFUL ON THIS ONE: store to brand or brand to store
    $app->post("/store/{id}", function ($id) use ($app)
    {
        return $app['twig']->render('store.twig');
    });

//DELETE- deletes ONE store by {id}
    $app->delete("/store/{id}/delete", function ($id) use ($app)
    {
        return $app['twig']->render('stores.twig');
    });

//READ- displays ONE store to be updated or deleted- maybe don't really need GET unless this is where form displays to enter changed info? could also put that on store page with path to /store{id}/edit and never display store_edit.twig?
    $app->get("/store/{id}/edit", function ($id) use ($app)
    {
        return $app['twig']->render('store_edit.twig');
    });

//UPDATE- updates the ONE specific store name using id from store{id}
    $app->patch("/store/{id}/edit", function ($id) use ($app)
    {
        return $app['twig']->render('store.twig');;
    });

    return $app;
?>