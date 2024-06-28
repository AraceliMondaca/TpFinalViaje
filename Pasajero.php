<?php
include_once 'BaseDatos.php';
include_once 'Viaje.php';
include_once 'Persona.php';

class Pasajero extends Persona {
    private $mensajeOperacion;
    private $objViaje;
    private $id;

    public function __construct() {
        parent::__construct();
        $this->id = 0;
        $this->objViaje = new Viaje();
    }

    public function cargar($numeroDocumento, $nombre, $apellido, $telefono, $objViaje = null) {
        parent::cargar($numeroDocumento, $nombre, $apellido, $telefono);
        $this->setObjViaje($objViaje);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function getObjViaje() {
        return $this->objViaje;
    }

    public function setObjViaje($objViaje) {
        $this->objViaje = $objViaje;
    }

    public function buscar($id) {
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE idpasajero = '$id'";
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                if ($row2 = $base->Registro()) {
                    parent::buscar($id);
                    $this->setNumeroDocumento($row2['pdocumento']);
                    $this->setNombre($row2['pnombre']);
                    $this->setApellido($row2['papellido']);
                    $this->setTelefono($row2['ptelefono']);
                    $objViaje = new Viaje();
                    $objViaje->buscar($row2['idviaje']);
                    $this->setObjViaje($objViaje);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function listar($condicion = "") {
        $arregloPasajeros = null;
        $base = new BaseDatos();
        $consultaPasajeros = "SELECT * FROM pasajero";

        if ($condicion != "") {
            $consultaPasajeros .= ' WHERE ' . $condicion;
        }

        $consultaPasajeros .= " ORDER BY papellido";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajeros)) {
                $arregloPasajeros = array();

                while ($row2 = $base->Registro()) {
                    $objPasajero = new Pasajero();
                    $objPasajero->buscar($row2['idpasajero']);
                    array_push($arregloPasajeros, $objPasajero);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPasajeros;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        if (parent::insertar()) {
            $consultaInsertar = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) 
                                 VALUES ('" . $this->getNumeroDocumento() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "', '" . $this->getTelefono() . "', " . $this->getObjViaje()->getCodigoViaje() . ")";
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaInsertar)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }
        return $resp;
    }

    public function modificar() {
        $base = new BaseDatos();
        $resp = false;

        // Verificar si el pasajero existe
        if ($this->buscar($this->getId())) {
            $consultaModifica = "UPDATE pasajero SET 
                                 pdocumento='" . $this->getNumeroDocumento() . "', 
                                 pnombre='" . $this->getNombre() . "', 
                                 papellido='" . $this->getApellido() . "', 
                                 ptelefono='" . $this->getTelefono() . "', 
                                 idviaje=" . $this->getObjViaje()->getCodigoViaje() . " 
                                 WHERE idpasajero='" . $this->getId() . "'";

            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModifica)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion("El pasajero con ID " . $this->getId() . " no existe.");
        }

        return $resp;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;

        if ($base->Iniciar()) {
            $consultaBorrar = "DELETE FROM pasajero WHERE idpasajero='" . $this->getId() . "'";

            if (parent::eliminar()) {
                if ($base->Ejecutar($consultaBorrar)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }

        return $resp;
    }

    public function __toString() {
        return "PASAJERO: \n" .
               parent::__toString() . "\n" .
               "Id Viaje: " . $this->getObjViaje()->getCodigoViaje() . "\n";
    }
}
?>
