<?php

include_once 'BaseDatos.php';

class Empresa {
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    public function __construct() {
        $this->idEmpresa = 0;
        $this->nombre = "";
        $this->direccion = "";
    }

    public function cargar($nombre, $direccion) {
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getIdEmpresa() {
        return $this->idEmpresa;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar($idEmpresa) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM empresa WHERE idempresa = $idEmpresa";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdEmpresa($idEmpresa);
                    $this->setNombre($row2['enombre']);
                    $this->setDireccion($row2['edireccion']);
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
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM empresa";
        if ($condicion != "") {
            $consulta .= ' WHERE ' . $condicion;
        }
        $consulta .= " ORDER BY enombre";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {
                    $idEmpresa = $row2['idempresa'];
                    $nombre = $row2['enombre'];
                    $direccion = $row2['edireccion'];

                    $objEmpresa = new Empresa();
                    $objEmpresa->cargar($nombre, $direccion);
                    $objEmpresa->setIdEmpresa($idEmpresa);
                    array_push($arregloEmpresa, $objEmpresa);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloEmpresa;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
                     VALUES('".$this->getNombre()."','".$this->getDireccion()."')";
        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdEmpresa($id);
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
        $consultaModifica = "UPDATE empresa SET enombre='".$this->getNombre()."', edireccion='".$this->getDireccion()."' WHERE idempresa=".$this->getIdEmpresa();
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
            $consultaBorrar = "DELETE FROM empresa WHERE idempresa = " . $this->getIdEmpresa();
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
        return "¡Información de la Empresa!\n" .
               "ID: " . $this->getIdEmpresa() . "\n" .
               "Nombre de Empresa: " . $this->getNombre() . "\n" .
               "Dirección: " . $this->getDireccion() . "\n";
    }
}
?>

