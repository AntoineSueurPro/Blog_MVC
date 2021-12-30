CREATE TABLE commentaires
(
    id_commentaire INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_auteur      INT      NOT NULL,
    contenu        TEXT     NOT NULL,
    created_at     DATETIME NOT NULL,
    id_article     INT      NOT NULL,
    FOREIGN KEY (id_auteur) REFERENCES membres (id_membre),
    FOREIGN KEY (id_article) REFERENCES articles (id_article)
)