CREATE TABLE membres
(
    id_membre INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    pseudo    VARCHAR(255) NOT NULL,
    email     VARCHAR(255) NOT NULL,
    role      TINYINT(1) NOT NULL DEFAULT 0,
    avatar    VARCHAR(255),
    password  VARCHAR(255) NOT NULL
)