<?php 
include_once 'BaseDatos.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Empresa.php';

/*$destino = "cuba";
$codViaje = "zw12";
$cantidadPasajero = 10;


$ObjEmpresa = new Empresa();
$ObjEmpresa->cargar("Empresa Test", "Calle Falsa 123");
if ($ObjEmpresa->insertar()) {
    echo "Empresa insertada con ID: " . $ObjEmpresa->getIdEmpresa() . "\n";
} else {
    echo "Error al insertar la empresa: " . $ObjEmpresa->getMensajeOperacion() . "\n";
}

$ObjperResponsable = new ResponsableV();
$ObjperResponsable->cargar(1807, "Sol", "Estrella");
$ObjperResponsable->insertar();




$ObjViaje = new Viaje();
$ObjViaje->cargar($destino, $cantidadPasajero, $ObjEmpresa, $ObjperResponsable , 2500);

if($ObjViaje->insertar()){
    echo "\nViaje ingresado con éxito ".$ObjViaje->getCodigoViaje();
} else {
    echo "No se pudo ingresar el viaje.";
}*/

/*$Objpasajero1 = new Pasajero();
$Objpasajero1->cargar(114391007, "Ana", "Rosa", 47567987,$ObjViaje->getCodigoViaje() );
if($Objpasajero1->insertar()){
    echo "\nel pasajero se ingresado con éxito ".$Objpasajero1->getNumeroDocumento();
} else {
    echo "No se pudo ingresar el pasajero.";

}*/

/*echo " \nIngrese el DNI del pasajero a modificar: ";
$dniModificar = trim(fgets(STDIN));
$pasajeroModificar = new Pasajero();
if($pasajeroModificar->buscar($dniModificar)){
echo "Ingrese nuevo nombre: ";
$nuevoNombre = trim(fgets(STDIN));
echo "Ingrese nuevo apellido: ";
$nuevoApellido = trim(fgets(STDIN));
echo "Ingrese nuevo teléfono: ";
$nuevoTelefono = trim(fgets(STDIN));
}
$pasajeroModificar->cargar($dniModificar, $nuevoNombre, $nuevoApellido, $nuevoTelefono, $ObjViaje->getCodigoViaje());
if ($pasajeroModificar->modificar()) {
    echo "Pasajero modificado con éxito.\n";
} else {
    echo "Error al modificar el pasajero.\n";
}

echo " \nModificar Viaje: ";
            echo "Ingrese el id del Viaje a modificar: \n ";
            $idviaje = trim(fgets(STDIN));
            $objviajeMod= new Viaje();
            if($objviajeMod->buscar($idviaje)){
            echo "Ingrese el Destino: \n";
            $destino = trim(fgets(STDIN));
            echo "Ingrese la cantidad de pasajeros: \n ";
            $cantmaxpasajeros = trim(fgets(STDIN));
            echo "Ingrese importe: ";
            $importe = trim(fgets(STDIN));
            }
            $ObjViaje->cargar( $destino, $cantmaxpasajeros, $ObjEmpresa, $ObjperResponsable, $importe);
            if ($ObjViaje->modificar()) {
                echo "Se modificó con éxito.\n";
            } else {
                echo "Error al modificar.\n";
            }*/

           /* echo "\nIngrese id del responsable: ";
            $idRes = trim(fgets(STDIN));
            $responsable = new ResponsableV();
            if($responsable->buscar($idRes)){
            echo "\nIngrese nombre del responsable: ";
            $nuevoNombre = trim(fgets(STDIN));
            echo "\nIngrese nuevo apellido del responsable: ";
            $nuevoApellido = trim(fgets(STDIN));
            echo "\nIngrese nuevo número de licencia del responsable: ";
            $nuevoNumLicencia = trim(fgets(STDIN));
            }
            $responsable->cargar($nuevoNumLicencia, $nuevoNombre, $nuevoApellido);
            if ($responsable->modificar()) {
                echo "Responsable modificado con éxito.\n";
            } else {
                echo "Error al modificar el responsable.\n";
            }
            echo "\ingrese id de la empresa:\n";
            $idEmpresa = trim(fgets(STDIN));
            $Empre=new Empresa();
            if($Empre->buscar($idEmpresa)){
            echo "Ingrese nombre de la empresa:\n";
            $nombreEmpresa = trim(fgets(STDIN));
            echo "Ingrese dirección de la empresa:\n";
            $direccionEmpresa = trim(fgets(STDIN));
            }
            $ObjEmpresa->cargar($nombreEmpresa, $direccionEmpresa);
            if ($ObjEmpresa->modificar()) {
                echo "Empresa se modifico con éxito.\n";
            } else {
                echo "Error al modificar la empresa.\n";
            }
            echo "\nListar Viajes:\n";
            
           echo $ObjViaje->listar();

           echo "\nListar Empresa:\n";
           $objEmpresa = new Empresa(); 
           $Empresas = $objEmpresa->listar(); 
           $listaEmpresa = "";
           foreach ($Empresas as $objempresa) {
               $listaEmpresa .= " " . $objempresa . "\n"; 
           }
           echo $listaEmpresa;

           echo "Listar Responsable:\n";
           $ResponsableV= new ResponsableV();
           $responsables = $ResponsableV->listar();
         foreach ($responsables as $responsable) {
             echo $responsable . "\n";
         }

         echo "\nListar Pasajeros:\n";
$Pasajero = new Pasajero();
$listaPasajero = "";
$pasajeros = $Pasajero->listar();
foreach ($pasajeros as $pasajero) {
    $listaPasajero .= " " . $pasajero . "\n";
}
echo $listaPasajero . "\n";

echo "\nIngrese ID de la empresa a eliminar:\n";
            $idEmpresaEliminar = trim(fgets(STDIN));
            $empresaEliminar = new Empresa();
            if($empresaEliminar->eliminar($idEmpresaEliminar)){
                echo "Empresa eliminada con éxito.\n";
            } else {
                echo "Error al eliminar la empresa.\n";
            }
            echo "Ingrese id de viaje a eliminar: ";
            $id = trim(fgets(STDIN));
            $viajeEliminar = new Viaje();
            $viajeEliminar->setCodigoViaje($id);
            if ($viajeEliminar->eliminar($id)) {
                echo "Se eliminó con éxito.\n";
            } else {
                echo "Error al eliminar viaje.\n";
            }
            echo "\nIngrese el DNI del pasajero a eliminar: ";
            $dniEliminar = trim(fgets(STDIN));
            $pasajeroEliminar = new Pasajero();
            $pasajeroEliminar->setNumeroDocumento($dniEliminar);
            if ($pasajeroEliminar->eliminar($dniEliminar)) {
                echo "Pasajero eliminado con éxito.\n";
            } else {
                echo "Error al eliminar el pasajero.\n";
            }*/
            echo "\nIngrese el id responsable a eliminar: ";
            $idEliminar = trim(fgets(STDIN));
             $responsableEliminar = new ResponsableV(); 
            
            if ($responsableEliminar->eliminar($idEliminar)) {
                echo "Responsable eliminado con éxito.\n";
            } else {
                echo "Error al eliminar el responsable.\n";
            }