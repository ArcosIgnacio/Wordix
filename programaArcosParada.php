<?php
include_once("wordix.php");


/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido = Arcos , Nombre = Ignacio . Legajo = Fai-5472 . Carrera = TUDW . Mail = ignacio.arcos@est.fi.uncoma.edu.ar . Usuario Github = ArcosIgnacio*/
/* Apellido = Parada , Nombre = Mateo . Legajo = Fai-5359 . Carrera = TUDW . Mail = mateo.parada@est.fi.uncoma.edu.ar . Usuario Github = mateoparada*/


/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/

/**
 * funcion para ingresar un numero valido entero dentro de los indices correspondientes
 * @param string[] $array
 * @return int $numero
 */
// function numeroValido($array){
//     echo"Ingrese un numero del 1 y ".count($array).": ";
//     $numero=solicitarNumeroEntre(1, count($array));
//     $numero--;
//     return $numero;
// }

/**
 * funcion que solicita un numero valido y verifica que este no se haya usado por el jugador anteriormente
 * @param string $nombre
 * @param array $array1
 * @param string[] $array2
 * @return int $numero
 */
function palabraUsada($nombre,$array1,$array2){
    $auntenticar=true;
    $cont=0;
    echo"Ingrese un numero del 1 y ".count($array2).": ";
    $numero=solicitarNumeroEntre(1, count($array2));
    $numero--;
    while($auntenticar!=false){
        if ($cont < count($array1)) {
            // Compara si el jugador y la palabra coinciden
            if ($array1[$cont]["jugador"] == $nombre && $array1[$cont]["palabraWordix"] == $array2[$numero] && $array1[$cont]["puntaje"]>0) {
                echo "La palabra ya fue jugada por ".$nombre." \n";
                echo"\n";
                $numero=-1;
                $auntenticar = false;
            } else {
                // Si no es la palabra que buscamos, seguimos con la siguiente partida
                $cont += 1;
            }
        } else {
            $auntenticar = false;
            echo"\n";
        }
    }
    return $numero;
}

/**
 * funcion que ingresa un indice aleatoria y corrobora que no se haya usado antes
 * @param string $nombre
 * @param array $array1
 * @param string[] $array2
 * @return int $indice
 */
function palabraAleatoria($nombre,$array1,$array2){
    $auntenticar=true;
    $indice=array_rand($array2);
    $cont=0;
    while($auntenticar!=false){
        if ($cont < count($array1)) {
            // Compara si el jugador y la palabra coinciden
            if ($array1[$cont]["jugador"] == $nombre && $array1[$cont]["palabraWordix"] == $array2[$indice] && $array1[$cont]["puntaje"] > 0) {
                echo "La palabra ya fue jugada por " . $nombre . " \n";
                echo"\n";
                $indice=-1;
                $auntenticar = false; // Si se encuentra, terminamos el ciclo
            } else {
                // Si no es la palabra que buscamos, seguimos con la siguiente partida
                $cont += 1;
            }
        } else {
            $auntenticar = false;
        }
    }
    return $indice;
}

/**
 * Esta funcion comprara el nombre de los jugadores y 
 */
function comparacion($a, $b) {
    // Primero comparar por el nombre del jugador
    if ($a['jugador'] < $b['jugador']) {
       $interno=-1; // Si $a['jugador'] es menor que $b['jugador'], $a va primero
    } elseif ($a['jugador'] > $b['jugador']) {
       $interno=1; // Si $a['jugador'] es mayor que $b['jugador'], $b va primero
    } else {
       // Si los jugadores son iguales, comparamos por la palabra
        if ($a['palabraWordix'] < $b['palabraWordix']) {
           $interno=-1; // Si $a['palabraWordix'] es menor que $b['palabraWordix'], $a va primero
        } elseif ($a['palabraWordix'] > $b['palabraWordix']) {
           $interno=1; // Si $a['palabraWordix'] es mayor que $b['palabraWordix'], $b va primero
        } else {
           $interno=0; // Si los jugadores y las palabras son iguales, no cambia el orden
        }
    }
    return $interno;
}


