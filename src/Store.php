<?php
    class Store
    {
        private $name;
        private $address;
        private $id;

        function __construct($name, $address, $id = null)
        {
            $this->name = $name;
            $this->address = $address;
            $this->id = $id;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setAddress($new_address)
        {
            $this->address = (string) $new_address;
        }

        function getAddress()
        {
            return $this->address;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stores (name, address) VALUES ('{$this->getName()}', '{$this->getAddress()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_store_name)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$new_store_name}' WHERE id = {$this->getId()};");
            $this->setName($new_store_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach($returned_stores as $store) {
                $name = $store['name'];
                $address = $store['address'];
                $id = $store['id'];
                $new_store = new store($name, $address, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        function addBrand($brand)
        {
            $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores
                JOIN brands_stores ON (stores.id = brands_stores.store_id)
                JOIN brands ON (brands_stores.brand_id = brands.id)
                WHERE stores.id = {$this->getId()};");
            $brands = $query->fetchAll(PDO::FETCH_ASSOC);
            $brands_array = array();

            foreach($brands as $brand) {
                $name = $brand['name'];
                $id = $brand['id'];
                $new_brand = new Brand($name, $id);
                array_push($brands_array, $new_brand);
            }
            return $brands_array;
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }
    }
?>
