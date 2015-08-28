# Shoe Stores with MySQL

##### The application allows users to search a list of local shoe stores and the brands of shoes they carry. Please see [shoe_stores_database_design.png](shoe_stores_database_design.png) for the database design.
(8/28/15)

#### By Logan Wu

## Description

This application allows salon users to add shoe stores and brands and connect between them. The ```stores```, ```brands``` and ```brands_stores``` tables are stored in the ```shoes``` MySQL database.

## Setup

* Clone the project using the link provided on Github.
* Run composer install in Terminal from the project root folder.
* Start the PHP server from Terminal in the /web folder.
* Open a web browser and navigate to "localhost:8000".

### How to Setup Database on MySQL

* ```CREATE DATABASE shoes;```
* ```USE shoes;```
* ```CREATE TABLE stores (name VARCHAR(255), id serial PRIMARY KEY);```
* ```CREATE TABLE brands (name VARCHAR(255), id serial PRIMARY KEY);```
* ```CREATE TABLE brands_stores (brand_id INT, store_id INT, id serial PRIMARY KEY);```

## Technologies Used

PHP, PHPUnit, Silex, Twig, and MySQL

### Legal

Copyright (c) 2015 **Logan Wu**

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
