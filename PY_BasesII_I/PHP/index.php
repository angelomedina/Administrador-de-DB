<?php

if ($_GET['func']=='conectar_PostgreSQL()')
{
    conectar_PostgreSQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto']);
}


function conectar_PostgreSQL($usuario,$contraseña,$ip,$puerto)
{
    $user = $usuario;
    $password = $contraseña;
    $dbname = "postgres";//"ProyectoII";
    $port = $puerto;
    $host = $ip;

    $cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}


?>


