CREATE TABLE articles
(
    id_article    INTEGER AUTO_INCREMENT NOT NULL PRIMARY KEY,
    image_article VARCHAR(255) NOT NULL,
    created_at    DATETIME     NOT NULL,
    titre         VARCHAR(255) NOT NULL,
    contenu       TEXT         NOT NULL,
    id_auteur     INT          NOT NULL,
    categorie     INT,
    FOREIGN KEY (id_auteur) REFERENCES membres (id_membre),
    FOREIGN KEY (categorie) REFERENCES categories (id_categorie)
)