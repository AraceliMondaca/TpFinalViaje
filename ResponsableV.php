<?php
include_once "BaseDatos.php";
include_once "Persona.php";

class ResponsableV extends Persona {
    private $numEmpleado;
    private $numLicencia;
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->numEmpleado = 0;
        $this->numLicencia = 0;
    }

    public function cargar($numeroDocumento,$nombre, $apellido, $telefono, $numLicencia = null) {
        parent::cargar($numeroDocumento,$nombre, $apellido, $telefono);
        $this->setNumLicencia($numLicencia);
    }

    public function getNumEmpleado() {
        return $this->numEmpleado;
    }

    public function getNumLicencia() {
        return $this->numLicencia;
    }

    public function setNumEmpleado($numEmpleado) {
        $this->numEmpleado = $numEmpleado;
    }

    public function setNumLicencia($numLicencia) {
        $this->numLicencia = $numLicencia;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar($idresponsable) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM responsablev  WHERE idresponsable = $idresponsable";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::buscar($row2['idresponsable']);
                    $this->setNumEmpleado($idresponsable);
                    $this->setNumLicencia($row2['rnumLicencia']);
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
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM responsablev ";
        if ($condicion != "") {
            $consulta .= " WHERE " . $condicion;
        }
        $consulta .= " ORDER BY rapellido";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arregloResponsable = array();
                while ($row2 = $base->Registro()) {
                    $objResponsable = new ResponsableV();
                    $objResponsable->buscar($row2['idresponsable']);
                    array_push($arregloResponsable, $objResponsable);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloResponsable;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        if (parent::insertar()) {
            $consultaInsertar = "INSERT INTO responsableV (rnumLicencia, rnombre, rapellido) 
                     VALUES ('" . $this->getNumLicencia() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "')";
            if ($base->Iniciar()) {
                if ($idResponsable = $base->devuelveIDInsercion($consultaInsertar)) {
                    $this->setNumEmpleado($idResponsable);
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
        $resp = false;
        $base = new BaseDatos();
        if (parent::modificar()) {
            $consultaModifica = "UPDATE responsableV SET rnumLicencia='" . $this->getNumLicencia() . "', rnombre='" . $this->getNombre() . "', rapellido='" . $this->getApellido() . "' WHERE idresponsable='" . $this->getNumEmpleado() . "'";
            echo "Consulta Modifica: $consultaModifica"; 
            if ($base->Iniciar()) {
                if ($base->Ejecutar($consultaModifica)) {
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
    

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorrar = "DELETE FROM responsablev WHERE idresponsable='" . $this->getNumEmpleado() . "'";
            if ($base->Ejecutar($consultaBorrar)) {
                if (parent::eliminar()) {
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

    public function __toString() {
        return "      INFORMACION del Responsable\n" . 
               parent::__toString() . "\n" .
               "Número de Licencia: " . $this->getNumLicencia() . "\n";
    }
}
?>
