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
 * funcion para agregar una palabra a la coleccion de palabras
 * @param array $array
 * @param string $palabra
 * @return array $array
 */
function agregarPalabra($array,$palabra){
    $array[]=$palabra;
    return $array;
}


/**
 * funcion que muestra la partida guardada que solicite el usuario
 * @param int $numero
 */
function mostrarPartida($numero){
    $confirmar=false;
    if($numero<0 || $numero>9 && (($numero == (int)$numero))){
        while($confirmar!=true || !(is_numeric($numero)) && (($numero == (int)$numero))){
            echo "Partida invalida \n";
            echo "Vuelva a ingresar el numero \n";
            $numero=trim(fgets(STDIN));
            if($numero>=0 && $numero<=9 && (($numero == (int)$numero))){
                echo "Numero valido \n";
                echo "\n";
                $confirmar=true;
            }
        }
    }
    $array=cargarPartidas();
    for($i=0;$i<count($array);$i++){
        if($i==$numero){
                echo "Partida Nº".($i)."\n";
                echo "Palabra: ".$array[$i]["palabraWordix"]."\n";
                echo "Jugador: ".$array[$i]["jugador"]."\n";
                echo "Intentos restantes: ".$array[$i]["intentos"]."\n";
                echo "Puntaje: ".$array[$i]["puntaje"]."\n";
                echo "\n";
        }
    }
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
    $coleccionPardas[9] = ["palabraWordix" => "MESSI" , "jugador" => "majo", "intentos"=> 6, "puntaje" => 4];
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
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS", 
        "VACAS", "MALLA", "MESAS", "CONTA", "BAÑOS"
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
 *  La funcion tiene como parametros de entrada una coleccion de palabras y el nombre de un jugador.
 *  La funcion retorna la primer partida ganada por el jugar. Si el jugado aun no ha ganado una partida,
 *  la funcion retorna el valor -1
 *  
 *  @param array $partidas
 *  @param string $jugador
 *  @return int
 */
function primerPartidaGanada($partidas, $jugador) {
    // variables internaas: int $i
    //                      int $primeraGanada

    $primeraGanada = -1;
    $ganadaMenor = 999;

    
        for($i = 0; $i < count($partidas); $i++) {
            if ($partidas[$i]["jugador"] == $jugador && $partidas[$i]["puntaje"] > 0 && $i < $ganadaMenor) {
                    $ganadaMenor = $i;
                    $primeraGanada = $i;
            }
        }
        return $primeraGanada;
}


/* ****COMPLETAR***** */



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

// boolean $jugadorValido
// boolean $jugadoExiste
$partidaGanadora;
// array $coleccionPartidas
// int $opcion
// boolean $salir
// int $numero
// string $palabra
// array $coleccionPalb
$coleccionPartidas=[]; $opcion; $salir=true; $numero; $palabra; $coleccionPalb=[]; $jugadorExiste;

//Inicialización de variables:
$coleccionPartidas=cargarPartidas();
$coleccionPalb=cargarColeccionPalabras();


//Proceso:

//$partida = jugarWordix("MELON", strtolower("MaJo"));
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