/**
* funcion que ordena la coleccion de partidas por nombre y palabra en forma ascendentemente
* @param array $array
*/
function ordenarPartidas($array) {
    uasort($array, "comparacion");

   // Imprimir el resultado ordenado
    print_r($array);
}

/**
 * La funcion solicita el nombre al ususario el nombre de un jugador y retorna el nombre en minusculas
 * @return string $nombre
 */
function solicitarJugador() {
    echo "\n";
    echo"Ingrese el nombre del jugador: ";
    $aux=trim(fgets(STDIN));
    echo"\n";
    while(!esPalabra($aux)){
        // echo "Nombre invalido, vuelva a ingresar su nombre: ";
        echo "Nombre inválido. Solo se permiten letras. No se permiten números (123), símbolos (#, $, %, @) ni espacios.\n";
        echo "\n";
        echo "Por favor, ingrese su nombre nuevamente: ";
        $aux=trim(fgets(STDIN));
        echo"\n";
    }
    
    
    return strtolower($aux);
}

/**
 * Funcion que muestra un resumen de las estadisticas de un usuario sobre sus partidas
 * @param array $array
 * @param string $nombre
 */
function resumenJugador($array,$nombre){
    // variable interna int[] $intento
    // variable interna int $cantVictorias
    // variable interna int $canPuntaje
    // variable interna int $partida
    // variable interna float $cantPartidas
    // variable interna float $porcentaje
    $cantPartidas = 0;
    $cantPuntaje = 0;
    $cantVictorias = 0;
    $intento = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0];

    $i = 0;
    while ($i < count($array)) {
        if ($array[$i]["jugador"] == $nombre) {
            $cantPartidas++;

            if ($array[$i]["puntaje"] > 0) {
                $cantPuntaje += $array[$i]["puntaje"];
                $cantVictorias++;

                $intentoGanado = $array[$i]["intentos"];
                if ($intentoGanado >= 1 && $intentoGanado <= 6) {
                    $intento[$intentoGanado]++;
                }
            }
        }
        $i++;
    }

    if ($cantPartidas > 0) {
        $porcentajeVictorias = ($cantVictorias / $cantPartidas) * 100;
    } else {
        $porcentajeVictorias = 0;
    }

    // Crear el resumen en la variable $arrayResumen
    $arrayResumen = [
        "jugador" => $nombre,
        "partidas" => $cantPartidas,
        "puntajeTotal" => $cantPuntaje,
        "victorias" => $cantVictorias,
        "porcentajeVictorias" => round($porcentajeVictorias, 2),
        "adivinadas" => $intento
    ];

    return $arrayResumen; // Retorna el resumen
    
}

/**
 * funcion que revisa el menor indice en que gano.
 * @param array $array
 * @param string $nombre
 * @return int $indice
 */
function primerPartidaGanadora($array,$nombre){
    // variable interna int $indice


    $indice = -1; // Inicializa $indice con -1 para indicar que no se ha encontrado una partida ganada
    $i = 0; // Inicializa el contador $i en 0 para recorrer el array desde el primer elemento

    // Recorre el array mientras queden elementos y no se haya encontrado una partida ganada
    while ($i < count($array) && $indice == -1) {

        if ($array[$i]["jugador"] == $nombre && $array[$i]["puntaje"] > 0) { // Verifica si el jugador de la partida actual coincide con $nombre y si tiene puntaje mayor a 0
            $indice = $i; // Asigna el índice actual a $indice ya que se encontró la primera partida ganada
        }
        
        $i++; // Incrementa el contador para pasar al siguiente elemento del array
    }

    
    return $indice; // Devuelve el índice de la primera partida ganada o -1 si no se encontró ninguna
}

/**
 * funcion que permite al usuario ingresar a las distintas opciones del menu
 * @return int $opcion
 */
function seleccionarOpcion() {
    // variable interna int $opcion
    echo "\n";
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

    // Lee la opción del usuario
    $opcion = solicitarNumeroEntre(1, 8);

    return $opcion;
}

/**
 * funcion para agregar una palabra a la coleccion de palabras
 * @param array $array
 * @param string $palabra
 * @return array $array
 */
