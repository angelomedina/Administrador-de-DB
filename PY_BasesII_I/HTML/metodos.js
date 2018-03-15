
function persona(usr,contra,ip,puert) {
    this.usuario=usr;
    this.contraseña=contra;
    this.IP =ip;
    this.puerto=puert;
}

function limpiarFormI() {
    document.getElementById("contenidoI").reset();
}

function loginPostgres() {
    var objeto=validarFormulario();
    console.log(objeto)

    if(objeto != null) {
        console.log(objeto);
        conectarPOSTGRES();
    }
    else
    {
        alert("Error verifique que el formulario este lleno")
    }
}

function loginSQL() {
    var objeto=validarFormulario();
    console.log(objeto)

    if(objeto != null) {
        console.log(objeto);
    }
    else
    {
        alert("Error verifique que el formulario este lleno")
    }
}


function conectarPOSTGRES() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            //obj=eval (this.responseText);
            //console.log(obj);
        }
    };
    xhttp.open("GET", "../HTML/index.php?func=conectar_PostgreSQL()", true);
    xhttp.send();
}

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


