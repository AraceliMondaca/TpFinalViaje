CREATE DATABASE bdviajes;

CREATE TABLE empresa (
    idempresa BIGINT AUTO_INCREMENT,
    enombre VARCHAR(150),
    edireccion VARCHAR(150),
    PRIMARY KEY (idempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE responsablev (
    idresponsable BIGINT AUTO_INCREMENT PRIMARY KEY,
    numLicencia INT,
    nombre VARCHAR(255),
    apellido VARCHAR(255)
);

CREATE TABLE viaje (
    idviaje BIGINT AUTO_INCREMENT,
    vdestino VARCHAR(150),
    vcantmaxpasajeros INT,
    idempresa BIGINT,
    idresponsable BIGINT, 
    vimporte FLOAT,
    PRIMARY KEY (idviaje),
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
    FOREIGN KEY (idresponsable) REFERENCES responsablev (idresponsable) 
    ON UPDATE CASCADE
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pasajero (
    pdocumento VARCHAR(15),
    pnombre VARCHAR(150), 
    papellido VARCHAR(150), 
    ptelefono VARCHAR(20), 
    idviaje BIGINT,
    PRIMARY KEY (pdocumento),
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
