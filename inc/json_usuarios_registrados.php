<?php
header('Content-Type: application/json');
require 'database.php';

$sqlQuery = "SELECT  Months.m AS mes, COUNT(usuario.registrado_el) AS num_registros FROM 
(
    SELECT 1 as m 
    UNION SELECT 2 as m 
    UNION SELECT 3 as m 
    UNION SELECT 4 as m 
    UNION SELECT 5 as m 
    UNION SELECT 6 as m 
    UNION SELECT 7 as m 
    UNION SELECT 8 as m 
    UNION SELECT 9 as m 
    UNION SELECT 10 as m 
    UNION SELECT 11 as m 
    UNION SELECT 12 as m
) as Months
LEFT JOIN usuario on Months.m = MONTH(usuario.registrado_el)
AND YEAR(usuario.registrado_el) = YEAR(CURDATE())
GROUP BY Months.m";

// ultimos 12 meses WHERE registrado_el > DATE_SUB(now(), INTERVAL 12 MONTH)

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

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

echo json_encode($data);
?>