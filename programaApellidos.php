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
 * Funcion que muestra un resumen de las estadisticas de un usuario sobre sus partidas
 * @param array $array
 * @param string $nombre
 */
function resumenJugador($array,$nombre){
    $intento=[1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0]; $cantPartidas=0; $cantPuntaje=0; $cantVictorias=0; $porcentaje=0;
    for($i=0;$i<count($array);$i++){
        if($array[$i]["jugador"]==$nombre){
            $cantPartidas+=1;
            if($array[$i]["puntaje"]>0){
                $cantPuntaje+=$array[$i]["puntaje"];
                $cantVictorias+=1;
            }
        }
    }
    for ($i = 0; $i < count($array); $i++) {
        $partida = $array[$i];
        if ($partida ["jugador"] == $nombre && $partida ["puntaje"] > 0) {
            $intentoGanado = 6 - $partida ["intentos"];
            if ($intentoGanado >= 1 && $intentoGanado <= 6) {
                $intento[$intentoGanado]+=1;
            }
        }
    }
    if($cantPartidas==0){
        $porcentaje=0;
        echo"Jugador: ".$nombre."\n";
        echo"Partidas: ".$cantPartidas."\n";
        echo"Puntaje Total: ".$cantPuntaje."\n";
        echo"Victorias: ".$cantVictorias."\n";
        echo"Porcentaje de Victorias: ".$porcentaje."%\n";

        for($i=1;$i<=6;$i++){
            echo"       Intento ".$i.": 0\n";
        }
        echo"\n";
    }else{
        $porcentaje=($cantVictorias*100)/$cantPartidas;
        echo"Jugador: ".$nombre."\n";
        echo"Partidas: ".$cantPartidas."\n";
        echo"Puntaje Total: ".$cantPuntaje."\n";
        echo"Victorias: ".$cantVictorias."\n";
        echo"Porcentaje de Victorias: ".$porcentaje."%\n";
        echo"Adivinadas: \n";

        for($i=1;$i<=6;$i++){
            echo"       Intento ".$i.": ".$intento[$i]."\n";
        }
        echo"\n";
    }
}

/**
 * funcion que revisa el menor indice en que gano o si perdio
 * @param array $array
 * @param string $nombre
 * @return int $indice
 */
function primerPartidaGanadora($array,$nombre){
    $indice=-1; $menor=1000;
    for($i=0;$i<count($array);$i++){
        if($array[$i]["jugador"]==$nombre && $array[$i]["puntaje"]>0 && $i<$menor){
            $menor=$i;
            $indice=$i;
        }
    }
    return $indice;
}


/**
 * funcion que permite al usuario ingresar a las distintas opciones del menu
 * @return int $opcion
 */
function seleccionarOpcion() {
    // variable interna entero $opcion
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
        echo"\n";

        echo"Seleccione una opcion: ";
        echo"\n";

        // Lee la opción del usuario
        $opcion = trim(fgets(STDIN));

        if (is_numeric($opcion)) { //determina si un string es un número. puede ser float como entero.
            $opcion  = $opcion * 1; //con esta operación convierto el string en número.
        }

        // Valida que la opción sea un número entre 1 y 8
        if (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion < 1 || $opcion > 8) {
            echo "La opción es inválida. Por favor, ingrese un número entre 1 y 8.\n";
            echo"\n";
        } 

    } while (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion < 1 || $opcion > 8);

    return $opcion;
}


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
                echo "Partida Wordix".($i+1)."\n";
                echo "Palabra: ".$array[$i]["palabraWordix"]."\n";
                echo "Jugador: ".$array[$i]["jugador"]."\n";
                echo "Intentos restantes: ".$array[$i]["intentos"]."\n";
                echo "Puntaje: ".$array[$i]["puntaje"]."\n";
                echo "\n";
        }
    }
}

/**
 * funcion que muestra el menu
 */


/**
 * obtiene ejemplos de partidas
 * @return array
 */
