//variable con los datos de la conexion actual
google.charts.load('current', {'packages':['table']});
google.charts.setOnLoadCallback(chart_Postgres);

var usuarioActual;
var conexionActual;

//objeto perosna con los datos del formulario
function persona(usr,contra,ip,puert) {
    this.usuario=usr;
    this.contraseña=contra;
    this.IP =ip;
    this.puerto=puert;
}

//objeto perosna con los datos del formulario
function conexion(usr,contra,ip,puert,db) {
    this.usuario=usr;
    this.contraseña=contra;
    this.IP =ip;
    this.puerto=puert;
    this.DB=db;
}

//limpia el formulario
function limpiarFormI() {
    //document.getElementById("contenidoI").reset();
}

//cuando recogio exitosamente los parametros de usuario lo envia a conectarse con Postgres
function loginPostgres() {

    var usuario=validarFormulario();
    if(usuario != null) {
        usuarioActual=usuario;
        conectarPOSTGRES(usuario);
    }
    else { alert("Error verifique que el formulario este lleno");}
}

//imprime el resultado de la piticion de la conexion
function mensaje(mensaje,estado,respuesta,estadoRespuesta) {
    if(mensaje == "OK" && estado == 200 && estadoRespuesta == 10){
        alert("Conexion exitosa con Postgres");
        getBasesDatos_Postgres();
    }
    else {
        alert(respuesta);
    }
}

//hace la solicitid de la conexion con postgres
function conectarPOSTGRES(usuario){

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        document.getElementById('btn_postgres').value="Esperando..."

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('btn_postgres').value="postgres";

            if(this.statusText== "OK" && this.status == 200) {

                usuarioActual=usuario;
                mensaje(this.statusText, this.status,this.responseText,this.responseText.length);
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=conectar_PostgreSQL()&usuario="+usuario.usuario +"&contraseña="+usuario.contraseña +"&ip="+usuario.IP +"&puerto="+usuario.puerto.toString(), true);
    xhttp.send();
}

//valida que el formula este correctamente lleno y retorna un objeto tipo persona
function validarFormulario() {
    var JSON = "";
    var estado = true;

    var usuario = document.getElementById('usuario').value;
    var contraseña = document.getElementById('constrasena').value;
    var IP = document.getElementById("direccionip").value;
    var puerto = document.getElementById("puertoServidor").value;

    //Test campo obligatorio
    if (usuario == null || usuario.length == 0 || /^\s+$/.test(usuario)) {
        alert('ERROR: El campo Usuario no debe ir vacío o lleno de solamente espacios en blanco');
        estado = false;
        JSON = "error al llenar el formulario";
    }

    //Test campo obligatorio
    if (contraseña == null || contraseña.length == 0 || /^\s+$/.test(contraseña)) {
        alert('ERROR: El campo Contraseña no debe ir vacío o lleno de solamente espacios en blanco');
        estado = false;
        JSON = "error al llenar el formulario";
    }

    //Test campo obligatorio
    if (IP == null || IP.length == 0 || /^\s+$/.test(IP)) {
        alert('ERROR: El campo IP no debe ir vacío o lleno de solamente espacios en blanco');
        estado = false;
        JSON = "error al llenar el formulario";
    }

    //Test edad
    if (puerto == null || puerto.length == 0 || isNaN(puerto)) {
        alert('ERROR: Debe ingresar una Puerto');
        estado = false;
        JSON = "error al llenar el formulario";
    }

    if (estado == true) {

        //creo el objeto persona
        var objPersona = new persona( usuario , contraseña, IP,puerto);
        //limpio el formulario
        limpiarFormI();
        //retorno el objeto
        return objPersona;

    }else {return null}
}

function setBD_Postgres(){
    //obtiene los datos del select

    var bd = document.getElementById('select-bd-postgres').value;
    //crea el objeto conexion
    var objConexion = new conexion( usuarioActual.usuario , usuarioActual.contraseña, usuarioActual.IP,usuarioActual.puerto,bd);
    //instancia de manera global
    conexionActual = objConexion;
    limpiarSelect();
    //verificacion de cambio de BD
    cambioBD_Postgres();

}

//funcion dependiente de la anterior setBD() hace la peticion
function cambioBD_Postgres() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        document.getElementById('btn-db').value="Esperando..."

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('btn-db').value="Selecionar";

            if(this.statusText== "OK" && this.status == 200) {

                add_procedure_Postgres();
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=select_Postgres()&usuario="+conexionActual.usuario +"&contraseña="+conexionActual.contraseña +"&ip="+conexionActual.IP +"&puerto="+conexionActual.puerto.toString()+"&bd="+conexionActual.DB, true);
    xhttp.send();
}

function getBasesDatos_Postgres()
{
    var pais="";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {

            obj= this.responseText ;

            for (var i in obj)
            {
                var pieza=obj[i];
                if(pieza != "," ) {
                    pais=pais+pieza;
                }
                else {
                    //console.log(pais);
                    addOptions("select-bd-postgres", pais);
                    pais = "";

                }
            }
        }
    };
    xhttp.open("GET", "../PHP/index.php?func=get_DB_postgres()&usuario="+usuarioActual.usuario +"&contraseña="+usuarioActual.contraseña +"&ip="+usuarioActual.IP +"&puerto="+usuarioActual.puerto.toString()+"&bd="+"postgres", true);
    xhttp.send();
}

