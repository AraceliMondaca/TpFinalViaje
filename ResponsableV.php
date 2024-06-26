<?php
include_once "BaseDatos.php";

class ResponsableV {
    private $numEmpleado;
    private $numLicencia;
    private $nombre;
    private $apellido;
    private $mensajeOperacion;

    public function __construct() {
        $this->numEmpleado = 0;
        $this->numLicencia = 0;
        $this->nombre = "";
        $this->apellido = "";
    }

    public function cargar($numLicencia, $nombre, $apellido) {
        $this->setNumLicencia($numLicencia);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }

    public function getNumEmpleado() {
        return $this->numEmpleado;
    }

    public function getNumLicencia() {
        return $this->numLicencia;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setNumEmpleado($numEmpleado) {
        $this->numEmpleado = $numEmpleado;
    }

    public function setNumLicencia($numLicencia) {
        $this->numLicencia = $numLicencia;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // Método para buscar un responsable por número de empleado
    public function buscar($idresponsable) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM responsableV WHERE idresponsable = $idresponsable";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row2 = $base->Registro()) {
                    $this->setNumEmpleado($idresponsable);
                    $this->setNumLicencia($row2['numLicencia']);
                    $this->setNombre($row2['nombre']);
                    $this->setApellido($row2['apellido']);
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

    // Método estático para listar responsables según una condición opcional
    public static function listar($condicion = "") {
        $arregloResponsables = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM responsableV";
        if ($condicion != "") {
            $consulta .= ' WHERE ' . $condicion;
        }
        $consulta .= " ORDER BY apellido";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arregloResponsables = array();
                while ($row2 = $base->Registro()) {
                    $idresponsable = $row2['idresponsable'];
                    $numLicencia = $row2['numLicencia'];
                    $nombre = $row2['nombre'];
                    $apellido = $row2['apellido'];

                    $objResponsableV = new ResponsableV();
                    $objResponsableV->cargar($numLicencia, $nombre, $apellido);
                    $objResponsableV->setNumEmpleado($idresponsable);
                    array_push($arregloResponsables, $objResponsableV);
                }
            } else {
                echo $base->getError();
            }
        } else {
            echo $base->getError();
        }
        return $arregloResponsables;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsableV (numLicencia, nombre, apellido) 
                             VALUES (" . $this->getNumLicencia() . ", '" . $this->getNombre() . "', '" . $this->getApellido() . "')";

        if ($base->Iniciar()) {
            if ($idEmpleado = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setNumEmpleado($idEmpleado);
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
        $consultaModifica = "UPDATE responsableV SET numLicencia = " . $this->getNumLicencia() . ", nombre = '" . $this->getNombre() . "', apellido = '" . $this->getApellido() . "' WHERE  idresponsable= " . $this->getNumEmpleado();
        
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
            $consultaBorrar = "DELETE FROM responsableV WHERE idresponsable = " . $this->getNumEmpleado();
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
        return "¡DATOS DE PERSONAL RESPONSABLE DEL VIAJE!\n" .
               "Número de Empleado: " . $this->getNumEmpleado() . "\n" .
               "Número de Licencia: " . $this->getNumLicencia() . "\n" .
               "Nombre: " . $this->getNombre() . "\n" .
               "Apellidos: " . $this->getApellido() . "\n";
    }
}
?>
