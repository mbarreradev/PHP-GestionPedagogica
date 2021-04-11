<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

  $sqlQuery = "SELECT COUNT(usuario_id) AS num_registros,
  MONTH(registrado_el) AS mes,
  YEAR(registrado_el) AS agno FROM usuario
  WHERE registrado_el > DATE_SUB(now(), INTERVAL 12 MONTH)
GROUP BY MONTH(registrado_el), YEAR(registrado_el)
ORDER BY mes, agno";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

// Reemplazamos los numeros de meses a nombres de meses

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