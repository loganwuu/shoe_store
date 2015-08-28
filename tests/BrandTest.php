<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";


    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);

            //Act
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);

            //Act
            $test_brand->setName("Chanel");
            $result = $test_brand->getName();

            //Assert
            $this->assertEquals("Chanel", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            //Act
            $result = $test_brand->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals($test_brand, $result[0]);
        }

        function testGetAll()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chanel";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();

            //Act
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chanel";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();

            //Act
            Brand::deleteAll();
            $result = Brand::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chanel";
            $id2 = 2;
            $test_brand2 = new Brand($name2, $id2);
            $test_brand2->save();

            //Act
            $result = Brand::find($test_brand2->getId());

            //Assert
            $this->assertEquals($test_brand2, $result);
        }

        function testAddStore()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name = "Ben's";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            //Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals($result,[$test_store]);
        }

        function testGetStores()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name = "Ben's";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            $name2 = "Jen's";
            $address2 = "222 SW 12th Ave";
            $id2 = 2;
            $test_store2 = new Store($name2, $address2, $id2);
            $test_store2->save();

            //Act
            $test_brand->addStore($test_store);
            $test_brand->addStore($test_store2);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store, $test_store2], $result);
        }
    }
?>
