<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

// Planificaciones
$sqlQuery = "SELECT COUNT(ordencompra.ordencompra_id) AS num_registros_planificaciones, archivo.tipo AS tipo, MONTH(ordencompra.fecha_compra) AS mes, YEAR(ordencompra.fecha_compra) AS agno 
  FROM 
  	ordencompra
  INNER JOIN 
	archivo
	ON
	ordencompra.archivo_id=archivo.archivo_id
  WHERE 
	ordencompra.fecha_compra > DATE_SUB(now(), INTERVAL 12 MONTH) AND archivo.tipo = 0
GROUP BY 
	MONTH(ordencompra.fecha_compra), YEAR(ordencompra.fecha_compra)
ORDER BY 
	mes, agno";

$result1 = mysqli_query($conn,$sqlQuery);

$data1 = array();
foreach ($result1 as $row) {
	$data1[] = $row;
}

// Reemplazamos los numeros de meses a nombres de meses

foreach($data1 as &$a){
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

// Guías
$sqlQuery = "SELECT COUNT(ordencompra.ordencompra_id) AS num_registros_guias, archivo.tipo AS tipo, MONTH(ordencompra.fecha_compra) AS mes, YEAR(ordencompra.fecha_compra) AS agno 
  FROM 
  	ordencompra
  INNER JOIN 
	archivo
	ON
	ordencompra.archivo_id=archivo.archivo_id
  WHERE 
	ordencompra.fecha_compra > DATE_SUB(now(), INTERVAL 12 MONTH) AND archivo.tipo = 1
GROUP BY 
	MONTH(ordencompra.fecha_compra), YEAR(ordencompra.fecha_compra)
ORDER BY 
	mes, agno";

$result2 = mysqli_query($conn,$sqlQuery);

// Agregamos las guías a la lista de las planificaciones
foreach ($result2 as $row) {
	$data1[] = $row;
}

foreach($data1 as &$a){
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

echo json_encode($data1);

?>