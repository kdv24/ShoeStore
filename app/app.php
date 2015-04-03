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
//will list all stores and brands on home page WORKS
    $app->get("/", function () use ($app)
    {
    	return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

//UNNECESSARY?
    // $app->post("/", function () use ($app)
    // {
    // 	return $app['twig']->render('index.twig', array ('stores'=> Store::getAll(), 'brands' => Brand::getAll()));
    // });

//STORES
//will display list of ALL stores WORKS
	$app->get("/stores", function () use ($app)
	{
		return $app['twig']->render('stores.twig', array('stores'=>Store::getAll()));
	});

//will display ONE store and all brands associated with it
	$app->get('store/{id}', function ($id) use ($app)
	{
		$store = Store::find($id);
		return $app['twig']->render('store.twig', array('store' => $store, 'stores'=>Store::getAll(), 'brands'=> $store->getBrands));
	});

//  NOT NECESSARY? will display a new page with a form to add a new store WORKS
// 	$app->get("/add_store", function () use ($app)
// 	{
// 		return $app['twig']->render('store.twig', array('stores'=>Store::getAll()));
// 	});

//Adds ONE store -uses info from form and renders result on stores.twig WORKS
	$app->post("/add_store", function () use ($app)
	{
		$store_name = $_POST['store_id'];
		$new_store = new Store($store_name);
		$new_store->save();

		return $app['twig']->render('stores.twig', array('store' => $new_store, 'stores'=>Store::getAll(), 'brands' => Brand::getAll()));
	});


//NEED STILL-  add brand to store
// $app->post("/store_carries", function() use($app)
// {
//     $new_store = Store::find($_POST['store_id']);
//     $matching_brands = Brand::find($_POST['brand_id']);
//     $new_store->addBrand($matching_brands);
//     return $app['twig']->render('stores.twig', array('store'=> $new_store, 'brands'=> $new_store->getBrands(), 'matching_brands'=> $matching_brands, 'all_brands'=> Brand::getAll()));
// });

$app->post("/brand_locate", function () use ($app)
{
	$store = Store::find($_POST['store_id']);
	$brand = Brand::find($_POST['brand_id']);
	$brand->addStore($store);
	return $app['twig']->render('brand.twig', array('brand'=>$brand, 'matching_stores'=>$brand->getStores()));
});

//DELETES ALL STORES and renders index.twig WORKS
	$app->post('/delete_stores', function () use($app)
	{
		Store::deleteAll();
		return $app['twig']->render('index.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
	});



//BRANDS
//will display list of ALL brands WORKS
	$app->get("/brands", function () use($app)
	{
		return $app['twig']->render('brands.twig', array('brands'=>Brand::getAll()));
	});

//displays new page with form to add a new brand WORKS
	$app->get("/add_brand", function () use ($app)
	{
		return $app['twig']->render('brand.twig', array('brand' => $new_brand, 'brands'=>Brand::getAll()));
	});

// unidentified index: brand_id on line 76 NOT WORKING
	$app->post("/add_brand", function () use ($app)
	{
		$brand_name = $_POST['brand_id'];
		$new_brand = new Brand($brand_name);
		$new_brand->save();

		return $app['twig']->render('brand.twig', array('brand' => $new_brand, 'brands' => Brand::getAll(), 'stores' => Store::getAll()));
	});





    //working on this one now
    $app->post("/stores/{id}", function ($id) use ($app)
    {
        $store = Store::find($id);
        $matching_brands = Brand::find($_POST['brand_id']);
        $store->addBrand($matching_brands);
        return $app['twig']->render('stores.twig', array('store' => $store, 'brands' =>$store->getBrands(), 'stores'=>Store::getAll(), 'all_brands'=>Brand::getAll()));
    });

    //also finish this one and matching twig
    $app->get("stores/{id}/edit", function ($id) use($app)
    {
        $store = Store::find($id);
        return $app['twig']->render('store_edit.twig', array('store'=>$store, 'brands'=> $store->getBrands()));
    });

    $app->patch("/stores/{id}", function ($id) use ($app) {
        $store = Store::find($id);
        $new_store = $_POST['new_store'];
        $store->update($new_store);
        return $app['twig']->render('stores.twig', array ('store' => $store, 'brands' => $store->getBrands()));
    });

    $app->delete("/stores/{id}/delete", function ($id) use ($app) {
        $store = Store::find($id);
        $store->deleteStore();
        return $app['twig']->render('stores.twig', array('store'=> Store::getAll()));
    });








    $app->post('/delete_brands', function () use ($app)
    {
    	Brand::deleteAll();
    	return $app['twig']->render('brands.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
    });

    $app->get("/brands/{id}", function ($id) use ($app)
    {
    	//shows selected brand
    	$selected_brand = Brand::find($id);
    	$matching_stores = $selected_brand->getStores();

    	return $app['twig']->render('brands.twig', array('matching_stores'=> $matching_stores, 'brand' => $selected_brand, 'brands' => Brand::getAll()));
    });

    $app->post("/brands/{id}", function ($id) use ($app)
    {
        $matching_store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $matching_store->addBrand($brand);
        return $app['twig']->render('brands.twig', array('matching_store'=> $matching_store, 'locations'=>$brand->getStores(), 'all_stores'=>Store::getAll()));
    });

    $app->get("/brands/{id}/edit", function($id) use ($app)
    {
        $brand = Brand::find($id);
        return $app['twig']->render('brand_edit.twig', array('brand' => $brand, 'stores'=> $brand->getStores()));
    });

    $app->patch("/brands/{id}", function ($id) use($app)
    {
        $brand = Brand::find($id);
        $new_name = $_POST['new_name'];
        $brand->update($new_name);
        return $app['twig']->render('brands.twig', array('brand'=> $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });

//need to finish individual delete routes on twig pages
    $app->delete("/brands/{id}", function($id) use ($app) {
    $brand = Brand::find($id);
    $brand->deleteBrand();
    return $app['twig']->render('index.twig', array('brands'=>Brand::getAll()));
  });

    $app->delete("/stores/{id}", function($id) use ($app) {
    $stores = Store::find($id);
    $stores->deleteStore();
    return $app['twig']->render('index.twig', array('stores'=>Store::getAll()));
  });

//finds brands associated with a given store and renders the stores.twig file specific to that store, along with the brands it carries.
	// $app->get("/stores/{id}", function ($id) use ($app)
	// {
	// 	//shows selected store
	// 	$selected_store = Store::find($id);
	// 	$matching_brands = $selected_store->getBrands();
	// 	$store_brands = array();
	// 	foreach ($matching_brands as $matching_brand){
	//
	// 	}
	//
	// 	return $app['twig']->render('stores.twig', array('stores'=> Store::getAll(), 'store' => $selected_store, 'matching_brands' => $matching_brands, 'all_brands'=>Brand::getAll()));
	// });


	// $test_store->addBrand($test_brand_name);
	// $test_store->addBrand($test_brand_name2);
	//
	//
	// //Assert
	// $result = $test_store->getBrands();
	// $this->assertEquals([$test_brand_name, $test_brand_name2], $result);


    return $app;
?>
