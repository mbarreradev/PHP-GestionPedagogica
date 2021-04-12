<?php
header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';

$year = date("Y");

// Guías
$sqlQuery = "SELECT  Months.m AS mes, COUNT(ordencompra.fecha_compra) AS total_guias FROM 
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
LEFT JOIN ordencompra on Months.m = MONTH(ordencompra.fecha_compra)
AND YEAR(ordencompra.fecha_compra) = YEAR(CURDATE())
INNER JOIN 
	archivo
	ON
	ordencompra.archivo_id=archivo.archivo_id
    WHERE 
     archivo.tipo = 1
GROUP BY Months.m";

// ultimos 12 meses WHERE ordencompra.fecha_compra > DATE_SUB(now(), INTERVAL 12 MONTH) AND archivo.tipo = 1

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);

?>