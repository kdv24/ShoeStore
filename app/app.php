<?php
require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Brand.php";
require_once __DIR__ . "/../src/Store.php";

$app          = new Silex\Application();
$app['debug'] = true;

$DB = new PDO('pgsql:host=localhost; dbname=shoes');

$app->register(new Silex\Provider\TwigServiceProvider(), array(
		'twig.path' => __DIR__ . '/../views'
));


use Symfony\Component\HttpFoundation\Request;
Request::enableHttpMethodParameterOverride();


//*************HOME**************

//displays links to brands and stores pages
$app->get("/", function() use ($app)
{
		return $app['twig']->render('index.twig');
});

//*************BRAND**************

//READ- displays ALL brands in DB
$app->get("/brands", function() use ($app)
{

		return $app['twig']->render('brands.twig', array(
				'brands' => Brand::getAll()
		));
});

//CREATE a new brand- receives ALL info from the form (add a brand) on the brands page - adds to DB
$app->post("/add_brand", function() use ($app)
{
		$brand_name = $_POST['brand_name'];
		$brand      = new Brand($brand_name);
		$brand->save();
		return $app['twig']->render('brands.twig', array(
				'brands' => Brand::getAll()
		));
});

//DELETE- deletes ALL brands in DB
$app->post("/delete_brands", function() use ($app)
{
		Brand::deleteAll();
		return $app['twig']->render('brands.twig', array(
				'brands' => Brand::getAll()
		));
});

//READ- displays ONE brand and any stores associated with that brand($id) - also displays option to add store
$app->get("/brand/{id}", function($id) use ($app)
{
		$current_brand = Brand::find($id);
		return $app['twig']->render('brand.twig', array(
				'brand' => $current_brand,
				'all_stores' => Store::getAll(),
				'stores' => $current_brand->getStores(),
				'all_brands' => Brand::getAll()
		));
});

//CREATE- receives info from the form in GET route (add a store to the brand) on the ONE brand page
//? post(/add_store)
$app->post("/brand/{id}", function($id) use ($app)
{
		$current_brand = Brand::find($_POST['brand_id']);
		$store         = Store::find($_POST['store_id']);
		$current_brand->addStore($store);
		return $app['twig']->render('brand.twig', array(
				'brand' => $current_brand,
				'all_stores' => Store::getAll(),
				'store' => $store,
				'stores' => $current_brand->getStores()
		));
});

//DELETE- delete ONE brand by {id} in DB
$app->delete("/brand_delete", function($id) use ($app)
{
		return $app['twig']->render('brands.twig');
});

//*************STORES**************

//READ- displays ALL stores in DB
$app->get("/stores", function() use ($app)
{
		return $app['twig']->render('stores.twig', array(
				'stores' => Store::getAll()
		));
});


//CREATE a new STORE- receives ALL info from the form (add a store) on the stores page - adds to DB
$app->post("/add_store", function() use ($app)
{
		$store_name = $_POST['store_name'];
		$store      = new Store($store_name);
		$store->save();
		return $app['twig']->render('stores.twig', array(
				'stores' => Store::getAll()
		));
});

//DELETE- deletes ALL stores from DB
$app->post("/delete_stores", function() use ($app)
{
		Store::deleteAll();
		return $app['twig']->render('stores.twig', array(
				'stores' => Store::getAll()
		));
});

//READ- displays ONE store and any brands associated with that store - also displays option to add a brand
$app->get("/store/{id}", function($id) use ($app)
{
		$current_store = Store::find($id);
		return $app['twig']->render('store.twig', array(
				'store' => $current_store,
				'stores' => Store::getAll(),
				'brands' => $current_store->getBrands(),
				'all_brands' => Brand::getAll()
		));
});

//CREATE- receives info from the form (add brand selected on GET route to the store) on the ONE store page- CAREFUL ON THIS ONE: store to brand or brand to store
//? post("/add_brand")? do I need the id stuff in the route?
$app->post("/store/{id}", function($id) use ($app)
{
		$current_store = Store::find($_POST['store_id']);
		$brand         = Brand::find($_POST['brand_id']);
		$current_store->addBrand($brand);
		return $app['twig']->render('store.twig', array(
				'brands' => $current_store->getBrands(),
				'store' => $current_store,
				'all_brands' => Brand::getAll()
		));
});

//DELETE- deletes a specific brand from ONE store's list
// $app->delete("/delete_brand_from_store", function () use ($app)
// {
//     $current_store = Store::find($_POST['store_id']);
//     $brand = Brand::find($_POST['brand_id']);
//     $current_store->deleteBrand($brand);
//     return $app['twig']->render('store.twig', array('brand' => $brand));
// });

//DELETE- deletes ONE store by {id} - removes from DB
//? post(/delete_store)
$app->delete("/store_delete/{id}", function($id) use ($app)
{
		$current_store = Store::find($id);
		$current_store->deleteStore();
		return $app['twig']->render('stores.twig', array(
				'stores' => Store::getAll()
		));
});

//READ- displays ONE store to be updated or deleted- maybe don't really need GET unless this is where form displays to enter changed info? could also put that on store page with path to /store{id}/edit and never display store_edit.twig?
$app->get("/store/{id}/edit", function($id) use ($app)
{
		$current_store = Store::find($id);
		return $app['twig']->render('store_edit.twig', array(
				'store' => $current_store,
				'brands' => Brand::getAll(),
				'stores' => Store::getAll()
		));
});

//UPDATE- updates the ONE specific store name using id from store{id} - changes name in DB
$app->patch("/store_update/{id}", function($id) use ($app)
{
		$current_store  = Store::find($id);
		$new_store_name = $_POST['store_name'];
		$current_store->updateStore($new_store_name);
		return $app['twig']->render('stores.twig', array(
				'stores' => Store::getAll()
		));
});

return $app;
?>
