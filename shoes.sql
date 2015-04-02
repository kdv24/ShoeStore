--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: brands; Type: TABLE; Schema: public; Owner: kdevries; Tablespace: 
--

CREATE TABLE brands (
    id integer NOT NULL,
    brand_name character varying
);


ALTER TABLE brands OWNER TO kdevries;

--
-- Name: brand_id_seq; Type: SEQUENCE; Schema: public; Owner: kdevries
--

CREATE SEQUENCE brand_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE brand_id_seq OWNER TO kdevries;

--
-- Name: brand_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: kdevries
--

ALTER SEQUENCE brand_id_seq OWNED BY brands.id;


--
-- Name: brands_stores; Type: TABLE; Schema: public; Owner: kdevries; Tablespace: 
--

CREATE TABLE brands_stores (
    id integer NOT NULL,
    brand_id integer,
    store_id integer
);


ALTER TABLE brands_stores OWNER TO kdevries;

--
-- Name: brands_stores_id_seq; Type: SEQUENCE; Schema: public; Owner: kdevries
--

CREATE SEQUENCE brands_stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE brands_stores_id_seq OWNER TO kdevries;

--
-- Name: brands_stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: kdevries
--

ALTER SEQUENCE brands_stores_id_seq OWNED BY brands_stores.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: kdevries; Tablespace: 
--

CREATE TABLE stores (
    id integer NOT NULL,
    store_name character varying
);


ALTER TABLE stores OWNER TO kdevries;

--
-- Name: store_id_seq; Type: SEQUENCE; Schema: public; Owner: kdevries
--

CREATE SEQUENCE store_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE store_id_seq OWNER TO kdevries;

--
-- Name: store_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: kdevries
--

ALTER SEQUENCE store_id_seq OWNED BY stores.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: kdevries
--

ALTER TABLE ONLY brands ALTER COLUMN id SET DEFAULT nextval('brand_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: kdevries
--

ALTER TABLE ONLY brands_stores ALTER COLUMN id SET DEFAULT nextval('brands_stores_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: kdevries
--

ALTER TABLE ONLY stores ALTER COLUMN id SET DEFAULT nextval('store_id_seq'::regclass);


--
-- Name: brand_id_seq; Type: SEQUENCE SET; Schema: public; Owner: kdevries
--

SELECT pg_catalog.setval('brand_id_seq', 5, true);


--
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: kdevries
--

COPY brands (id, brand_name) FROM stdin;
\.


--
-- Data for Name: brands_stores; Type: TABLE DATA; Schema: public; Owner: kdevries
--

COPY brands_stores (id, brand_id, store_id) FROM stdin;
1	6	7
2	6	7
\.


--
-- Name: brands_stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: kdevries
--

SELECT pg_catalog.setval('brands_stores_id_seq', 2, true);


--
-- Name: store_id_seq; Type: SEQUENCE SET; Schema: public; Owner: kdevries
--

SELECT pg_catalog.setval('store_id_seq', 28, true);


--
-- Data for Name: stores; Type: TABLE DATA; Schema: public; Owner: kdevries
--

COPY stores (id, store_name) FROM stdin;
27	adsf
28	gjk
\.


--
-- Name: brand_pkey; Type: CONSTRAINT; Schema: public; Owner: kdevries; Tablespace: 
--

ALTER TABLE ONLY brands
    ADD CONSTRAINT brand_pkey PRIMARY KEY (id);


--
-- Name: brands_stores_pkey; Type: CONSTRAINT; Schema: public; Owner: kdevries; Tablespace: 
--

ALTER TABLE ONLY brands_stores
    ADD CONSTRAINT brands_stores_pkey PRIMARY KEY (id);


--
-- Name: store_pkey; Type: CONSTRAINT; Schema: public; Owner: kdevries; Tablespace: 
--

ALTER TABLE ONLY stores
    ADD CONSTRAINT store_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: kdevries
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM kdevries;
GRANT ALL ON SCHEMA public TO kdevries;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

