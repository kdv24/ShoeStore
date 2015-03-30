#PSQL COMMANDS:#

CREATE DATABASE shoes;
\c SHOES;
CREATE TABLE brands (id serial PRIMARY KEY, brand_name varchar);
CREATE TABLE stores (id serial PRIMARY KEY, store_name varchar);
CREATE DATABASE shoes_test WITH TEMPLATE shoes;