function agregarPalabra($array,$palabra){
    $confir=true;
    $aux=0;
    while($confir!=false){
        if ($aux < count($array)){
            if($array[$aux]==$palabra){
                echo"La palabra que ingreso ".$palabra." ya existe \n";
                $confir = false;
            }else{
                $aux+=1;
            }
        }else{
            $confir=false;
        }
    }
    $array[]=$palabra;
    return $array;
}

/**
 * funcion que muestra la partida guardada que solicite el usuario
 * @param int $numero
 * @param array $array
 */
function mostrarPartida($numero,$array){
    // Variable interna:    boolean $confirmar
    //                      int $indiceReal                 
    $numero--;
    if ($numero >= 0 && $numero < count($array)) {
        echo "\n";
        echo "*******************************************\n";
        echo "Partida WORDIX " . ($numero + 1) . ": palabra " .$array[$numero]["palabraWordix"] . "\n";
        echo "Jugador: " . $array[$numero]["jugador"] . "\n";
        echo "Puntaje: " . $array[$numero]["puntaje"] . " puntos\n";

        if ($array[$numero]["intentos"] > 0) {
            echo "Intento: Adivinó la palabra en " . $array[$numero]["intentos"] . " intentos\n";
            echo "*******************************************\n";
        } else {
            echo "Intento: No adivinó la palabra\n";
            echo "*******************************************\n";
        }
    } 
}

/**
 * obtiene ejemplos de partidas
 * @return array
 */
