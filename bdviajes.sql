CREATE DATABASE bdviajes;
CREATE TABLE empresa (
    idempresa BIGINT AUTO_INCREMENT PRIMARY KEY,
    enombre VARCHAR(150),
    edireccion VARCHAR(150)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE persona (
    idpersona BIGINT AUTO_INCREMENT PRIMARY KEY,
    pedocumento VARCHAR(15),
    penombre VARCHAR(150), 
    peapellido VARCHAR(150), 
    petelefono VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



CREATE TABLE responsablev (
    idresponsable BIGINT AUTO_INCREMENT PRIMARY KEY,
    rnumLicencia INT,
    rnombre VARCHAR(255),
    rapellido VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE viaje (
    idviaje BIGINT AUTO_INCREMENT PRIMARY KEY,
    vdestino VARCHAR(150),
    vcantmaxpasajeros INT,
    idempresa BIGINT,
    idresponsable BIGINT,
    vimporte FLOAT,
    FOREIGN KEY (idempresa) REFERENCES empresa (idempresa),
    FOREIGN KEY (idresponsable) REFERENCES responsablev (idresponsable) 
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE pasajero (
    idpasajero BIGINT AUTO_INCREMENT PRIMARY KEY,
    pdocumento VARCHAR(15),
    pnombre VARCHAR(150), 
    papellido VARCHAR(150), 
    ptelefono VARCHAR(20), 
    idviaje BIGINT,
    FOREIGN KEY (idviaje) REFERENCES viaje (idviaje)	
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
