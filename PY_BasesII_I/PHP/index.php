<?php
//verifica a que funcion desea acceder
if ($_GET['func']=='get_DB_SQL()')
{
    get_DB_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='get_DB_postgres()')
{
    get_DB_postgres($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='select_Postgres()')
{
    select_Postgres($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='select_SQLServer()')
{
    conectar_SQLServer($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

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

//funcion para obtener las bases de datos del sistema
function get_DB_SQL($usuario,$contraseña,$ip,$puerto,$bd){
    /*
    $ip="localhost";
    $puerto="1433";
    $usuario="sa";
    $contraseña="deathnote";
    */
    $serverName = "$ip\sqlexpress,$puerto"; //(por defecto es 1433)
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "SELECT name FROM sys.databases;";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        echo $row['name'].",";
    }

    sqlsrv_free_stmt( $stmt);
}

//se hace una nueva conexion con la nueva base de datos
function select_SQLServer($usuario,$contraseña,$ip,$puerto,$bd)
{
    $serverName = "$ip\sqlexpress,$puerto"; //(por defecto es 1433)
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn ) {
        echo "Exito de conexion con SQL Server";
        return $conn;
    }else{
        echo "Error de conexion con SQL Server";
        die( print_r( sqlsrv_errors(), true));
    }
}

//************************************************************************************nuevas
//se hace una nueva conexion con la nueva base de datos
function select_Postgres($usuario,$contraseña,$ip,$puerto,$bd)
{
    $cadenaConexion = "host=$ip port=$puerto dbname=$bd user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}

function get_DB_postgres($usuario,$contraseña,$ip,$puerto,$bd){
    $cadenaConexion = "host=$ip port=$puerto dbname=$bd user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );

    $sql = "SELECT datname FROM pg_database WHERE datistemplate = false;";
    $result = pg_query($sql) or die('Query failed: ' . pg_last_error());
    $rows = pg_numrows($result);

    $string="";
    for($i=1;$i<=$rows; $i++){
        $line = pg_fetch_array($result, null, PGSQL_ASSOC);
        $string=$string.","."$line[datname]".",";
    }
    echo json_encode($string);

}
/*
SELECT datname FROM pg_database
WHERE datistemplate = false;
*/
?>





