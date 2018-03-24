create table test(
	id int identity(1,1),
    nombre varchar(4) default '****'
)
go

insert into test(nombre) values('****')
select * from test
go

create procedure insPrueba1(@cant int)
as
begin
	WHILE @cant>0
	begin 
		insert test(nombre) values ('***')
		set @cant = @cant-1
	end
end;

set nocount on 
go
exec insPrueba1 1000
go
select * from test

use proyecto
go

--Procedimiento para obtener información sobre el tamaño en memoria
create procedure conexionBD
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
end;
exec conexionBD
go

---------crear discos---------
--Procedimiento para crear archivos/discos
--recibe:
--	DatabaseName=nombre de la base de datos donde se creara el disco
--	FileGroupName=es el nombre´para el disco
--	PathofFiles= la dirección donde se creara el disco
--	MaxSize=nuevo tamaño máximo para el disco
create procedure fileCreate @DatabaseName varchar(30),@FileGroupName varchar(30),@PathofFiles varchar (2000),@MaxSizeMB int----
as
begin
	declare @Query varchar(2000);
			set @Query='alter database ' + @DatabaseName+
			' add file ( name =''' + @FileGroupName +'''' + 
			', filename = ''' + @PathofFiles + '\' + @FileGroupName +'.ndf'+ ''''  +
			', size = ' + CONVERT(VARCHAR(10),@MaxSizeMB) + 'MB' +
			' ) ' ;
		exec (@Query)
end
--ejemplo de procedimiento para crear un disco
exec fileCreate @DatabaseName='sales',@FileGroupName='ss9',@PathofFiles = 'C:\Program Files\Microsoft SQL Server\MSSQL14.MSSQLSERVER\MSSQL\DATA\Nueva carpeta',@MaxSizeMB=200
go
-----------------------

------crear grupo------
--Procedimiento para crear un grupo
--recibe:
--	DatabaseName=nombre de la base de datos donde se creara el disco
--	FileGroupName=es el nombre para el grupo
--**se crea pero no se donde se consulta**
create procedure filesGroupCreator @DatabaseName varchar(30) ,@FileGroupName varchar(30)
as
begin
	declare @Query varchar(2000);
	set @Query='ALTER DATABASE ' + @DatabaseName + 
			   ' ADD FILEGROUP ' + @FileGroupName;
	exec (@Query)
end
exec filesGroupCreator @DatabaseName='sales',@FileGroupName='FileGroupName2'
go
-----------------------


---------modificar discos---------
--Procedimiento para modificar archivos/discos
--recibe:
--	DatabaseName=nombre de la base de datos donde se creara el disco
--	FileGroupName=es el nombre para el disco
--	MaxSize=el nuevo tamaño máximo para el disco
create procedure fileGroupModf @DatabaseName varchar(30),@FileGroupName varchar(30),@MaxSizeMB int
as
begin
	declare @Query varchar(2000);
			set @Query='alter database ' + @DatabaseName+
			' modify file ( name =''' + @FileGroupName +'''' + 
			', size = ' + CONVERT(VARCHAR(10),@MaxSizeMB) + 'MB' +
			' ) ' ;
		exec (@Query)
end
--ejemplo de procedimiento para modificar un disco
exec fileGroupModf @DatabaseName='sales',@FileGroupName='ss9', @MaxSizeMB=500
go
-----------------------