<?php
include_once("wordix.php");


/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido, Nombre. Legajo. Carrera. mail. Usuario Github */
/* ****COMPLETAR***** */


/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * Obtiene una colección de palabras
 * @return array
 */
function cargarColeccionPalabras()
{
    $coleccionPalabras = [
        "MUJER", "QUESO", "FUEGO", "CASAS", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS"
        /* Agregar 5 palabras más */
    ];

    return ($coleccionPalabras);
}

/**
 *  punto 3 
 *  Muestra el menú de opciones y solicita una opciín valida al usuario.
 * 
 *  @return int $opcion
 */
function seleccionarOpcion() {
    // variable interna: int
    do {
        echo "Menú de opciones: \n";
        echo "1) Jugar al wordix con una palabra elegida \n";
        echo "2) Jugar al wordix con una palabra aleatoria \n";
        echo "3) Mostrar una partida \n";
        echo "4) Mostrar la primer partida ganadora \n";
        echo "5) Mostrar resumen de Jugador \n";
        echo "6) Mostrar listado de partidas ordenadas por jugador y por palabra \n";
        echo "7) Agregar una palabra de 5 letras a Wordix \n";
        echo "8) Salir \n";

        // Lee la opción del usuario
        $opcion = trim(fgets(STDIN));

        if (is_numeric($opcion)) { //determina si un string es un número. puede ser float como entero.
            $opcion  = $opcion * 1; //con esta operación convierto el string en número.
        }

        // Valida que la opción sea un número entre 1 y 8
        if (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion < 1 || $opcion > 8) {
            echo "La opcion es invalida. Por favor, ingresa un numero entre 1 y 8.\n";
        } 

    } while (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion < 1 || $opcion > 8);

    return $opcion;
}


/**
 *  punto 7
 *  Agrega una palabra nueva de 5 letras a la colección de palabras.
 * 
 *  @param array $coleccionPalabrasNueva
 *  @param string $palabraNueva 
 *  @return array 
 */
function agregarPalabra($coleccionPalabrasNueva, $palabraNueva) {
    // variables internas: $palabraAgregada
    $palabraAgregada = false;

    while (!$palabraAgregada) {
        if (!in_array($palabraNueva, $coleccionPalabrasNueva)) {
            $coleccionPalabrasNueva[] = $palabraNueva;
            echo "La palabra ya se agregó.\n";
            $palabraAgregada = true;
        } else {
            echo "La palabra ya está en la colección. Intentalo de nuevo.\n";
            $palabraNueva = leerPalabra5Letras(); 
        }
    }

    return $coleccionPalabrasNueva;
}



/* ****COMPLETAR***** */



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:


//Inicialización de variables:


//Proceso:

$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);



/*
do {
    $opcion = ...;

    
    switch ($opcion) {
        case 1: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 1

            break;
        case 2: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 2

            break;
        case 3: 
            //completar qué secuencia de pasos ejecutar si el usuario elige la opción 3

            break;
        
            //...
    }
} while ($opcion != X);
*/
