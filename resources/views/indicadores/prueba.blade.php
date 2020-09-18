@extends('layout.app')
<!-- <script type="text/javascript">

function addCup(){

    var cup = document.getElementById('producto').value;
    var cups_des = document.getElementById('precio').value;

    sessionStorage.setItem(cup,cups_des); //ó sessionStorage[producto]=precio

    mostrarDatos(cup);
}

function mostrarDatos(){

    var cups = [];
    var datosDisponibles = document.getElementById('datosDisponibles');
    datosDisponibles.innerHTML='';

    for(var i=0; i<sessionStorage.length; i++){

        var cup = sessionStorage.key(i);
        var cups_des = sessionStorage.getItem(cup);
        datosDisponibles.innerHTML += '<div>'+cup+' - '+cups_des+'<input type="button" onclick="'+cup+'" id="limpiar" value="Eliminar cup" /></div>';
        cups.push(cup);

    }
    console.log(sessionStorage);
}

function borrarTodo() {
    sessionStorage.clear(); 
    mostrarDatos(); 
}

</script>

<form name="formulario">

<p>Nombre del producto:<br><input type="text" name="producto" id="producto"></p>

<p>Precio:<br><input type="text" name="precio" id="precio"></p>

<p><input type="button" onclick="addCup()" name="guardar" id="guardar" value="guardar"></p>

<p><input type="button" onclick="borrarTodo()" name="borrar" id="borrar" value="Borrar todo"></p>

</form>

<br/>

<div id="datosDisponibles">No hay información almacenada</div> -->
@section('content')
@endsection