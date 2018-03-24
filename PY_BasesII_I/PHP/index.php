<?php
//seleccion de funciones
if ($_GET['func']=='ModifyFileGroup_SQL')
{
    ModifyFileGroup_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd'],$_GET['nameFile'],$_GET['sizeFile']);
}

if ($_GET['func']=='add_procedureModifyGroupFile_SQL')
{
    add_procedureModifyGroupFile_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='CreateFileGroup_SQL')
{
    CreateFileGroup_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd'],$_GET['nameFile']);
}

if ($_GET['func']=='add_procedureCreateGroupFile_SQL')
{
    add_procedureCreateGroupFile_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='CreateFile_SQL')
{
    CreateFile_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd'],$_GET['nameFile'],$_GET['pathFile'],$_GET['sizeFile']);
}

if ($_GET['func']=='add_procedureCreateFile_SQL')
{
    add_procedureCreateFile_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='add_grafico_DB_SQL')
{
    add_grafico_DB_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='add_procedure_SQL')
{
    add_procedure_SQL($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='add_grafico_DB_postgres()')
{
    add_grafico_DB_postgres($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

if ($_GET['func']=='add_procedure_DB_postgres()')
{
    add_procedure_DB_postgres($_GET['usuario'],$_GET['contraseña'],$_GET['ip'],$_GET['puerto'],$_GET['bd']);
}

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

//se hace una nueva conexion con la nueva base de datos
function select_Postgres($usuario,$contraseña,$ip,$puerto,$bd)
{
    $cadenaConexion = "host=$ip port=$puerto dbname=$bd user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    return $conexion;
}

//obtiene las bases de datos de POstgres
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

//añade procedimeinto: "conectarBD" a cada base de datos
function add_procedure_DB_postgres($usuario,$contraseña,$ip,$puerto,$bd){
    $cadenaConexion = "host=$ip port=$puerto dbname=$bd user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );

    $sql = "CREATE OR REPLACE function conectarBD(dbname varchar) returns record as $$
            declare
                v_record record;
            begin
                SELECT * INTO v_record from (SELECT 	
                --pg_database_size: obtiene el tamaño maximo de la BD dada por parametro					
                pg_database_size( dbname ))
                as we;
                RETURN v_record;
            end;
            $$ language plpgsql;";
    $result = pg_query($sql) or die('Error al agregar el procedimiento almacenado: ' . pg_last_error());


}

//obtiene el proced de "conectarBD"
function add_grafico_DB_postgres($usuario,$contraseña,$ip,$puerto,$bd){
    $cadenaConexion = "host=$ip port=$puerto dbname=$bd user=$usuario password=$contraseña";
    $conexion = pg_connect($cadenaConexion) or die( "Error al conectar: ".pg_last_error() );
    $sql = "select conectarBD('$bd');";
    $result = pg_query($sql) or die('Error al agregar el procedimiento almacenado: ' . pg_last_error());
    $row=pg_fetch_row($result);
    echo json_encode($row);
}

//añade procedimeinto: "conexionBD" a cada base de datos
function add_procedure_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    drop_procedureconexionBD_SQL($usuario,$contraseña,$ip,$puerto,$bd);

    $sql = "create procedure conexionBD
            as
            begin
                select [name],
                    --Tamaño actual en memoria
                    (cast(fileproperty(name, 'SpaceUsed') AS int)/128.0) AS 'Tamaño en MB', 
                    --Factor de crecimeinto
                    (growth*8)/1024 'Factor crecimiento',
                    --Tamaño maximo a almacenar
                    [size]/128 AS 'Tamaño maximo MB', 
                    --Porcentaje de memoria utilizado
                    (cast(fileproperty(name, 'SpaceUsed') as int)/128.0 / ([size]/128)) * 100 as 'Porcentaje utilizado'
                from sysfiles 
            end;";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//elimina procedimeinto: "conexionBD" a cada base de datos
function drop_procedureconexionBD_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "IF EXISTS(SELECT 1 FROM sys.procedures WHERE Name = 'conexionBD')
  drop Procedure conexionBD";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//ejecuta el proced "conexionBD"
function add_grafico_DB_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "exec conexionBD";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }

    while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
        echo $row['name'].",".$row['Tamaño en MB'].",".$row['Factor crecimiento'].",".$row['Tamaño maximo MB'].",".$row['Porcentaje utilizado'].",";

    }

}

