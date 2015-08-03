# For mysql


CREATE TABLE auth_user (
	id BIGINT PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT null,
	password VARCHAR(255) NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT current_timestamp
);

insert into auth_user 
(id, name, password)
VALUES
(1, 
'steve@mydomain.com',
 '$2y$11$b3481b296602c6f73a5b3eWoaippvvbKGDnxXlB.8V3zT0vXQ.DcG');


# For sqlite


CREATE TABLE auth_user (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name VARCHAR NOT null,
	password VARCHAR NOT NULL,
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

insert into auth_user 
(id, name, password)
VALUES
(1, 
'steve@mydomain.com', 
'$2y$11$b3481b296602c6f73a5b3eWoaippvvbKGDnxXlB.8V3zT0vXQ.DcG' 
);
