<?php
include_once 'BaseDatos.php';
include_once 'Pasajero.php';
include_once 'ResponsableV.php';
include_once 'Viaje.php';
include_once 'Empresa.php';
include_once 'Persona.php';

// Crear una empresa y almacenarla en la base de datos
$ObjEmpresa = new Empresa();
$ObjEmpresa->cargar("Nombre Empresa", "Dirección Ejemplo");

if ($ObjEmpresa->insertar()) {
    echo "Empresa insertada con ID: " . $ObjEmpresa->getIdEmpresa() . "\n";
} else {
    echo "Error al insertar la empresa: " . $ObjEmpresa->getMensajeOperacion() . "\n";
}

$ObjEmpresa->setNombre("Nuevo Nombre Empresa");
$ObjEmpresa->setDireccion("Nueva Dirección");
$respuesta = $ObjEmpresa->modificar();

if ($respuesta == true) {
    echo "\nOP MODIFICACIÓN: Los datos de la empresa fueron actualizados correctamente\n";
} else {
    echo "Error al modificar la empresa: " . $ObjEmpresa->getMensajeOperacion() . "\n";
}
//listar empresa
    $objEmpresa = new Empresa();
    $empresas = $objEmpresa->listar();
    
    if ($empresas) {
        foreach ($empresas as $empresa) {
            echo "--------------------Empresas---------------------------\n";
            echo "ID Empresa: " . $empresa->getIdEmpresa() . "\n";
            echo "Nombre: " . $empresa->getNombre() . "\n";
            echo "Dirección: " . $empresa->getDireccion() . "\n";
            echo "-------------------------------------------------------\n";
        }
    } else {
        echo "No hay empresas para listar.\n";
    }

//-------------------------------------------------------------------------------------------------------------------
// Crear un responsable y almacenarlo en la base de datos
$ObjperResponsable = new ResponsableV();
$ObjperResponsable->cargar("Marcela", "Herrera", 2406252345, 270624);

if ($ObjperResponsable->insertar()) {
    echo "Responsable insertado con éxito\n";
} else {
    echo "Error al insertar el responsable: " . $ObjperResponsable->getMensajeOperacion() . "\n";
}
//listar Responsable

    $responsables = $ObjperResponsable->listar();
    
    if ($responsables) {
        foreach ($responsables as $responsable) {
            echo "--------------------Responsables------------------------\n";
            echo "ID Responsable: " . $responsable->getNumEmpleado() . "\n";
            echo "Nombre: " . $responsable->getNombre() . "\n";
            echo "Apellido: " . $responsable->getApellido() . "\n";
            echo "DNI: " . $responsable->getNumeroDocumento() . "\n";
            echo "-------------------------------------------------------\n";
        }
    } else {
        echo "No hay responsables para listar.\n";
    }


//---------------------------------------------------------------------------------------------------------------------------
// Crear un viaje y almacenarlo en la base de datos
$objViaje = new Viaje();
$objViaje->cargar("Destino Ejemplo", 10, $ObjEmpresa, $ObjperResponsable, 1500);

if ($objViaje->insertar()) {
    echo "\nViaje ingresado con éxito " . $objViaje->getCodigoViaje() . "\n";
} else {
    echo "No se pudo ingresar el viaje: " . $objViaje->getMensajeOperacion() . "\n";
}

$objViaje->setDestino("Nuevo Destino");
$respuesta = $objViaje->modificar();

if ($respuesta == true) {
    echo "\nOP MODIFICACIÓN: Los datos del viaje fueron actualizados correctamente\n";
} else {
    echo "Error al modificar el viaje: " . $objViaje->getMensajeOperacion() . "\n";
}
//listar Viajes

$viajes = $objViaje->listar();

if ($viajes) {
    foreach ($viajes as $viaje) {
        echo "---------------------Viajes----------------------------\n";
        echo "ID Viaje: " . $viaje->getCodigoViaje() . "\n";
        echo "Destino: " . $viaje->getDestino() . "\n";
        echo "Cantidad de Pasajeros: " . $viaje->getCantidadPasajero() . "\n";
        echo "Responsable: " . $ObjperResponsable . "\n";
        echo "Empresa: " . $ObjEmpresa. "\n";
        echo "Importe: $" . $viaje->getImporte() . "\n";
        echo "-------------------------------------------------------\n";
    }
} else {
    echo "No hay viajes para listar.\n";
}
//---------------------------------------------------------------------------------------------------------------------------
// Crear un objeto Pasajero
$objPasajero = new Pasajero();

// Listar todos los pasajeros almacenados en la BD
$coleccionP = $objPasajero->listar();
foreach ($coleccionP as $un) {
    echo $un;
    echo "-------------------------------------------------------\n";
}

