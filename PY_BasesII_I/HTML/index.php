<?php

if ($_GET['func']=='conectar_PostgreSQL()')
{
    conectar_PostgreSQL();
}


function conectar_PostgreSQL()
{
    $user = "postgres";
    $password = "deathnote";
    $dbname = "ProyectoII";
    $port = "5432";
    $host = "localhost";

    $cadenaConexion = "host=$host port=$port dbname=$dbname user=$user password=$password";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}