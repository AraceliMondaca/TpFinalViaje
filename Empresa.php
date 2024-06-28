<?php
class Empresa {
    private $idempresa;
    private $nombre;
    private $direccion;
    private $mensajeOperacion;

    public function __construct() {
        $this->idempresa = "";
        $this->nombre = "";
        $this->direccion = "";
    }

    public function cargar($nombre, $direccion) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
    }

    public function getIdEmpresa() {
        return $this->idempresa;
    }

    public function setIdEmpresa($idempresa) {
        $this->idempresa = $idempresa;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa (enombre, edireccion) VALUES ('" . $this->getNombre() . "', '" . $this->getDireccion() . "')";

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
        $base = new BaseDatos();
        $resp = false;
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->getNombre() . "', edireccion='" . $this->getDireccion() . "' WHERE idempresa=" . $this->getIdEmpresa();

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
        
        // Verificar si hay viajes asociados a esta empresa
        $consultaVerificar = "SELECT COUNT(*) as cantidad FROM viaje WHERE idempresa=" . $this->getIdEmpresa();
        
        if ($base->Iniciar()) {
            $resultado = $base->Ejecutar($consultaVerificar);
            $row = $base->Registro();
            if ($row['cantidad'] == 0) {
                $consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getIdEmpresa();
                if ($base->Ejecutar($consultaBorra)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion($base->getError());
                }
            } else {
                $this->setMensajeOperacion("No se puede eliminar la empresa porque tiene viajes asociados.");
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $resp;
    }

    public function buscar($idempresa) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM empresa WHERE idempresa=" . $idempresa;
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row = $base->Registro()) {
                    $this->setIdEmpresa($idempresa);
                    $this->setNombre($row['enombre']);
                    $this->setDireccion($row['edireccion']);
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
                while ($row = $base->Registro()) {
                    $objEmpresa = new Empresa();
                    $objEmpresa->buscar($row['idempresa']);
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

   public function __toString() {
        return "¡Información de la Empresa!\n" .
               "ID: " . $this->getIdEmpresa() . "\n" .
               "Nombre de Empresa: " . $this->getNombre() . "\n" .
               "Dirección: " . $this->getDireccion() . "\n";
    }
}
?>

