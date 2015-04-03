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
//will list all stores and brands on home page
    $app->get("/", function () use ($app)
    {
    	return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->post("/", function () use ($app)
    {
    	return $app['twig']->render('index.twig', array ('stores'=> Store::getAll(), 'brands' => Brand::getAll()));
    });

//STORES
//will display a new page with a form to add a new store
    $app->get("/add_store", function () use ($app)
    {
    	return $app['twig']->render('add_store.twig');
    });

//uses info from form and renders result as index.twig
    $app->post("/add_store", function () use ($app)
    {
    	$store_name = $_POST['store_name'];
    	$new_store = new Store($store_name);
    	$new_store->save();

    	return $app['twig']->render('index.twig', array('store' => $new_store, 'stores'=>Store::getAll(), 'brands' => Brand::getAll()));
    });

//finds brands associated with a given store and renders the stores.twig file specific to that store, along with the brands it carries.
    $app->get("/stores/{id}", function ($id) use ($app)
    {
    	//shows selected store
    	$selected_store = Store::find($id);
    	$matching_brands = $selected_store->getBrands();
  
    	return $app['twig']->render('stores.twig', array('stores'=> Store::getAll(), 'store' => $selected_store, 'matching_brands' => $matching_brands, 'all_brands'=>Brand::getAll()));
    });

    //working on this one now
    $app->post("/stores/{id}", function ($id) use ($app)
    {
        $store = Store::find($_POST['store_id']);
        $matching_brands = Brand::find($_POST['brand_name']);
        $store->addBrand($matching_brands);
        return $app['twig']->render('stores.twig', array('store' => $store, 'brands' =>$store->getBrands(), 'stores'=>Store::getAll(), 'all_brands'=>Brand::getAll()));
    });

//DELETES STORES and renders index.twig
    $app->post('/delete_stores', function () use($app)
    {
    	Store::deleteAll();
    	return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

//BRANDS
//displays new page with form to add a new brand
    $app->get("/add_brand", function () use ($app)
    {
    	return $app['twig']->render('add_brand.twig');
    });




    $app->post("/add_brand", function () use ($app)
    {
    	$brand_name = $_POST['brand_name'];
    	$new_brand = new Brand($brand_name);
    	$new_brand->save();

    	return $app['twig']->render('index.twig', array('brand' => $new_brand, 'brands' => Brand::getAll(), 'stores' => Store::getAll()));
    });

    $app->post('/delete_brands', function () use ($app)
    {
    	Brand::deleteAll();
    	return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brands/{id}", function ($id) use ($app)
    {
    	//shows selected brand
    	$selected_brand = Brand::find($id);
    	$matching_stores = $selected_brand->getStores();

    	return $app['twig']->render('brands.twig', array('matching_stores'=> $matching_stores, 'brand' => $selected_brand, 'brands' => Brand::getAll()));
    });

//need to finish individual delete routes on twig pages
    $app->delete("/brands/{id}", function($id) use ($app) {
    $brand = Brand::find($id);
    $brand->deleteBrand();
    return $app['twig']->render('index.html.twig', array('brands'=>Brand::getAll()));
  });

    $app->delete("/stores/{id}", function($id) use ($app) {
    $stores = Store::find($id);
    $stores->deleteStore();
    return $app['twig']->render('index.html.twig', array('stores'=>Store::getAll()));
  });

    return $app;
?>