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

//will list all stores and brands on home page
    $app->get("/", function () use ($app)
    {
    	return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/", function () use ($app)
    {
    	return $app['twig']->render('index.twig', array ('stores'=> Store::getAll(), 'brands' => Brand::getAll()));
    });

//will display a new page with a form to add a new store
    $app->get("/add_store", function () use ($app)
    {
    	return $app['twig']->render('add_store.twig');
    });

    $app->post("/add_store", function () use ($app)
    {
    	$store_name = $_POST['store_name'];
    	$new_store = new Store($store_name);
    	$new_store->save();

    	return $app['twig']->render('index.twig', array('store' => $new_store, 'stores'=>Store::getAll()));
    });

    return $app;
?>