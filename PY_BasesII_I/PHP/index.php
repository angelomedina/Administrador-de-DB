<?php
//verifica a que funcion desea acceder
if ($_GET['func']=='conectar_SQLServer()')
{
    conectar_SQLServer($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto']);
}

if ($_GET['func']=='conectar_PostgreSQL()')
{
    conectar_PostgreSQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto']);
}

//funcion para oonectar con postgres
function conectar_PostgreSQL($usuario,$contraseña,$ip,$puerto){
    $dbname = "postgres";
    $cadenaConexion = "host=$ip port=$puerto dbname=$dbname user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}

//funcion para oonectar con sql
function conectar_SQLServer($usuario,$contraseña,$ip,$puerto)
{
    $serverName = "$ip\sqlexpress,$puerto"; //(por defecto es 1433)
    $connectionInfo = array( "Database"=>"master", "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        echo "Exito de conexion con SQL Server";
        return $conn;
    }else{
        echo "Error de conexion con SQL Server";
        die( print_r( sqlsrv_errors(), true));
    }
}
?>


