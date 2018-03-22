<?php
$conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=deathnote") or die( "Error al conectar: ".pg_last_error() );
$sql = "select conectarBD('ExamenII');";
$result = pg_query($sql) or die('Query failed: ' . pg_last_error());
$rows = pg_numrows($result);

$string="";
for($i=1;$i<=$rows; $i++){
    $line = pg_fetch_array($result, null, PGSQL_ASSOC);
    $string=$string.","."$line[conectarbdrecord] ";
}
echo json_encode($string);
?>