function cargarPartidas(){
    //Variable interna array $coleccionPardas
    $coleccionPardas[0] = ["palabraWordix" => "QUESO" , "jugador" => "majo", "intentos"=> 0, "puntaje" => 0];
    $coleccionPardas[1] = ["palabraWordix" => "CASAS" , "jugador" => "rudolf", "intentos"=> 3, "puntaje" => 16];
    $coleccionPardas[2] = ["palabraWordix" => "QUESO" , "jugador" => "pink", "intentos"=> 5, "puntaje" => 20];
    $coleccionPardas[3] = ["palabraWordix" => "PERRO" , "jugador" => "juan", "intentos"=> 2, "puntaje" => 17];
    $coleccionPardas[4] = ["palabraWordix" => "LETRA" , "jugador" => "majo", "intentos"=> 4, "puntaje" => 17];
    $coleccionPardas[5] = ["palabraWordix" => "PLATA" , "jugador" => "pink", "intentos"=> 1, "puntaje" => 14];
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
function cargarColeccionPalabras(){
    //Variable interna string[] $coleccionPalabras 
    $coleccionPalabras = [
        "MUJER", "AUTOR", "FUEGO", "SUMAR", "RASGO",
        "GATOS", "GOTAS", "HUEVO", "TINTO", "NAVES",
        "VERDE", "MELON", "YUYOS", "PIANO", "PISOS", 
        "VACAS", "MALLA", "MESAS", "CONTA", "COMPU" 
    ];

    return ($coleccionPalabras);
}

/**************************************/
/*********** PROGRAMA PRINCIPAL *******/
/**************************************/

//Declaración de variables:

// array $coleccionPartidas
// array $coleccionPalb
// array $arrayAux1
// array $arrayAux2
// int $opcion
// int $numero1
// int $numero2
// int $partidaGanadora
// int $indiceAleatorio
// string $palabra
// string $nombreJugador1
// string $nombreJugador2
// string $nombreJugador3
// string $nombreJugador4
// boolean $salir
// boolean $jugadorExiste1
// boolean $jugadorValido1
// boolean $jugadorExiste2
// boolean $jugadorValido2
// boolean $verdadero1
// boolean $todasAdivinadas1
// boolean $adivinada1
// booblean $yaAdivinada1
// booblean $yaAdivinada2

// $partida1
// $partida2
// $partida3
// $partida4

$coleccionPartidas=[]; $coleccionPalb=[]; $arrayAux1=[]; $arrayAux2=[];
$opcion; $numero1; $indiceAleatorio; $numero3; $partidaGanadora;
$palabra; $nombreJugador1; $nombreJugador2; $nombreJugador3; $nombreJugador4;
$salir=true; $jugadorExiste1; $jugadorValido1; $jugadorExiste2; $jugadorValido2; $verdadero1; $todasAdivinadas1; $adivinada1; $yaAdivinada1; $yaAdivinada2;
$partida1; $partida2; $partida3; $partida4;

$adivinada; $indiceAleatorio;

//Inicialización de variables:
$coleccionPartidas=cargarPartidas();
$coleccionPalb=cargarColeccionPalabras();

//Proceso:
do{
    
    $opcion=seleccionarOpcion();

    switch ($opcion){
        case 1:
            $nombreJugador1 = solicitarJugador();
            $numero1=palabraUsada($nombreJugador1,$coleccionPartidas,$coleccionPalb);
            if($numero1>-1){
                $arrayAux1 = jugarWordix($coleccionPalb[$numero1], strtolower($nombreJugador1));
                $coleccionPartidas[] = $arrayAux1;
            }
            break;
        case 2:
            $nombreJugador2=solicitarJugador();
            $indiceAleatorio=palabraAleatoria($nombreJugador2,$coleccionPartidas,$coleccionPalb);
            if($indiceAleatorio>-1){
                $arrayAux2=jugarWordix($coleccionPalb[$indiceAleatorio],$nombreJugador2);
                $coleccionPartidas[]=$arrayAux2;
            }
            break;
        case 3:
            echo "Ingrese el número de la partida que quiere ver (1 a " . count($coleccionPartidas) . "): ";
            $numero3 = solicitarNumeroEntre(1, count($coleccionPartidas));
            mostrarPartida($numero3, $coleccionPartidas);
            break;
        case 4:
            $nombreJugador3 = solicitarJugador();

            $partidaGanadora=primerPartidaGanadora($coleccionPartidas,$nombreJugador3);
            if($partidaGanadora!=-1){
                echo "*******************************************\n";
                echo"Partida Wordix ".($partidaGanadora+1).": Palabra ".$coleccionPartidas[$partidaGanadora]["palabraWordix"]." \n";
                echo"Jugador: ".$coleccionPartidas[$partidaGanadora]["jugador"]." \n";
                echo"Puntaje: ".$coleccionPartidas[$partidaGanadora]["puntaje"]." puntos \n";
                echo"Intento: Adivino la palabra en ".$coleccionPartidas[$partidaGanadora]["intentos"]." intentos \n";
                echo "*******************************************\n";
                echo" \n";
            } else {
                echo"El jugador aun no ha ganado una partida ó todavia no ha jugado a Wordix \n";
                echo" \n";
            }
            break;
        case 5:
            // Solicitar el nombre del jugador usando solicitarJugador
            $nombreJugador4 = solicitarJugador();

            // Obtener el resumen del jugador
            $resumen = resumenJugador($coleccionPartidas, $nombreJugador4);

            // Mostrar el resumen
            if ($resumen["partidas"] > 0) {
                echo "*************************\n";
                echo "Jugador: " . $resumen["jugador"] . "\n";
                echo "Partidas: " . $resumen["partidas"] . "\n";
                echo "Puntaje Total: " . $resumen["puntajeTotal"] . "\n";
                echo "Victorias: " . $resumen["victorias"] . "\n";
                echo "Porcentaje de Victorias: " . $resumen["porcentajeVictorias"] . "%\n";
                echo "Adivinadas:\n";

                
                for($i=1; $i<=6; $i++) {
                    echo"       Intento " . $i . ": " . $resumen["adivinadas"][$i] ."\n";
                }
                echo "*************************\n";
            } else {
                echo "El jugador " . $nombreJugador4  . " no tiene partidas registradas.\n";
            }
            break;
        case 6:
            ordenarPartidas($coleccionPartidas);
            break;
        case 7:
            $palabra=leerPalabra5Letras();
            $coleccionPalb=agregarPalabra($coleccionPalb,$palabra);
            echo"\n";
            break;
        case 8:
            echo"¡¡Gracias por jugar wordix!! \n";
            $salir=false;
            break;
    }

}while($salir!=false);