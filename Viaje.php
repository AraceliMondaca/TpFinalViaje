<?php
include_once 'BaseDatos.php';
include_once 'ResponsableV.php';
include_once 'Pasajero.php';
include_once 'Empresa.php';

class Viaje {
    private $codigoViaje;
    private $destino;
    private $cantidadPasajero;
    private $objColPasajero;
    private $objPersonaResp;
    private $mensajeOperacion;
    private $objEmpresa;
    private $importe;

    public function __construct() {
        $this->codigoViaje = "";
        $this->destino = "";
        $this->cantidadPasajero = 0;
        $this->objColPasajero = [];
        $this->objPersonaResp = new ResponsableV();
        $this->objEmpresa = new Empresa();
        $this->importe = 0;
    }

    public function cargar($destino, $cantidadPasajero, $objEmpresa, $objPersonaResp, $importe) {
        $this->setDestino($destino);
        $this->setCantidadPasajero($cantidadPasajero);
        $this->setObjEmpresa($objEmpresa);
        $this->setObjPersonaResp($objPersonaResp);
        $this->setImporte($importe);
    }

    public function getCodigoViaje() {
        return $this->codigoViaje;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function getCantidadPasajero() {
        return $this->cantidadPasajero;
    }

    public function getObjColPasajero() {
        return $this->objColPasajero;
    }

    public function getObjPersonaResp() {
        return $this->objPersonaResp;
    }

    public function getObjEmpresa() {
        return $this->objEmpresa;
    }

    public function getImporte() {
        return $this->importe;
    }

    public function setCodigoViaje($codigoViaje) {
        $this->codigoViaje = $codigoViaje;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function setCantidadPasajero($cantidadPasajero) {
        $this->cantidadPasajero = $cantidadPasajero;
    }

    public function setObjColPasajero($objColPasajero) {
        $this->objColPasajero = $objColPasajero;
    }

    public function setObjPersonaResp($objPersonaResp) {
        $this->objPersonaResp = $objPersonaResp;
    }

    public function setObjEmpresa($objEmpresa) {
        $this->objEmpresa = $objEmpresa;
    }

    public function setImporte($importe) {
        $this->importe = $importe;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function buscar($idViaje) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM viaje WHERE idviaje = $idViaje";
        $resp = false;
       
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                
                if ($row2 = $base->Registro()) {
                    $objEmpresa = new Empresa();
                    $objEmpresa->Buscar($row2['idempresa']);
                    $objPersonaResp = new ResponsableV();
                    $objPersonaResp->Buscar($row2['idresponsable']);
                    
                    $this->setCodigoViaje($idViaje);
                    $this->setDestino($row2['vdestino']);
                    $this->setCantidadPasajero($row2['vcantmaxpasajeros']);
                    $this->setObjEmpresa($objEmpresa);
                    $this->setObjPersonaResp($objPersonaResp);
                    $this->setImporte($row2['vimporte']);
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
        $arregloViaje = null;
        $base = new BaseDatos();
        $consulta = "SELECT * FROM viaje";
        if ($condicion != "") {
            $consulta .= ' WHERE ' . $condicion;
        }
        $consulta .= " ORDER BY vdestino";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $arregloViaje =array();
                while ($row2 = $base->Registro()) {
                    $idViaje = $row2['idviaje'];
                    $destino = $row2['vdestino'];
                    $cantidadPasajero = $row2['vcantmaxpasajeros'];
                    $idEmpresa = $row2['idempresa'];
                    $idResponsable = $row2['idresponsable'];
                    $importe = $row2['vimporte'];
            
                    $objEmpresa = new Empresa();
                    $objEmpresa->Buscar($idEmpresa);
                    $objPersonaResp = new ResponsableV();
                    $objPersonaResp->Buscar($idResponsable);

                    $objViaje = new Viaje();
                    $objViaje->cargar($destino, $cantidadPasajero, $objEmpresa, $objPersonaResp, $importe);
                    $objViaje->setCodigoViaje($idViaje);
                    array_push($arregloViaje, $objViaje);
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloViaje;
    }

    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, idresponsable, vimporte) 
                             VALUES ('" . $this->getDestino() . "', " . $this->getCantidadPasajero() . ", " . $this->getObjEmpresa()->getIdEmpresa() . ", " . $this->getObjPersonaResp()->getNumEmpleado() . ", " . $this->getImporte() . ")";

        if ($base->Iniciar()) {
            if ($id = $base->devuelveIDInsercion($consultaInsertar)) {
                $this->setCodigoViaje($id);
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
        $consultaModifica = "UPDATE viaje SET vdestino = '" . $this->getDestino() . "', vcantmaxpasajeros = " . $this->getCantidadPasajero() . ", idempresa = " . $this->getObjEmpresa()->getIdEmpresa() . ", idresponsable = " . $this->getObjPersonaResp()->getNumEmpleado() . ", vimporte = " . $this->getImporte() . " WHERE idviaje = " . $this->getCodigoViaje();

        if ($base->Iniciar()) {
            if($this->buscar( $this->getCodigoViaje())){
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
            $consultaBorra = "DELETE FROM viaje WHERE idviaje = " . $this->getCodigoViaje();
            if($this->buscar( $this->getCodigoViaje())){
            if ($base->Ejecutar($consultaBorra)) {
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

    public function __toString() {
       
        $viaje = "                 !DATOS DEL VIAJE! \n" . 
            "Codigo del Viaje: " . $this->getCodigoViaje() . "\n" . 
            "Destino: " . $this->getDestino() . "\n" .
            "Cantidad de Pasajeros: " . $this->getCantidadPasajero() . "\n" .
           // "Lista de Pasajeros: \n" . print_r($listaPasajeros, true) . "\n" .
            "Responsable: " . $this->getObjPersonaResp() . "\n" .
            "Empresa: " . $this->getObjEmpresa() . "\n" .
            "Importe: " . $this->getImporte() . "\n";
        return $viaje;
    }
}
?>