//añade procedimeinto: "fileCreate" a cada base de datos
function add_procedureCreateFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    drop_procedureCreateFile_SQL($usuario,$contraseña,$ip,$puerto,$bd);

    $sql = "create procedure fileCreate @DatabaseName varchar(30),@FileGroupName varchar(30),@PathofFiles varchar (2000),@MaxSizeMB int----
            as
            begin
                declare @Query varchar(2000);
                        set @Query='alter database ' + @DatabaseName+
                        ' add file ( name =''' + @FileGroupName +'''' + 
                        ', filename = ''' + @PathofFiles + '\' + @FileGroupName +'.ndf'+ ''''  +
                        ', size = ' + CONVERT(VARCHAR(10),@MaxSizeMB) + 'MB' +
                        ' ) ' ;
                    exec (@Query)
            end";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//elimina procedimeinto: "fileCreate" a cada base de datos
function drop_procedureCreateFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "IF EXISTS(SELECT 1 FROM sys.procedures WHERE Name = 'fileCreate ')
  drop Procedure fileCreate";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//ejecuta el proced "fileCreate"
function CreateFile_SQL($usuario,$contraseña,$ip,$puerto,$bd,$nameFile,$pathFile,$sizeFile){
    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $sql = "exec fileCreate @DatabaseName='$bd',@FileGroupName='$nameFile',@PathofFiles = '$pathFile',@MaxSizeMB=$sizeFile";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//añade procedimeinto: "filesGroupCreator" a cada base de datos
function add_procedureCreateGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    drop_procedureCreateGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd);

    $sql = "create procedure filesGroupCreator @DatabaseName varchar(30) ,@FileGroupName varchar(30)
            as
            begin
                declare @Query varchar(2000);
                set @Query='ALTER DATABASE ' + @DatabaseName + 
                           ' ADD FILEGROUP ' + @FileGroupName;
                exec (@Query)
            end";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//elimina procedimeinto: "filesGroupCreator" a cada base de datos
function drop_procedureCreateGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "IF EXISTS(SELECT 1 FROM sys.procedures WHERE Name = 'filesGroupCreator')
  drop Procedure filesGroupCreator";

    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//ejecuta procedimeinto: "filesGroupCreator" a cada base de datos
function CreateFileGroup_SQL($usuario,$contraseña,$ip,$puerto,$bd,$nameFile){
    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $sql = "exec filesGroupCreator @DatabaseName='$bd',@FileGroupName='$nameFile'";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//añade procedimeinto: "fileGroupModf" a cada base de datos
function add_procedureModifyGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    drop_procedureModifyGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd);

    $sql = "create procedure fileGroupModf @DatabaseName varchar(30),@FileGroupName varchar(30),@MaxSizeMB int
            as
            begin
                declare @Query varchar(2000);
                        set @Query='alter database ' + @DatabaseName+
                        ' modify file ( name =''' + @FileGroupName +'''' + 
                        ', size = ' + CONVERT(VARCHAR(10),@MaxSizeMB) + 'MB' +
                        ' ) ' ;
                    exec (@Query)
            end";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//elimina procedimeinto: "fileGroupModf" a cada base de datos
function drop_procedureModifyGroupFile_SQL($usuario,$contraseña,$ip,$puerto,$bd){

    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

    $sql = "IF EXISTS(SELECT 1 FROM sys.procedures WHERE Name = 'fileGroupModf')
  drop Procedure fileGroupModf";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

//ejecuta procedimeinto: "fileGroupModf" a cada base de datos
function ModifyFileGroup_SQL($usuario,$contraseña,$ip,$puerto,$bd,$nameFile,$sizeFile){
    $serverName = "$ip\sqlexpress,$puerto";
    $connectionInfo = array( "Database"=>$bd, "UID"=>$usuario, "PWD"=>$contraseña);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);

    if( $conn === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    $sql = "exec fileGroupModf @DatabaseName='$bd',@FileGroupName='$nameFile', @MaxSizeMB=$sizeFile";
    $stmt = sqlsrv_query( $conn, $sql );
    if( $stmt === false) {
        die( print_r( sqlsrv_errors(), true) );
    }
    sqlsrv_free_stmt( $stmt);
}

?>





