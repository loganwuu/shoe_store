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

    //homepage
    $app->get("/", function() use($app) {
        return $app['twig']->render('index.html.twig');
    });

    //list of brands page
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    //from adding new brand and new list of brands
    $app->post("/brands", function() use ($app) {
        $brand = new Brand($_POST['name']);
        $brand->save();
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    //delete all brands, show empty list of brands
    $app->post("/delete_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands'=>Brand::getAll()));
    });

    //delete one brand, show updated list of brands
    $app->delete("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $brand->delete();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    //show one brand page
    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $stores = $brand->getStores();
        return $app['twig']->render('brand.html.twig', array('brand'=>$brand, 'stores'=>$stores, 'all_stores' => Store::getAll()));
    });

    //from adding new store to a brand, show updated brand page
    $app->post("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
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

    //list of stores page
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    //from adding new store and new list of stores
    $app->post("/stores", function() use ($app) {
        $store = new Store($_POST['name'], $_POST['address']);
        $store->save();
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    //delete all stores, show empty list of stores
    $app->post("/delete_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores'=>Store::getAll()));
    });

    //delete one store, show updated list of stores
    $app->delete("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
    return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });

    //store name edit page
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

    //from updating store name, show updated store page
    $app->patch("/store/{id}", function($id) use ($app) {
        $name = $_POST['name'];
        $store = Store::find($id);
        $store->update($name);
        $brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $brands, 'all_brands'=>Brand::getAll()));
    });

    //from adding new brand to a store, show updated store page
    $app->post("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand_id']);
        $store->addBrand($brand);
        $brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('store'=>$store, 'brands'=>$brands, 'all_brands'=>Brand::getAll()));
    });

    return $app;
?>
