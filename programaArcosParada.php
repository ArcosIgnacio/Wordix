<?php
include_once("wordix.php");


/**************************************/
/***** DATOS DE LOS INTEGRANTES *******/
/**************************************/

/* Apellido = Arcos , Nombre = Ignacio . Legajo = Fai-5472 . Carrera = TUDW . Mail = mateo.parada@est.fi.uncoma.edu.ar . Usuario Github = mateoparada*/
/* Apellido = Parada , Nombre = Mateo . Legajo = Fai-5359 . Carrera = TUDW . Mail = ignacio.arcos@est.fi.uncoma.edu.ar . Usuario Github = ArcosIgnacio*/


/**************************************/
/***** DEFINICION DE FUNCIONES ********/
/**************************************/


/**
 * funcion que ordena la coleccion de partidas por nombre y palabra en orden descendente
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
    $aux="";
    echo"Ingrese el nombre del jugador: ";
    $aux=trim(fgets(STDIN));
    echo"\n";
    if(!esPalabra($aux)){
        while(!esPalabra($aux)){
            echo"Nombre invalido, vuelva a ingresar su nombre: ";
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
    //Variable interna boolean $confirmar
    $confirmar=false;
    
    while($confirmar!=true || !(is_numeric($numero) && ($numero == (int)$numero))){
        for($i=0;$i<count($array);$i++){
            if($numero==$i){
                if(($numero == (int)$numero)){
                    echo "Numero valido \n";
                    echo "\n";

                    echo "Partida Wordix: ".($i+1)."\n";
                    echo "Palabra: ".$array[$i]["palabraWordix"]."\n";
                    echo "Jugador: ".$array[$i]["jugador"]."\n";
                    echo "Intentos restantes: ".$array[$i]["intentos"]."\n";
                    echo "Puntaje: ".$array[$i]["puntaje"]."\n";
                    echo "\n";
                    $confirmar=true;
                }
            }
        }
        if($confirmar!=true){
            echo "Partida invalida \n";
            echo "Vuelva a ingresar el numero \n";
            $numero=trim(fgets(STDIN));
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
// int $numero
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
$coleccionPartidas=[]; $coleccionPalb=[]; $arrayAux1=[]; $arrayAux2=[]; 
$opcion; $numero1; $partidaGanadora; $indiceAleatorio;
$palabra; $nombreJugador1; $nombreJugador2; $nombreJugador3; $nombreJugador4;  
$salir=true; $jugadorExiste1; $jugadorValido1; $jugadorExiste2; $jugadorValido2; $verdadero1;

//Inicialización de variables:
$coleccionPartidas=cargarPartidas();
$coleccionPalb=cargarColeccionPalabras();

//Proceso:
do{
    
    $opcion=seleccionarOpcion();

    switch ($opcion){
        case 1:
            $nombreJugador1=solicitarJugador();
            echo"Ingrese un numero para acceder a una palabra: ";
            $numero1=trim(fgets(STDIN));
            $verdadero1=false; 
            while($verdadero1!=true){
                if(is_numeric($numero1) && ($numero1 == (int)$numero1)){
                    for($i=0;$i<count($coleccionPalb);$i++){
                        if($numero1==$i){
                            echo"Numero valido \n";
                            echo"\n";
                            $verdadero1=true;
                            for($j=0;$j<count($coleccionPartidas);$j++){
                                if($coleccionPalb[$i]==$coleccionPartidas[$j]["palabraWordix"]){
                                echo"Ingrese otro numero, ya que ese indice corresponde a una palabra ya jugada \n";
                                $numero1=trim(fgets(STDIN));
                                $verdadero1=false;
                                }
                            }
                        }
                    }
                    if($verdadero1==false){
                        echo"Numero invalido, ingrese otro \n";
                        $numero1=trim(fgets(STDIN));
                        echo"\n";
                    }
                }else{
                    echo"Numero invalido, ingrese otro \n";
                    $numero1=trim(fgets(STDIN));
                    echo"\n";
                 }
            }
            $arrayAux1 = jugarWordix($coleccionPalb[$numero1], strtolower($nombreJugador1));
            $coleccionPartidas[]=$arrayAux1;
            break;
        case 2:
            $nombreJugador2=solicitarJugador();

            echo"\n";
            $indiceAleatorio=$coleccionPalb[array_rand($coleccionPalb)];
            for($i=0;$i<count($coleccionPartidas);$i++){
                if($indiceAleatorio==$coleccionPartidas[$i]["palabraWordix"]){
                    echo"La palabra aleatoria ya fue jugada, se volvera a sortear otra palabra \n";
                    $indiceAleatorio=$coleccionPalb[array_rand($coleccionPalb)];
                    echo"\n";
                }
            }

            $arrayAux2 = jugarWordix($indiceAleatorio, strtolower($nombreJugador2));
            $coleccionPartidas[]=$arrayAux2;
            break;
        case 3:
            $numero=null;
            echo"Ingrese que partida quiere ver: ";
            $numero=trim(fgets(STDIN));
            mostrarPartida($numero,$coleccionPartidas);
            break;
        case 4:
            $jugadorExiste1 = false;
            $jugadorValido1=false;
            while (!$jugadorValido1) {
                $nombreJugador3=solicitarJugador();
                if (esPalabra($nombreJugador3)) {
                    $jugadorExiste1 = false;
                    foreach($coleccionPartidas as $partida) {
                        if (strtolower($partida["jugador"]) == $nombreJugador3) {
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
            $jugadorExiste2 = false;
            $jugadorValido2 = false;
            while (!$jugadorValido2) {
                $nombreJugador4=solicitarJugador();
                if (esPalabra($nombreJugador4)) {
                    $jugadorExiste2 = false;
                    foreach($coleccionPartidas as $partida) {
                        if (strtolower($partida["jugador"]) == $nombreJugador4) {
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