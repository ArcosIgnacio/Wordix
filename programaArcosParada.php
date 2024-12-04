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
 * funcion que ordena la coleccion de partidas por nombre y palabra en forma ascendentemente
 * @param array $array
 */
function ordenarPartidas($array) {
    uasort($array, function ($a, $b) {
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
    });

    // Imprimir el resultado ordenado
    print_r($array);
}

/**
 * La funcion solicita el nombre al ususario el nombre de un jugador y retorna el nombre en minusculas
 * @return string $nombre
 */
function solicitarJugador() {
    // variable interna string $aux;
    $aux=""; // esto no es necesario
    echo "\n";
    echo"Ingrese el nombre del jugador: ";
    $aux=trim(fgets(STDIN));
    echo"\n";
    if(!esPalabra($aux)){ //el if tampoco es necesario
        while(!esPalabra($aux)){
            // echo "Nombre invalido, vuelva a ingresar su nombre: ";
            echo "Nombre inválido. Solo se permiten letras. No se permiten números (123), símbolos (#, $, %, @) ni espacios.\n";
            echo "\n";
            echo "Por favor, ingrese su nombre nuevamente: ";
            $aux=trim(fgets(STDIN));
            echo"\n";
        }
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
    $intento=[1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0]; $cantVictorias=0; $cantPuntaje=0; $partida=0; $cantPartidas=0; $porcentaje=0; 

    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]["jugador"] == $nombre) {
            $cantPartidas++;

            if ($array[$i]["puntaje"] > 0) {
                $cantPuntaje += $array[$i]["puntaje"];
                $cantVictorias++;

                // aca puse el conteo de intentos
                $intentoGanado = $array[$i]["intentos"];
                if ($intentoGanado >= 1 && $intentoGanado <= 6) {
                    $intento[$intentoGanado]++;
                }
            }
        }
    }

    echo "*************************\n";
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
    echo "*************************\n";
    echo"\n";
    
}

/**
 * funcion que revisa el menor indice en que gano o si perdio
 * @param array $array
 * @param string $nombre
 * @return int $indice
 */
