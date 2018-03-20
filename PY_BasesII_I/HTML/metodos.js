//variable con los datos de la conexion actual
var usuarioActual;

//objeto perosna con los datos del formulario
function persona(usr,contra,ip,puert) {
    this.usuario=usr;
    this.contraseña=contra;
    this.IP =ip;
    this.puerto=puert;
}

//limpia el formulario
function limpiarFormI() {
    document.getElementById("contenidoI").reset();
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

//cuando recogio exitosamente los parametros de usuario lo envia a conectarse con SQL
function loginSQL() {
    var usuario=validarFormulario();
    if(usuario != null) {
        usuarioActual=usuario;
        conectarSQLServer(usuario);
    }
    else { alert("Error verifique que el formulario este lleno");}
}

//imprime el resultado de la piticion de la conexion
function mensaje(mensaje,estado,respuesta,estadoRespuesta) {

    if(mensaje == "OK" && estado == 200 && estadoRespuesta == 4){
        alert("Conexion exitosa con Postgres");
        window.location.href = href="../HTML/postgres.html";
    }
    else if( estadoRespuesta == 36) {
        alert("Conexion exitosa con SQL Server");
        window.location.href = href = "../HTML/sql.html";
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

                mensaje(this.statusText, this.status,this.responseText,this.responseText.length);
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=conectar_PostgreSQL()&usuario="+usuario.usuario +"&contraseña="+usuario.contraseña +"&ip="+usuario.IP +"&puerto="+usuario.puerto.toString(), true);
    xhttp.send();
}

//hace la solicitid de la conexion con sql
function conectarSQLServer(usuario){

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {

        document.getElementById('btn_sqlserver').value="Esperando..."

        if (this.readyState == 4 && this.status == 200) {

            document.getElementById('btn_sqlserver').value="sqlserver";

            if(this.statusText== "OK" && this.status == 200) {


                mensaje(this.statusText, this.status,this.responseText,this.responseText.length);
            }
            else{console.log(this.statusText, this.status)}

        }
    };
    xhttp.open("GET", "../PHP/index.php?func=conectar_SQLServer()&usuario="+usuario.usuario +"&contraseña="+usuario.contraseña +"&ip="+usuario.IP +"&puerto="+usuario.puerto.toString(), true);
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


