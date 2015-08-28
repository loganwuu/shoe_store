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

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown() {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);

            //Act
            $result = $test_store->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Bens";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);

            //Act
            $test_store->setName("Jens");
            $result = $test_store->getName();

            //Assert
            $this->assertEquals("Jens", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Bens";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            //Act
            $result = $test_store->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            //Act
            $result = Store::getAll();

            //Assert
            $this->assertEquals($test_store, $result[0]);
        }

        function testDelete()
        {
            //Arrange
            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->delete();

            //Assert
            $this->assertEquals([], $test_brand->getStores());
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            $name2 = "Jen";
            $address2 = "222 SW 12th Ave";
            $id2 = 2;
            $test_store2 = new Store($name2, $address2, $id2);
            $test_store2->save();

            //Act
            Store::deleteAll();
            $result = Store::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            //Act
            $new_name = "Jen";
            $test_store->update($new_name);

            //Assert
            $this->assertEquals("Jen", $test_store->getName());
        }

        function testFind()
        {
            //Arrange
            $name = "Ben";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            $name2 = "Jen";
            $address2 = "222 SW 12th Ave";
            $id2 = 2;
            $test_store2 = new Store($name2, $address2, $id2);
            $test_store2->save();

            //Act
            $result = Store::find($test_store2->getId());
            //Assert
            $this->assertEquals($test_store2, $result);
        }

        function testAddBrand()
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
            $test_store->addBrand($test_brand);

            //Assert
            $this->assertEquals($test_store->getBrands(),[$test_brand]);
        }

        function testGetBrands()
        {
            //Arrange
            $name = "Ben's";
            $address = "111 SW 11th Ave";
            $id = 1;
            $test_store = new Store($name, $address, $id);
            $test_store->save();

            $name = "Dior";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $test_brand->save();

            $name2 = "Chanel";
            $id2 = 2;
            $test_brand2 = new Brand($name, $id);
            $test_brand2->save();

            //Act
            $test_store->addBrand($test_brand);
            $test_store->addBrand($test_brand2);
            $result = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

    }
?>
