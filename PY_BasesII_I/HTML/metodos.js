
function limpiarFormI() {
    document.getElementById("contenidoI").reset();
}

function loginPostgres() {
    validarFormulario();
}

function loginSQL() {
    validarFormulario();
}


function validarFormulario() {
    var JSON="";
    var estado=true;

    var usuario=document.getElementById('usuario').value;
    var contraseña=document.getElementById('constrasena').value;
    var IP= document.getElementById("direccionip").value;
    var puerto= document.getElementById("puertoServidor").value;

    //Test campo obligatorio
    if(usuario == null || usuario.length == 0 || /^\s+$/.test(usuario)){
        alert('ERROR: El campo Usuario no debe ir vacío o lleno de solamente espacios en blanco');
        estado=false;
        JSON="error al llenar el formulario";
    }
    else{JSON=JSON+" "+usuario.toString();}

    //Test campo obligatorio
    if(contraseña == null || contraseña.length == 0 || /^\s+$/.test(contraseña)){
        alert('ERROR: El campo Contraseña no debe ir vacío o lleno de solamente espacios en blanco');
        estado=false;
        JSON="error al llenar el formulario";
    }
    else{JSON=JSON+" "+contraseña.toString();}

    //Test campo obligatorio
    if(IP == null || IP.length == 0 || /^\s+$/.test(IP)){
        alert('ERROR: El campo IP no debe ir vacío o lleno de solamente espacios en blanco');
        estado=false;
        JSON="error al llenar el formulario";
    }
    else{JSON=JSON+" "+IP.toString();}

    //Test edad
    if(puerto == null || puerto.length == 0 || isNaN(puerto)){
        alert('ERROR: Debe ingresar una Puerto');
        estado=false;
        JSON="error al llenar el formulario";
    }
    else{JSON=JSON+" "+puerto.toString();}

    console.log(JSON);
    limpiarFormI();
}