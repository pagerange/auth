CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT null,
	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT current_timestamp
);

insert into auth_user 
(id, name, password)
VALUES
(1, 'steve@glort.com', 'password');