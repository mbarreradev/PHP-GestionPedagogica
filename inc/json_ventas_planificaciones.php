<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

$year = date("Y");

// Planificaciones
$sqlQuery = "SELECT COUNT(ordencompra.ordencompra_id) AS num_registros_planificaciones, archivo.tipo AS tipo, MONTH(ordencompra.fecha_compra) AS mes, YEAR(ordencompra.fecha_compra) AS agno 
  FROM 
  	ordencompra
  INNER JOIN 
	archivo
	ON
	ordencompra.archivo_id=archivo.archivo_id
  WHERE 
    YEAR(ordencompra.fecha_compra) = YEAR(CURDATE()) AND archivo.tipo = 0
GROUP BY 
	MONTH(ordencompra.fecha_compra), YEAR(ordencompra.fecha_compra)
ORDER BY 
	mes, agno";

// ultimos 12 meses WHERE ordencompra.fecha_compra > DATE_SUB(now(), INTERVAL 12 MONTH) AND archivo.tipo = 1

$result1 = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result1 as $row) {
	$data[] = $row;
}

for ($i = 1; $i <= 12; $i++) {
    // Comprobamos si existen los meses
    if (in_array($i, array_column($data, 'mes'))){
        //echo "found it";
    }
    else
    {
        // Si no existe lo agregamos al array
        $value = array(array("num_registros_planificaciones"=>"0", "tipo"=>"0", "mes"=> "$i", "agno"=> "$year"));
        array_splice($data, 0, 0, $value); // posicion, 0, valor a agregar
    }
}

// Ordenamos la lista
usort($data, function($a, $b) {
    return $a['mes'] <=> $b['mes'];
});

foreach($data as &$a){
    if($a['mes'] == 1){
        $a['mes'] = 'Enero';
    }
    elseif($a['mes'] == 2){
        $a['mes'] = 'Febrero';
    }
    elseif($a['mes'] == 3){
        $a['mes'] = 'Marzo';
    }
    elseif($a['mes'] == 4){
        $a['mes'] = 'Abril';
    }
    elseif($a['mes'] == 5){
        $a['mes'] = 'Mayo';
    }
    elseif($a['mes'] == 6){
        $a['mes'] = 'Junio';
    }
    elseif($a['mes'] == 7){
        $a['mes'] = 'Julio';
    }
    elseif($a['mes'] == 8){
        $a['mes'] = 'Agosto';
    }
    elseif($a['mes'] == 9){
        $a['mes'] = 'Septiembre';
    }
    elseif($a['mes'] == 10){
        $a['mes'] = 'Octubre';
    }
    elseif($a['mes'] == 11){
        $a['mes'] = 'Noviembre';
    }
    elseif($a['mes'] == 12){
        $a['mes'] = 'Diciembre';
    }
}

mysqli_close($conn);

echo json_encode($data);

?>