function cargarPartidas(){
    $coleccionPardas[0] = ["palabraWordix" => "QUESO" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPardas[1] = ["palabraWordix" => "CASAS" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 16];
    $coleccionPardas[2] = ["palabraWordix" => "QUESO" , "jugador" => "pink2000", "intentos"=> 5, "puntaje" => 20];
    $coleccionPardas[3] = ["palabraWordix" => "PERRO" , "jugador" => "juan", "intentos"=> 2, "puntaje" => 17];
    $coleccionPardas[4] = ["palabraWordix" => "LETRA" , "jugador" => "majo", "intentos"=> 4, "puntaje" => 17];
    $coleccionPardas[5] = ["palabraWordix" => "PLATA" , "jugador" => "pink2000", "intentos"=> 1, "puntaje" => 14];
    $coleccionPardas[6] = ["palabraWordix" => "CAMPO" , "jugador" => "majo", "intentos"=> 3, "puntaje" => 15];
    $coleccionPardas[7] = ["palabraWordix" => "NUBES" , "jugador" => "majo", "intentos"=> 4, "puntaje" => 18];
    $coleccionPardas[8] = ["palabraWordix" => "MATES" , "jugador" => "juan", "intentos"=> 5, "puntaje" => 18];
    $coleccionPardas[9] = ["palabraWordix" => "MESSI" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 13];
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

/* ****COMPLETAR***** */



/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

// array $coleccionPartidas
// int $opcion
// boolean $salir
// int $numero
// string $palabra
// array $coleccionPalb
// string $nombreJugador
// int $partidaGanadora
// boolean $jugadorExiste
// boolean $jugadorValido
$coleccionPartidas=[]; $opcion; $salir=true; $numero; $palabra; $coleccionPalb=[]; $nombreJugador; $partidaGanadora; $jugadorExiste; $jugadorValido;

//Inicialización de variables:
$coleccionPartidas=cargarPartidas();
$coleccionPalb=cargarColeccionPalabras();


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
            echo"Ingrese que partida quiere ver(1 a 10): ";
            $numero=trim(fgets(STDIN));
            echo"\n";
            mostrarPartida($numero);
            echo"\n";
            break;
        case 4:
            $jugadorExiste = false;
            $jugadorValido=false;
            while (!$jugadorValido) {

                echo "Ingrese el nombre del jugador: ";
                $nombreJugador = trim(fgets(STDIN));
                $nombreJugador = strtolower($nombreJugador);

                if (esPalabra($nombreJugador)) {
                    $jugadorExiste = false;
                    foreach($coleccionPartidas as $partida) {
                        if (strtolower($partida["jugador"]) == $nombreJugador) {
                            $jugadorExiste = true;
                        }
                    }
                }
                
                if ($jugadorExiste == true) {
                    $jugadorValido = true;
                } else {
                    echo "el jugador no existe.\n";//     php programaApellidos.php
                }
            }
            echo"\n";
            $partidaGanadora=primerPartidaGanadora($coleccionPartidas,$nombreJugador);
            if($partidaGanadora!=-1){
                echo"Partida Wordix ".($partidaGanadora+1).": Palabra ".$coleccionPartidas[$partidaGanadora]["palabraWordix"]." \n";
                echo"Jugador: ".$coleccionPartidas[$partidaGanadora]["jugador"]." \n";
                echo"Puntaje: ".$coleccionPartidas[$partidaGanadora]["puntaje"]." puntos \n";
                echo"Intento: Adivino la palabra en ".$coleccionPartidas[$partidaGanadora]["intentos"]." intentos \n";
                echo" \n";

            }elseif($partidaGanadora==-1){
                echo"El jugador no adivino la palabra \n";
                echo" \n";
            }
            break;
        case 5:
            $jugadorExiste = false;
            $jugadorValido=false;
            while (!$jugadorValido) {

                echo "Ingrese el nombre del jugador: ";
                $nombreJugador = trim(fgets(STDIN));
                $nombreJugador = strtolower($nombreJugador);

                if (esPalabra($nombreJugador)) {
                    $jugadorExiste = false;
                    foreach($coleccionPartidas as $partida) {
                        if (strtolower($partida["jugador"]) == $nombreJugador) {
                            $jugadorExiste = true;
                        }
                    }
                }
                
                if ($jugadorExiste == true) {
                    $jugadorValido = true;
                } else {
                    echo "el jugador no existe.\n";//     php programaApellidos.php
                }
            }
            echo"\n";
            resumenJugador($coleccionPartidas,$nombreJugador);
            break;
        case 6:
            break;
        case 7:
            $palabra=leerPalabra5Letras();
            $coleccionPalb=agregarPalabra($coleccionPalb,$palabra);
            echo"\n";
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