function primerPartidaGanadora($array,$nombre){
    // variable interna int $indice
    // variable interna int $menor
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
    // variable interna int $opcion
    do {
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
        $opcion = trim(fgets(STDIN));

        if (is_numeric($opcion)) { //determina si un string es un número. puede ser float como entero.
            $opcion  = $opcion * 1; //con esta operación convierto el string en número.
        }

        // Valida que la opción sea un número entre 1 y 8
        if (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion < 1 || $opcion > 8) {
            echo "La opción es inválida. Por favor, ingrese un número entre 1 y 8.\n";
            echo"\n";
        } 

    } while (!(is_numeric($opcion) && $opcion == (int)($opcion)) || $opcion <1 || $opcion > 8);

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
function mostrarPartida($numero,$array){
    // Variable interna:    boolean $confirmar
    //                      int $indiceReal                 
    $confirmar = false;

    // count(array) cuenta la cantidad de elementos totales del arreglo
    //ajusto la validacion para permitir numeros entre 1 y count(array) (que corresponde al rango 0 a 9 del array)
    while ($confirmar != true || !(is_numeric($numero) && ($numero == (int)$numero))) {
    // Verifico si el numero ingresado esta entre 1 y count(array)
        if ($numero >= 1 && $numero <= count($array)) {
            // Resto 1 al numero ingresado para usar el indice correcto del array (0- count(array))
            $indiceReal = $numero - 1;

            // Verifico si el indice es valido en el array
            if ($indiceReal >= 0 && $indiceReal < count($array)) {
                // Si el numero es valido, muestro la información de la partida
                echo "\n";
                echo "Número válido \n";
                echo "\n";
                echo "*************************\n";
                echo "Partida Wordix: " . ($indiceReal + 1) . "\n";
                echo "Palabra: " . $array[$indiceReal]["palabraWordix"] . "\n";
                echo "Jugador: " . $array[$indiceReal]["jugador"] . "\n";
                echo "Intentos restantes: " . $array[$indiceReal]["intentos"] . "\n";
                echo "Puntaje: " . $array[$indiceReal]["puntaje"] . "\n";
                echo "*************************\n";
                $confirmar = true;
            } 
        } else {
        // Si el numero no esta entre 1 y count(array)
        echo "\n";
        echo "Número inválido. El número debe estar entre 1 y " . count($array) .": \n";
        echo "Vuelva a ingresar el número: ";
        $numero = trim(fgets(STDIN)); // Pedo el numero nuevamente
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
// array $partida1 Subarray con informacion de la partida, contiene: "palabraWordix": string; int: "puntaje"
// array $partida2 Subarray con informacion de la partida, contiene: "palabraWordix": string; int: "puntaje"
// array $partida3 Subarray con informacion de la partida, contiene: "jugador": string
// array $partida4 Subarray con informacion de la partida, contiene: "jugador": string
// int $opcion
// int $numero1
// int $numero2
// int $partidaGanadora
// int $indiceAleatorio
// string $palabra1
// string $palabra2
// string $palabra3
// string $nombreJugador1
// string $nombreJugador2
// string $nombreJugador3
// string $nombreJugador4
// string $palabraSeleccionada
// string $palabraAleatoria
// boolean $salir
// boolean $jugadorExiste1
// boolean $jugadorValido1
// boolean $jugadorExiste2
// boolean $jugadorValido2
// boolean $verdadero1
// boolean $todasAdivinadas1
// boolean $todasAdivinadas2
// boolean $adivinada1
// boolean $adivinada2
// booblean $yaAdivinada1
// booblean $yaAdivinada2



$coleccionPartidas=[]; $coleccionPalb=[]; $arrayAux1=[]; $arrayAux2=[]; $partida1; $partida2; $partida3; $partida4;
$opcion; $numero1; $numero2; $partidaGanadora; $indiceAleatorio;
$palabra1; $palabra2; $palabra3; $nombreJugador1; $nombreJugador2; $nombreJugador3; $nombreJugador4; $palabraSeleccionada; $palabraAleatoria;
$salir=true; $jugadorExiste1; $jugadorValido1; $jugadorExiste2; $jugadorValido2; $verdadero1; $todasAdivinadas1; $todasAdivinadas2; $adivinada1; $adivinada2; $yaAdivinada1; $yaAdivinada2;


//Inicialización de variables:
$coleccionPartidas=cargarPartidas();
$coleccionPalb=cargarColeccionPalabras();

//Proceso:
do{
    
    $opcion=seleccionarOpcion();

    switch ($opcion){
        case 1:
            // Verifico si todas las palabras ya fueron adivinadas
            $todasAdivinadas1 = true;

            foreach ($coleccionPalb as $palabra1) {
                $adivinada1 = false;
                foreach ($coleccionPartidas as $partida1) {
                    if ($partida1["palabraWordix"] == $palabra1 && $partida1["puntaje"] > 0) {
                        $adivinada1 = true;
                    }
                }
                if (!$adivinada1) {
                    $todasAdivinadas1 = false;
                }
            }
            
            if ($todasAdivinadas1) {
                echo "\n";
                echo "¡Felicidades! Ya adivinaste todas las palabras disponibles. \n";
            } else {
                $nombreJugador1 = solicitarJugador();
                echo "Ingrese un número del 1 al " . count($coleccionPalb) . " para acceder a una palabra: ";
                $numero1 = trim(fgets(STDIN));
                $verdadero1 = false;

                while (!$verdadero1) {
                    if (is_numeric($numero1) && ($numero1 == (int)$numero1) && $numero1 >= 1 && $numero1 <= count($coleccionPalb)) {
                        $numero1 = $numero1 - 1;
                        $palabraSeleccionada = $coleccionPalb[$numero1];
                        $yaAdivinada1 = false;

                        // Verifico si la palabra fue adivinada (ganada)
                        foreach ($coleccionPartidas as $partida1) {
                            if ($partida1["palabraWordix"] == $palabraSeleccionada && $partida1["puntaje"] > 0) {
                                $yaAdivinada1 = true;
                            }
                        }

                        if ($yaAdivinada1) {
                            echo "Ingrese otro número, ya que esa palabra ya fue adivinada correctamente. \n";
                            $numero1 = trim(fgets(STDIN));
                        } else {
                            echo "Número válido. \n\n";
                            $verdadero1 = true;
                        }
                    } else {
                        echo "Número inválido. Ingrese otro número dentro del rango: ";
                        $numero1 = trim(fgets(STDIN));
                    }
                }

                // Registrar la nueva partida
                $arrayAux1 = jugarWordix($coleccionPalb[$numero1], strtolower($nombreJugador1));
                $coleccionPartidas[] = $arrayAux1;
            }
            break;
        case 2:
            // Verificar si todas las palabras ya fueron adivinadas
            $todasAdivinadas2 = true;

            foreach ($coleccionPalb as $palabra2) {
                $adivinada2 = false;

                foreach ($coleccionPartidas as $partida2) {
                    if ($partida2["palabraWordix"] == $palabra2 && $partida2["puntaje"] > 0) {
                        $adivinada2 = true;
                    }
                }

                if (!$adivinada2) {
                    $todasAdivinadas2 = false;
                }
            }

            if ($todasAdivinadas2) {
                echo "\n¡Felicidades! Ya adivinaste todas las palabras disponibles. \n";
            } else {
                $nombreJugador2 = solicitarJugador();
                echo "\n";

                // Selección de palabra aleatoria que no haya sido adivinada
                do {
                    $palabraAleatoria = $coleccionPalb[array_rand($coleccionPalb)];
                    $yaAdivinada2 = false;

                    foreach ($coleccionPartidas as $partida2) {
                        if ($partida2["palabraWordix"] == $palabraAleatoria && $partida2["puntaje"] > 0) {
                            $yaAdivinada2 = true;
                            break; // Ya encontramos que la palabra fue adivinada, no hace falta seguir verificando.
                        }
                    }
                } while ($yaAdivinada2); // Repetir mientras la palabra aleatoria ya esté adivinada.

                echo "\n";
                // Jugar con la palabra válida seleccionada
                $arrayAux2 = jugarWordix($palabraAleatoria, strtolower($nombreJugador2));
                $coleccionPartidas[] = $arrayAux2;
            }
            break;
        case 3:
            $numero2 = null;

            echo "Ingrese el número de la partida que quiere ver (1 a " . count($coleccionPartidas) . "): ";
            $numero2 = trim(fgets(STDIN));

            // Llamar a la función mostrarPartida, que se encarga de la validación
            mostrarPartida($numero2, $coleccionPartidas);
            break;
        case 4:
            $jugadorExiste1 = false;
            $jugadorValido1=false;
            while (!$jugadorValido1) {
                $nombreJugador3=solicitarJugador();
                if (esPalabra($nombreJugador3)) {
                    $jugadorExiste1 = false;
                    foreach($coleccionPartidas as $partida3) {
                        if (strtolower($partida3["jugador"]) == $nombreJugador3) {
                            $jugadorExiste1 = true;
                        }
                    }
                }
                if ($jugadorExiste1 == true) {
                    $jugadorValido1 = true;
                } else {
                    echo "el jugador no existe.\n";
                }
            }
            $partidaGanadora=primerPartidaGanadora($coleccionPartidas,$nombreJugador3);
            if($partidaGanadora!=-1){
                echo "*******************************************\n";
                echo"Partida Wordix ".($partidaGanadora+1).": Palabra ".$coleccionPartidas[$partidaGanadora]["palabraWordix"]." \n";
                echo"Jugador: ".$coleccionPartidas[$partidaGanadora]["jugador"]." \n";
                echo"Puntaje: ".$coleccionPartidas[$partidaGanadora]["puntaje"]." puntos \n";
                echo"Intento: Adivino la palabra en ".$coleccionPartidas[$partidaGanadora]["intentos"]." intentos \n";
                echo "*******************************************\n";
                echo" \n";
            }elseif($partidaGanadora==-1){
                echo"El jugador no adivino la palabra \n";
                echo" \n";
            }
            break;
        case 5:
            $jugadorExiste2 = false;
            $jugadorValido2 = false;
            while (!$jugadorValido2) {
                $nombreJugador4=solicitarJugador();
                if (esPalabra($nombreJugador4)) {
                    $jugadorExiste2 = false;
                    foreach($coleccionPartidas as $partida4) {
                        if (strtolower($partida4["jugador"]) == $nombreJugador4) {
                            $jugadorExiste2 = true;
                        }
                    }
                }
                if ($jugadorExiste2 == true) {
                    $jugadorValido2 = true;
                } else {
                    echo "el jugador no existe.\n";
                }
            }
            echo"\n";
            resumenJugador($coleccionPartidas,$nombreJugador4);
            break;
        case 6:
            ordenarPartidas($coleccionPartidas);
            break;
        case 7:
            $palabra3=leerPalabra5Letras();
            $coleccionPalb=agregarPalabra($coleccionPalb,$palabra3);
            echo"\n";
            break;
        case 8:
            echo"¡¡Gracias por jugar wordix!! \n";
            $salir=false;
            break;
    }

}while($salir!=false);