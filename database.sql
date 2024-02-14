CREATE TABLE propietario
(
    id             INT         NOT NULL AUTO_INCREMENT,
    nombrecompleto VARCHAR(75) NOT NULL,
    celular        VARCHAR(15) NOT NULL,
    email          VARCHAR(25) NOT NULL,
    genero         VARCHAR(1)  NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (email ASC)
);

CREATE TABLE mascota
(
    id             INT         NOT NULL AUTO_INCREMENT,
    nombre         VARCHAR(75) NOT NULL,
    raza           VARCHAR(15) NOT NULL,
    edad           INT         NOT NULL,
    propietario_id INT         NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (propietario_id) REFERENCES propietario (id)
        ON DELETE CASCADE ON UPDATE CASCADE
);
