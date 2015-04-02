##Shoe Store Brand Inventory##

This app holds a dynamic list of local shoe stores and lists the brands of shoes each store carries.  When a user views a single store, the app shows a list of all shoe brands carried by that store.  Users can add shoe brands to that particular store list or, when viewing a single brand, can add additional stores where that brand is carried.

#By Kelly de Vries#
#3.31.15

#Setup instructions:#
1.  PHP must be installed on your machine (consult other sources for tutorials)

2.  In your terminal, type:
	a.  mkdir <folder name>
	b.  cd <folder name>
	c.  git clone https://github.com/kdv24/ShoeStore.git .
	d.  cd web
	e.  php -S localhost:8000

3.  Open a new tab in terminal and type:
	a.  psql
	b.  CREATE DATABASE shoes;
	c.  \c shoes;
	d.  \i shoes.sql;

3.  In a web browser window, type localhost:8000

4.  Now you should be able to see the Shoe Store.	


#If the import doesn't work or you want to also view the test database and you need to recreate the database in psql, you can also type in the following commands:#

CREATE DATABASE shoes;
\c SHOES;
CREATE TABLE brands (id serial PRIMARY KEY, brand_name varchar);
CREATE TABLE stores (id serial PRIMARY KEY, store_name varchar);
CREATE DATABASE shoes_test WITH TEMPLATE shoes;
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);


Copyright (c) 2015 Kelly de Vries
#license-mit

