<?php
include_once 'BaseDatos.php';
include_once 'Viaje.php';

class Pasajero {
    private $mensajeOperacion;
    private $nombre;
    private $apellido;
    private $numeroDocumento;
    private $telefono;
    private $idViaje;
    private $objViaje;

    public function __construct() {
        $this->nombre = "";
        $this->apellido = "";
        $this->numeroDocumento = 0;
        $this->telefono = 0;
        $this->idViaje = 0;
        $this->objViaje = new Viaje();
    }

    public function cargar($pdocumento, $pnombre, $papellido, $ptelefono, $idViaje) {
        $objViaje = new Viaje();
        $id = $objViaje->buscar($idViaje);
        if ($id) {
            $this->setNumeroDocumento($pdocumento);
            $this->setNombre($pnombre);
            $this->setApellido($papellido);
            $this->setTelefono($ptelefono);
            $this->setObjViaje($objViaje);
            $this->setIdViaje($idViaje);
        }
        return $id;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getNumeroDocumento() {
        return $this->numeroDocumento;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setNumeroDocumento($numeroDocumento) {
        $this->numeroDocumento = $numeroDocumento;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function getIdViaje() {
        return $this->idViaje;
    }

    public function setIdViaje($idViaje) {
        $this->idViaje = $idViaje;
    }

    public function getObjViaje() {
        return $this->objViaje;
    }

    public function setObjViaje($objViaje) {
        $this->objViaje = $objViaje;
    }

    public function buscar($documento) {
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE pdocumento = '$documento'";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                if ($row2 = $base->Registro()) {
                    $this->setNumeroDocumento($documento);
                    $this->setNombre($row2['pnombre']);
                    $this->setApellido($row2['papellido']);
                    $this->setTelefono($row2['ptelefono']);

                    $objViaje = new Viaje();
                    $objViaje->buscar($row2['idviaje']);
                    $this->setObjViaje($objViaje);
                    $this->setIdViaje($row2['idviaje']);

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
                    $documento = $row2['pdocumento'];
                    $nombre = $row2['pnombre'];
                    $apellido = $row2['papellido'];
                    $telefono = $row2['ptelefono'];
                    $idViaje = $row2['idviaje'];

                    $objPasajero = new Pasajero();
                    $objPasajero->cargar($documento, $nombre, $apellido, $telefono, $idViaje);
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
        $id = $this->getObjViaje()->getCodigoViaje();
        $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje) 
                             VALUES ('" . $this->getNumeroDocumento() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "', " . $this->getTelefono() . ", $id)";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaInsertar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE pasajero SET pnombre='" . $this->getNombre() . "', papellido='" . $this->getApellido() . "', ptelefono=" . $this->getTelefono() . ", idviaje=" . $this->getObjViaje()->getCodigoViaje() . " WHERE pdocumento='" . $this->getNumeroDocumento() . "'";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorrar = "DELETE FROM pasajero WHERE pdocumento='" . $this->getNumeroDocumento() . "'";
            if ($base->Ejecutar($consultaBorrar)) {
                $resp = true;
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
               "Nombre: " . $this->getNombre() . "\n" .
               "Apellido: " . $this->getApellido() . "\n" .
               "Numero de documento: " . $this->getNumeroDocumento() . "\n" .
               "Telefono: " . $this->getTelefono() . "\n" .
               "Id Viaje: " . $this->getIdViaje() . "\n" .
               "Viaje: " . $this->getObjViaje();
    }
}
?>
