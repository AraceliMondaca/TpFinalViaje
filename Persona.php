<?php 
class Persona{
    private $mensajeOperacion;
    private $nombre;
    private $apellido;
    private $numeroDocumento;
    private $telefono;
    private $id;
public function __construct(){
    $this->id=0;
    $this->nombre =0;
    $this->apellido = 0;
    $this->numeroDocumento = 0;
    $this->telefono = 0;
   
}
public function cargar($numeroDocumento,$nombre,$apellido,$telefono){ 
    $this->setApellido($numeroDocumento);
    $this->setNumeroDocumento( $nombre);
    $this->setNombre($apellido);
    $this->setTelefono($telefono);
      
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
    public function getId() {
        return $this->id;
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
    public function setId($id) {
        $this->id = $id;
    }
    public function buscar($id) {
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM persona WHERE idpersona = $id";
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajero)) {
                if ($row2 = $base->Registro()) {
                    $this->setId($row2['idpersona']);
                    $this->setNumeroDocumento($row2['pedocumento']);
                    $this->setNombre($row2['penombre']);
                    $this->setApellido($row2['peapellido']);
                    $this->setTelefono($row2['petelefono']);
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
        $arregloPersona = array(); 
        $base = new BaseDatos();
        $consulta = "SELECT * FROM persona";
        if ($condicion != "") {
            $consulta .= ' WHERE ' . $condicion;
        }
        $consulta .= " ORDER BY peapellido";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                while ($row2 = $base->Registro()) {
                    $id = $row2['idpersona'];
                    $documento = $row2['pedocumento'];
                    $nombre = $row2['penombre'];
                    $apellido = $row2['peapellido'];
                    $telefono = $row2['petelefono'];
                    $objPersona = new Persona();
                    
                    $objPersona->cargar($nombre, $apellido, $documento, $telefono);
                    $objPersona->setId($id);
                    array_push($arregloPersona, $objPersona); 
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion($base->getError());
        }
        return $arregloPersona;
    }
    
    public function insertar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO persona(pedocumento, penombre, peapellido, petelefono) 
                             VALUES ('" . $this->getNumeroDocumento() . "', '" . $this->getNombre() . "', '" . $this->getApellido() . "', '" . $this->getTelefono() . "')";
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
    $consultaModifica = "UPDATE persona SET pedocumento='" . $this->getNumeroDocumento() . "', penombre='" . $this->getNombre() . "', peapellido='" . $this->getApellido() . "', petelefono='" . $this->getTelefono() . "' WHERE idpersona='" . $this->getId() . "'";

    if ($base->Iniciar()) {
        if ($this->buscar($this->getId())) {
            if ($base->Ejecutar($consultaModifica)) {
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
public function eliminar() {
    $base = new BaseDatos();
    $resp = false;

    if ($base->Iniciar()) {
        if ($this->buscar($this->getId())) {
            $consultaBorrar = "DELETE FROM persona WHERE idpersona='" . $this->getId() . "'";

            if ($base->Ejecutar($consultaBorrar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        } else {
            $this->setMensajeOperacion("La persona con ID " . $this->getId() . " no existe.");
        }
    } else {
        $this->setMensajeOperacion($base->getError());
    }

    return $resp;
}

          

public function __tostring(){
    $persona="";
    $persona="      INFORMACION de Persona               \n ". 
    "DNI: ".$this->getNumeroDocumento(). "\n".  
    "Nombre: ".$this->getNombre()."\n".  
    "Apellido: ".$this->getApellido()."\n". 
    "Telefono: ".$this->getTelefono();
    return $persona;
    
}
}
?>