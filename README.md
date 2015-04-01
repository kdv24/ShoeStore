##Shoe Store Brand Inventory##

This app holds a dynamic list of local shoe stores and lists the brands of shoes each store carries.  When a user views a single store, the app shows a list of all shoe brands carried by that store.  Users can add shoe brands to that particular store list or, when viewing a single brand, can add additional stores where that brand is carried.

#Setup instructions:#
1. Clone this repository
2.



#PSQL COMMANDS:#

CREATE DATABASE shoes;
\c SHOES;
CREATE TABLE brands (id serial PRIMARY KEY, brand_name varchar);
CREATE TABLE stores (id serial PRIMARY KEY, store_name varchar);
CREATE DATABASE shoes_test WITH TEMPLATE shoes;
CREATE TABLE brands_stores (id serial PRIMARY KEY, brand_id int, store_id int);