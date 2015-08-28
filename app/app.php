<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //home page
    $app->get("/", function() use($app) {
        return $app['twig']->render('index.html.twig');
    });

    //brands page
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    $app->post("/brands", function() use ($app) {
        $brand = new Brand($_POST['name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    $app->delete("/brands/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //brand page
    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $stores = $brand->getStores();
        return $app['twig']->render('brand.html.twig', array('brand'=>$brand, 'stores'=>$stores, 'all_stores' => Store::getAll()));
    });

    $app->post("/add_stores", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $brand->addStore($store);
        $stores = $brand->getStores();
        return $app['twig']->render('brand.html.twig', array('brand'=>$brand, 'stores'=>$stores, 'all_stores'=>Store::getAll()));
    });

    // //brand edit page
    // $app->get("/Brands/{id}/edit", function($id) use ($app) {
    //     $brand = Brand::find($id);
    //     return $app['twig']->render('brand_edit.html.twig', array('brand' => $brand));
    // });

    //stores page
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    $app->post("/stores", function() use ($app) {
        $store = new Store($_POST['name'], $_POST['address']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    $app->delete("/stores/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
    return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //store edit page
    $app->get("/stores/{id}/edit", function($id) use ($app) {
        $store = Store::find($id);
        return $app['twig']->render('store_edit.html.twig', array('store' => $store));
    });

    //store page
    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('store'=>$store, 'brands'=>$brands, 'all_brands'=>Brand::getAll()));
    });

    $app->patch("/stores/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $store = Store::find($id);
        $brands = $store->getBrands();
        $store->update($name);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $brands, 'all_brands'=>Brand::getAll()));
    });

    $app->post("/add_brands", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        $brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('store'=>$store, 'brands'=>$brands, 'all_brands'=>Brand::getAll()));
    });

    return $app;
?>
