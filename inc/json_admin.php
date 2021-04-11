<?php
header('Content-Type: application/json');

require 'database.php';

$sqlQuery = "SELECT ordencompra_id, estado_orden FROM ordencompra ORDER BY ordencompra_id";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>