function addOptions(domElement, array) {

 if(array !== "undefinedmaster") {
     if (array != "") {
         if (array != undefined) {
             if(array != '"') {
                 var select = document.getElementsByName(domElement)[0];
                 var option = document.createElement("option");
                 option.text = array;
                 select.add(option);
             }
         }
     }
 }
}

function mensajeGrafico(mensaje,estado,respuesta,estadoRespuesta) {

    if(mensaje == "OK" && estado == 200 && estadoRespuesta == 10){
        alert("Conexion exitosa con Postgres");
        getBasesDatos_Postgres();
        add_grafico_Postgres();
    }
    else {
        alert(respuesta);
    }
}

function add_procedure_Postgres() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        document.getElementById('btn-db').value="Esperando..."

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('btn-db').value="Selecionar";

            if(this.statusText== "OK" && this.status == 200) {

                mensajeGrafico(this.statusText, this.status,this.responseText,this.responseText.length);
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=add_procedure_DB_postgres()&usuario="+conexionActual.usuario +"&contraseña="+conexionActual.contraseña +"&ip="+conexionActual.IP +"&puerto="+conexionActual.puerto.toString()+"&bd="+conexionActual.DB, true);
    xhttp.send();
}

function add_grafico_Postgres() {
    var pais="";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {

            if(this.statusText== "OK" && this.status == 200) {

                obj= this.responseText ;
                for (var i in obj)
                {
                    var pieza=obj[i];
                    if(pieza != ']'){
                        if( pieza != '['){
                            if(pieza != '('){
                                if(pieza != ')'){
                                    if(pieza != '"'){
                                    pais=pais+pieza;
                                }}}}}
                }
                chart_Postgres(conexionActual.DB,parseInt(pais),true);
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=add_grafico_DB_postgres()&usuario="+conexionActual.usuario +"&contraseña="+conexionActual.contraseña +"&ip="+conexionActual.IP +"&puerto="+conexionActual.puerto.toString()+"&bd="+conexionActual.DB, true);
    xhttp.send();
}


function limpiarSelect() {
    var select = document.getElementById('select-bd-postgres');
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
}

function chart_Postgres(BD,tamaño,estado) {

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Base de datos');
    data.addColumn('number', 'Tamaño');
    data.addColumn('boolean', 'Conexión actual');
    data.addRows([
        [BD,  tamaño,estado]
    ]);
    var table = new google.visualization.Table(document.getElementById('chart_postgres'));
    table.draw(data, {showRowNumber: true, width: '100%', height: '20%'});

}
