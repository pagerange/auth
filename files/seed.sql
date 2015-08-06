# For mysql

## Minimum require schema

CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT null,
	password VARCHAR(255) NOT NULL,
	ugroups VARCHAR(1000) NOT NULL DEFAULT '["user"]',
	created_at TIMESTAMP NOT NULL DEFAULT current_timestamp
);

insert into auth_user
(id, name, password)
VALUES
(1,
'steve@mydomain.com',
 '$2y$11$b3481b296602c6f73a5b3eWoaippvvbKGDnxXlB.8V3zT0vXQ.DcG');
 

## Sample scheme with additional fields

CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	ugroups VARCHAR(1000) NOT NULL DEFAULT '["user"]',
	first_name VARCHAR(255),
	last_name VARCHAR(255),
	street_1 VARCHAR(255),
	street_2 VARCHAR(255),
	city VARCHAR(255),
	region VARCHAR(255),
	postal_code VARCHAR(255),
	phone VARCHAR(255),
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

# For sqlite

## Minimum required schema

CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY NOT NULL AUTOINCREMENT,
	name VARCHAR(255) NOT null,
	password VARCHAR(255) NOT NULL,
	ugroups VARCHAR(1000) NOT NULL DEFAULT '["user"]',
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

insert into auth_user
(id, name, password)
VALUES
(1,
'steve@mydomain.com',
'$2y$11$b3481b296602c6f73a5b3eWoaippvvbKGDnxXlB.8V3zT0vXQ.DcG'
);

## Sample schema with additional fields

CREATE TABLE auth_user (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name VARCHAR NOT null,
	password VARCHAR NOT NULL,
	ugroups VARCHAR(1000) NOT NULL DEFAULT '["user"]',
	first_name VARCHAR,
	last_name VARCHAR,
	street_1 VARCHAR,
	street_2 VARCHAR,
	city VARCHAR,
	region VARCHAR,
	postal_code VARCHAR,
	phone VARCHAR,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

insert into auth_user
(id, name, password)
VALUES
(1,
'steve@mydomain.com',
'$2y$11$b3481b296602c6f73a5b3eWoaippvvbKGDnxXlB.8V3zT0vXQ.DcG'
);
