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
    <div id="paint">
  		<canvas id="myCanvas"></canvas>
	</div>
    <script>
        var canvas = document.getElementById('myCanvas');
        var ctx = canvas.getContext('2d');
        
        var painting = document.getElementById('paint');
        var paint_style = getComputedStyle(painting);
        canvas.width = parseInt(paint_style.getPropertyValue('width'));
        canvas.height = parseInt(paint_style.getPropertyValue('height'));

        var mouse = {x: 0, y: 0};
        
        canvas.addEventListener('mousemove', function(e) {
        mouse.x = e.pageX - this.offsetLeft;
        mouse.y = e.pageY - this.offsetTop;
        }, false);

        ctx.lineWidth = 2;
        ctx.lineJoin = 'round';
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000000';
        
        canvas.addEventListener('mousedown', function(e) {
            ctx.beginPath();
            ctx.moveTo(mouse.x, mouse.y);
        
            canvas.addEventListener('mousemove', onPaint, false);
        }, false);
        
        canvas.addEventListener('mouseup', function() {
            canvas.removeEventListener('mousemove', onPaint, false);
        }, false);
        
        var onPaint = function() {
            ctx.lineTo(mouse.x, mouse.y);
            ctx.stroke();
        };
    </script>
@endsection