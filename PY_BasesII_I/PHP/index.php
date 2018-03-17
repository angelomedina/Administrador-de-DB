<?php
if ($_GET['func']=='conectar_SQLServer()')
{
    conectar_SQLServer();
}

if ($_GET['func']=='conectar_PostgreSQL()')
{
    conectar_PostgreSQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto']);
}



function conectar_PostgreSQL($usuario,$contraseña,$ip,$puerto)
{

    $dbname = "postgres";//"ProyectoII";

    $cadenaConexion = "host=$ip port=$puerto dbname=$dbname user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}



function conectar_SQLServer()
{

    $serverName = "ANGELO\sqlexpress"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"Banco", "UID"=>"sa", "PWD"=>"deathnote");
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        echo "Conexión establecida.<br />";
    }else{
        echo "Conexión no se pudo establecer.<br />";
        die( print_r( sqlsrv_errors(), true));
    }
}
?>


