<?php
$serverName = "ANGELO"; //serverName\instanceName
$connectionInfo = array( "Database"=>"Banco", "UID"=>"sa", "PWD"=>"deathnote");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    echo "Conexión establecida.<br />";
}else{
    echo "Conexión no se pudo establecer.<br />";
    die( print_r( sqlsrv_errors(), true));
}
?>