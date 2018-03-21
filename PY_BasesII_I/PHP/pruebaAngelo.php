<?php

$ip="localhost";
$puerto="1433";
$usuario="sa";
$contraseña="deathnote";




$serverName = "$ip\sqlexpress,$puerto"; //(por defecto es 1433)
$connectionInfo = array( "Database"=>"master", "UID"=>$usuario, "PWD"=>$contraseña);
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$sql = "SELECT name FROM sys.databases;";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$string="";
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    echo $row['name']."<br />";
}

sqlsrv_free_stmt( $stmt);
?>