// Generar datos aleatorios para insertar un nuevo pasajero
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$nombre = substr(str_shuffle($permitted_chars), 0, 16);
$apellido = substr(str_shuffle($permitted_chars), 0, 16);
$nrodoc = rand(1000000, 9999999); // Generar un número de documento aleatorio
echo "Voy a insertar el número de documento: " . $nrodoc . "\n";

$objPasajero->cargar($nrodoc, $nombre, $apellido, "telefono_pasajero", $objViaje);
$respuesta = $objPasajero->insertar();

if ($respuesta == true) {
    echo "\nOP INSERCIÓN: El pasajero fue ingresado en la BD\n";
    $coleccionP = $objPasajero->listar();
    foreach ($coleccionP as $un) {
        echo $un;
        echo "-------------------------------------------------------\n";
    }
} else {
    echo "Error al insertar el pasajero: " . $objPasajero->getMensajeOperacion() . "\n";
}
//modificar Pasajero
/*$idPasajeroModificar =$objPasajero->getId()+1 ; 
$objPasajero->setId($idPasajeroModificar);
$objPasajero->setNombre("Nombre Modificado");
$objPasajero->setApellido("Apellido Modificado");*

$respuesta = $objPasajero->modificar();

if ($respuesta == true) {
    echo "\nOP MODIFICACIÓN: Los datos del pasajero fueron actualizados correctamente\n";
    $coleccionP = $objPasajero->listar();
    foreach ($coleccionP as $un) {
        echo $un;
        echo "-------------------------------------------------------\n";
    }
} else {
    echo "Error al modificar el pasajero: " . $objPasajero->getMensajeOperacion() . "\n";
}*/
$objPasajero = new Pasajero();
$idPasajeroModificar = 1; // Asigna el ID inicial desde donde quieres empezar

$maxIntentos = 100; // Número máximo de intentos para evitar bucles infinitos
$intentos = 0;
$modificado = false;

while ($intentos < $maxIntentos && !$modificado) {
    $objPasajero->setId($idPasajeroModificar);
    $objPasajero->setNombre("Nombre Modificado");
    $objPasajero->setApellido("Apellido Modificado");
    
    $respuesta = $objPasajero->modificar();

    if ($respuesta == true) {
        echo "\nOP MODIFICACIÓN: Los datos del pasajero con ID $idPasajeroModificar fueron actualizados correctamente\n";
        $modificado = true;

        // Listar todos los pasajeros almacenados en la BD
        $coleccionP = $objPasajero->listar();
        foreach ($coleccionP as $un) {
            echo $un;
            echo "-------------------------------------------------------\n";
        }
    } else {
        echo "Error al intentar modificar el pasajero con ID $idPasajeroModificar: " . $objPasajero->getMensajeOperacion() . "\n";
    }
    
    // Incrementar el ID y el contador de intentos en cada iteración
    $idPasajeroModificar++;
    $intentos++;
}

   


// Eliminar un pasajero
/*$idPasajero =$objPasajero->getId()+1 ; 
$objPasajero->setId($idPasajero);
$respuesta = $objPasajero->eliminar();

if ($respuesta == true) {
    echo "\nOP ELIMINACIÓN: El pasajero fue eliminado correctamente\n";
    $coleccionP = $objPasajero->listar();
    foreach ($coleccionP as $un) {
        echo $un;
        echo "-------------------------------------------------------\n";
    }
} else {
    echo "Error al eliminar el pasajero: " . $objPasajero->getMensajeOperacion() . "\n";
}*/
$objPasajero = new Pasajero();
$idPasajero = 1; // Asigna el ID inicial desde donde quieres empezar

$maxIntentos = 10; // Número máximo de intentos para evitar bucles infinitos
$intentos = 0;
$eliminado = false;

while ($intentos < $maxIntentos && !$eliminado) {
    $objPasajero->setId($idPasajero);
    $respuesta = $objPasajero->eliminar();

    if ($respuesta == true) {
        echo "\nOP ELIMINACIÓN: El pasajero con ID $idPasajero fue eliminado correctamente\n";
        $eliminado = true;

        // Listar todos los pasajeros almacenados en la BD
        $coleccionP = $objPasajero->listar();
        foreach ($coleccionP as $un) {
            echo $un;
            echo "-------------------------------------------------------\n";
        }
    } else {
        echo "Error al intentar eliminar el pasajero con ID $idPasajero: " . $objPasajero->getMensajeOperacion() . "\n";
    }

    // Incrementar el ID y el contador de intentos en cada iteración
    $idPasajero++;
    $intentos++;
}

///-----------------------------------------------------------------------------------------------------
// Eliminar una empresa
$id=$ObjEmpresa->getIdEmpresa();
$ObjEmpresa->setIdEmpresa($id);
$ObjEmpresa->eliminar();

if ($ObjEmpresa == true) {
    echo "\nOP ELIMINACIÓN: La empresa fue eliminada correctamente\n";
} else {
    echo "Error al eliminar la empresa: " . $ObjEmpresa->getMensajeOperacion() . "\n";
}

?>
