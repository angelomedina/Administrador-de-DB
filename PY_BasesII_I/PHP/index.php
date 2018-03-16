<?php

if ($_GET['func']=='conectar_PostgreSQL()')
{
    conectar_PostgreSQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto']);
}


function conectar_PostgreSQL($usuario,$contraseña,$ip,$puerto)
{
    $user = $usuario;
    $password = $contraseña;
    $dbname = "ProyectoII";
    $port = $puerto;
    $host = $ip;

    $cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}
/*
//conectar_PostgreSQL($phots,$pport,$puser,$ppassword)
function conectar_PostgreSQL()
{

    $user = $puser;
    $password = $ppassword;
    $dbname = "ProyectoII";
    $port = 5232;//$pport;
    $host = $phots;


    $conexion = pg_connect("host=localhost port=5432 dbname=ProyectoII user=postgres password=deathnote") or die( "Error al conectar: ".pg_last_error() );

    //$cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conexion = pg_connect($conexion) or die( "Error al conectar con Postgres: ".pg_last_error() );
    return $conexion;
}*/

?>


