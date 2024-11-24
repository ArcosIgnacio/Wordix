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
 * funcion que muestra el menu
 */
function seleccionarOpcion(){
    $verificar=false;;
    $numero=0;

    echo"1) Jugar al wordix con una palabra elegida \n";
    echo"2) Jugar al wordix con una palabra aleatoria \n";
    echo"3) Mostrar una partida \n";
    echo"4) Mostrar la primer partida ganadora \n";
    echo"5) Mostrar resumen de Jugador \n";
    echo"6) Mostrar listado de partidas ordenadas por jugador y por palabra \n";
    echo"7) Agregar una palabra de 5 letras a Wordix \n";
    echo"8) salir \n";
    echo"\n";

    echo"Ingrese a cual opcion desea entrar \n";
    $numero=trim(fgets(STDIN));
    echo"\n";

    if($numero<1 || $numero>8){
        while($verificar!=true){
            echo "Numero invalido \n";
            echo "Vuelva a ingresar el numero \n";
            $numero=trim(fgets(STDIN));
            if($numero>=1 && $numero<=8){
                echo "Numero valido \n";
                echo "\n";
                $verificar=true;
            }
        }
    }
    return $numero;
}

/**
 * obtiene ejemplos de partidas
 * @return array
 */
function cargarPartidas(){
    $coleccionPardas[0] = ["palabraWordix" => "QUESO" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPardas[1] = ["palabraWordix" => "CASAS" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 14];
    $coleccionPardas[2] = ["palabraWordix" => "QUESO" , "jugador" => "pink2000", "intentos"=> 6, "puntaje" => 10];
    $coleccionPardas[3] = ["palabraWordix" => "PERRO" , "jugador" => "juan", "intentos"=> 2, "puntaje" => 8];
    $coleccionPardas[4] = ["palabraWordix" => "LETRA" , "jugador" => "maria", "intentos"=> 4, "puntaje" => 4];
    $coleccionPardas[5] = ["palabraWordix" => "PLATA" , "jugador" => "pink2000", "intentos"=> 1, "puntaje" => 8];
    $coleccionPardas[6] = ["palabraWordix" => "CAMPO" , "jugador" => "capo", "intentos"=> 3, "puntaje" => 14];
    $coleccionPardas[7] = ["palabraWordix" => "NUBES" , "jugador" => "hacker", "intentos"=> 4, "puntaje" => 0];
    $coleccionPardas[8] = ["palabraWordix" => "MATES" , "jugador" => "juan", "intentos"=> 5, "puntaje" => 2];
    $coleccionPardas[9] = ["palabraWordix" => "MESSI" , "jugador" => "majo", "intentos"=> 6, "puntaje" => 0];
    return ($coleccionPardas);
}

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

/* ****COMPLETAR***** */



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

// array $coleccionPartidas
// int $opcion
// boolean $salir
$coleccionPartidas=[]; $opcion; $salir=true;

//Inicialización de variables:
$coleccionPartidas=cargarPartidas();


//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
//print_r($partida);
//imprimirResultado($partida);

do{
    
    $opcion=seleccionarOpcion();

    switch ($opcion){
        case 1:
            break;
        case 2:
            break;
        case 3:
            echo"Hay 10 partidas \n";
            echo"\n";
            for($i=0;$i<count($coleccionPartidas);$i++){
                echo "Partida Nº".($i+1)."\n";
                echo "Palabra: ".$coleccionPartidas[$i]["palabraWordix"]."\n";
                echo "Jugador: ".$coleccionPartidas[$i]["jugador"]."\n";
                echo "Intentos restantes: ".$coleccionPartidas[$i]["intentos"]."\n";
                echo "Puntaje: ".$coleccionPartidas[$i]["puntaje"]."\n";
                echo "\n";
            }
            break;
        case 4:
            break;
        case 5:
            break;
        case 6:
            break;
        case 7:
            break;
        case 8:
            echo"Gracias por jugar wordix!! \n";
            $salir=false;
            break;
    }

}while($salir!=false);


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
