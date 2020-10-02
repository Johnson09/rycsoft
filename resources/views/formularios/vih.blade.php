@extends('layout.app')

@section('content')
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    initialize();
    initialize1();
});


// works out the X, Y position of the click inside the canvas from the X, Y position on the page
function getPosition(mouseEvent, sigCanvas) {
    var x, y;
    if (mouseEvent.pageX != undefined && mouseEvent.pageY != undefined) {
        x = mouseEvent.pageX;
        y = mouseEvent.pageY;
    } else {
        x = mouseEvent.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
        y = mouseEvent.clientY + document.body.scrollTop + document.documentElement.scrollTop;
    }

    return { X: x - sigCanvas.offsetLeft, Y: y - sigCanvas.offsetTop };
}

function initialize() {
        // get references to the canvas element as well as the 2D drawing context
        var sigCanvas = document.getElementById("canvasSignature1");
        var context = sigCanvas.getContext("2d");
        context.strokeStyle = 'Black';

        // This will be defined on a TOUCH device such as iPad or Android, etc.
        var is_touch_device = 'ontouchstart' in document.documentElement;

        if (is_touch_device) {
            // create a drawer which tracks touch movements
            var drawer = {
                isDrawing: false,
                touchstart: function (coors) {
                    context.beginPath();
                    context.moveTo(coors.x, coors.y);
                    this.isDrawing = true;
                },
                touchmove: function (coors) {
                    if (this.isDrawing) {
                        context.lineTo(coors.x, coors.y);
                        context.stroke();
                    }
                },
                touchend: function (coors) {
                    if (this.isDrawing) {
                        this.touchmove(coors);
                        this.isDrawing = false;
                    }
                }
            };

            // create a function to pass touch events and coordinates to drawer
            function draw(event) {

                // get the touch coordinates.  Using the first touch in case of multi-touch
                var coors = {
                    x: event.targetTouches[0].pageX,
                    y: event.targetTouches[0].pageY
                };

                // Now we need to get the offset of the canvas location
                var obj = sigCanvas;

                if (obj.offsetParent) {
                    // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
                    do {
                        coors.x -= obj.offsetLeft;
                        coors.y -= obj.offsetTop;
                    }
                    // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
                    // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
                    while ((obj = obj.offsetParent) != null);
                }

                // pass the coordinates to the appropriate handler
                drawer[event.type](coors);
            }


            // attach the touchstart, touchmove, touchend event listeners.
            sigCanvas.addEventListener('touchstart', draw, false);
            sigCanvas.addEventListener('touchmove', draw, false);
            sigCanvas.addEventListener('touchend', draw, false);

            // prevent elastic scrolling
            sigCanvas.addEventListener('touchmove', function (event) {
                event.preventDefault();
            }, false);
        }
        else {

            // start drawing when the mousedown event fires, and attach handlers to
            // draw a line to wherever the mouse moves to
            $("#canvasSignature1").mousedown(function (mouseEvent) {
                var position = getPosition(mouseEvent, sigCanvas);

                context.moveTo(position.X, position.Y);
                context.beginPath();

                // attach event handlers
                $(this).mousemove(function (mouseEvent) {
                    drawLine(mouseEvent, sigCanvas, context);
                }).mouseup(function (mouseEvent) {
                    finishDrawing(mouseEvent, sigCanvas, context);
                }).mouseout(function (mouseEvent) {
                    finishDrawing(mouseEvent, sigCanvas, context);
                });
            });

        }
    
}

function initialize1() {
        // get references to the canvas element as well as the 2D drawing context
        var sigCanvas = document.getElementById("canvasSignature2");
        var context = sigCanvas.getContext("2d");
        context.strokeStyle = 'Black';

        // This will be defined on a TOUCH device such as iPad or Android, etc.
        var is_touch_device = 'ontouchstart' in document.documentElement;

        if (is_touch_device) {
            // create a drawer which tracks touch movements
            var drawer = {
                isDrawing: false,
                touchstart: function (coors) {
                    context.beginPath();
                    context.moveTo(coors.x, coors.y);
                    this.isDrawing = true;
                },
                touchmove: function (coors) {
                    if (this.isDrawing) {
                        context.lineTo(coors.x, coors.y);
                        context.stroke();
                    }
                },
                touchend: function (coors) {
                    if (this.isDrawing) {
                        this.touchmove(coors);
                        this.isDrawing = false;
                    }
                }
            };

            // create a function to pass touch events and coordinates to drawer
            function draw(event) {

                // get the touch coordinates.  Using the first touch in case of multi-touch
                var coors = {
                    x: event.targetTouches[0].pageX,
                    y: event.targetTouches[0].pageY
                };

                // Now we need to get the offset of the canvas location
                var obj = sigCanvas;

                if (obj.offsetParent) {
                    // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
                    do {
                        coors.x -= obj.offsetLeft;
                        coors.y -= obj.offsetTop;
                    }
                    // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
                    // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
                    while ((obj = obj.offsetParent) != null);
                }

                // pass the coordinates to the appropriate handler
                drawer[event.type](coors);
            }


            // attach the touchstart, touchmove, touchend event listeners.
            sigCanvas.addEventListener('touchstart', draw, false);
            sigCanvas.addEventListener('touchmove', draw, false);
            sigCanvas.addEventListener('touchend', draw, false);

            // prevent elastic scrolling
            sigCanvas.addEventListener('touchmove', function (event) {
                event.preventDefault();
            }, false);
        }
        else {

            // start drawing when the mousedown event fires, and attach handlers to
            // draw a line to wherever the mouse moves to
            $("#canvasSignature2").mousedown(function (mouseEvent) {
                var position = getPosition(mouseEvent, sigCanvas);

                context.moveTo(position.X, position.Y);
                context.beginPath();

                // attach event handlers
                $(this).mousemove(function (mouseEvent) {
                    drawLine(mouseEvent, sigCanvas, context);
                }).mouseup(function (mouseEvent) {
                    finishDrawing(mouseEvent, sigCanvas, context);
                }).mouseout(function (mouseEvent) {
                    finishDrawing(mouseEvent, sigCanvas, context);
                });
            });

        }
    
}
// draws a line to the x and y coordinates of the mouse event inside
// the specified element using the specified context
function drawLine(mouseEvent, sigCanvas, context) {

    var position = getPosition(mouseEvent, sigCanvas);

    context.lineTo(position.X, position.Y);
    context.stroke();
}

// draws a line from the last coordiantes in the path to the finishing
// coordinates and unbind any event handlers which need to be preceded
// by the mouse down event
function finishDrawing(mouseEvent, sigCanvas, context) {
    // draw the line to the finishing coordinates
    drawLine(mouseEvent, sigCanvas, context);

    context.closePath();

    // unbind any events which could draw
    $(sigCanvas).unbind("mousemove")
        .unbind("mouseup")
        .unbind("mouseout");
}

function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
}

function datos_paciente(id_paciente) { 
    $.get('{{ action('PacienteController@getPaciente') }}?id_paciente=' + id_paciente, function(data) {
        if (data == "") {
            $('#s3').val('');
            $('#s4').val('');
            $('#s5').val('');
            $('#s6').val('');
            $('#s7').val('');
            $('#s8').val('');
            $('#s9').val('');
            $('#s10').val('');
            $('#s11').val('');
        }else{
            // console.log(data);
            $.each(data, function(index, ClassObj){
                $('#s3').val(ClassObj.primer_apellido);
                $('#s4').val(ClassObj.segundo_apellido);
                $('#s5').val(ClassObj.primer_nombre);
                $('#s6').val(ClassObj.segundo_nombre);
                $('#s7').val(ClassObj.fecha_nacimiento);
                $('#s8').val(ClassObj.id_sexo);
                $('#s9').val(ClassObj.direccion);
                $('#s10').val(ClassObj.telefono);
                $('#s11').val(ClassObj.email);
            })
        }
    });
}

function modalActualizar(id_orden){
    $("#actModal").modal();
    document.getElementById("form").action = "gestion_referencia/"+id_orden;

    for (let j = 1; j < 17; j++) {
        $('#i'+j).val("");
    }

    actBack();
    actBack('section1');

    $.get('{{ action('ReferenciaController@getReferencia') }}?id_orden=' + id_orden, function(data) {

        if (data == "") {
            console.log('error');
        }else{
            // console.log(data);
            $.each(data, function(index, ClassObj){
                $('#i1').text(ClassObj.name_departamento);
            })
        }
    });
}
</script>
<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <div class="container-fluid text-center">
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Consentimiento Toma (VIH)</b></h1>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Añadir Registro</button>
        <hr>

        <div class="table-responsive" style="background: #f9f9f9;">
            <table id="table_docu" class="cell-border compact stripe" style="background: #f9f9f9; font-size: 12px;">
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th>TIPO DOC</th>
                        <th>N° IDEN USUARIO</th>
                        <th>NOMBRES</th>
                        <th>PRIMER APELLIDO</th>
                        <th>SEG APELLIDO</th>
                        <th>EDAD</th>
                        <th>GENERO</th>
                        <th>DIRECCIÓN</th>
                        <th>TELEFONO</th>
                        <th>EMAIL</th>
                        <th>EPS</th>
                        <th>TIPO USUARIO</th>
                        <th>SERVICIO</th>
                        <th>FECHA REGISTRO</th>
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                        @foreach($encuesta as $re)
                            <tr>
                                <!-- <td>
                                    <button onclick="modalActualizar('')" class="btn btn-info" disabled>
                                        <span class="fa fa-pencil" aria-hidden="true"></span>
                                    </button>
                                </td> -->
                                <td>{{ $re->name_tipo_ident }}</td>
                                <td>{{ $re->id_paciente }}</td>
                                <td>{{ $re->primer_nombre }} {{ $re->segundo_nombre }}</td>
                                <td>{{ $re->primer_apellido }}</td>
                                <td>{{ $re->segundo_apellido }}</td>
                                <td>{{ $re->edad }}</td>
                                <td>{{ $re->name_sexo }}</td>
                                <td>{{ $re->direccion }}</td>
                                <td>{{ $re->telefono }}</td>
                                <td>{{ $re->email }}</td>
                                <td>{{ $re->name_eps }}</td>
                                <td>{{ $re->descripcion_tipo_user }}</td>
                                <td>{{ $re->name_servicio }}</td>
                                <td>{{ $re->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de registro de referencia -->
<div id="newModal" class="modal fade">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title"><b>Formulario Consentimiento Toma (VIH)</b></h3>
                <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
            </div>
            
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="{{ url('formulario_vih') }}" method="post" autocomplete="on" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 id="tl1"><b>Identificacion del Paciente</b></h5>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="10" name="id_tipo_ident" required="required" id="s1" onchange="$('#tipo_doc').text(this.options[this.selectedIndex].text);">
                                    <option value="">TIPO DOCUMENTO</option>
                                    @foreach($tipo_identificacion as $ti)
                                    <option value="{{ $ti->id_tipo_ident }}">{{ $ti->name_tipo_ident }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="identification_number" onkeyup="this.value=Numeros(this.value);" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" tabindex="11" required="required" id="s2"  maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="first_lastname" onkeyup="Textos(this);" placeholder="PRIMER APELLIDO" class="form-control input-lg" tabindex="6" required="required" id="s3" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="second_lastname" onkeyup="Textos(this);" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" tabindex="7" id="s4" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="first_name" onkeyup="Textos(this);" placeholder="PRIMER NOMBRE" class="form-control input-lg" tabindex="8" required="required" id="s5" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="second_name" onkeyup="Textos(this);" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" tabindex="8" id="s6" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label id="stl1">FECHA DE NACIMIENTO</label>
                                <input type="date" name="birthday" class="form-control input-lg" tabindex="13" required="required" id="s7"  onchange="if('{{$date}}'<=this.value){this.value=''}">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label id="stl2"></label>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="14" name="id_sexo" required="required" id="s8" >
                                    <option value="">GENERO</option>
                                    @foreach($genero as $sex)
                                    <option value="{{ $sex->id_sexo }}">{{ $sex->name_sexo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label id="stl3"></label>
                                <input type="text" name="address" placeholder="DIRECCIÓN" class="form-control input-lg" tabindex="6" required="required" id="s9" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label id="stl4"></label>
                                <input type="tel" name="telephone" placeholder="TELEFONO" class="form-control input-lg" tabindex="7" required="required" id="s10" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12">
                            <table id="section1" class="table table-hover" style="text-align: justify;">
                                <tr>
                                    <th>
                                        <p>Responsabilidad sobre la información consignada en la encuesta: </p>
                                        <p>Yo <label id="nombre_user"></label> N° <label id="tipo_doc"></label> <label id="doc"></label></p>
                                        <p>Declaro haber comprendido este documento y haber recibido Consejeria previa a la realización del test.</p>
                                        <p>Acepto la responsabilidad de retirar personalmente el resultado; encaso de no retirarlo en la fecha acordada, acepto que se me contacte confidencialmente, según los procedimientos que han informado (llamado telefonico, visita domiciliaria, carta certificada).</p>
                                        <p>Frente a esto decido:</p>
                                        <p>Acepto realizarme el examen de detección del VIH <input type="checkbox" name="terminos" value="1" required></p>
                                    </th>
                                </tr>          
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12">
                            <label id="stl5" style="display: none;">Nombre y Firma del consultante o representante legal:</label>
                            <div id="canvasDiv1">
                                <canvas id="canvasSignature1" name="firma_consultante" width="500" height="100" style="border: 2px solid black; display: none;">
                                </canvas>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12">
                            <label id="stl6" style="display: none;">Nombre y Firma responsable de asesoria:</label>
                            <div id="canvasDiv2">
                                <canvas id="canvasSignature2" name="firma_responsable" width="500" height="100" style="border: 2px solid black; display: none;">
                                </canvas>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6" id="inicio1">
                        </div>
                        <div class="col-xs-6 col-md-6" id="inicio2">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="Firmar" onclick="next('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin1" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="Regresar" onclick="back('section1')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin2" style="display: none;">
                            <input type="submit" class="btn btn-info btn-block btn-lg" tabindex="20" value="Guardar Registro">
                        </div>
                    </div>
                    </form>
                    <!-- Fin del formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Final del modal de registro de referencia -->

<style>
#canvasDiv1{
    width: 500px;
    height: 100px;
    margin: 0px auto;
}
#canvasDiv2{
    width: 500px;
    height: 100px;
    margin: 0px auto;
}
.inputBox{
	position: relative;
	box-sizing: border-box;
	margin-bottom: 50px;
}
.inputBox .inputText{
	position: absolute;
    font-size: 20px;
    line-height: 50px;
    transition: .5s;
    opacity: .5;
}
.inputBox .input{
	position: relative;
	width: 100%;
	height: 50px;
	background: transparent;
	border: none;
    outline: none;
    font-size: 20px;
    border-bottom: 1px solid rgba(0,0,0,.5);

}
.focus .inputText{
	transform: translateY(-30px);
	font-size: 18px;
	opacity: 1;
	color: #00bcd4;

}
.button{
	width: 100%;
    height: 50px;
    border: none;
    outline: none;
    background: #03A9F4;
    color: #fff;
}
</style>
<!-- <script src="https://code.jquery.pro/jquery-3.2.1.js"></script> -->

	<script type="text/javascript">

	 	$(".input").focus(function() {
	 		$(this).parent().addClass("focus");
        });
        
        function Numeros(string){//Solo numeros
            var out = '';
            var filtro = '1234567890';//Caracteres validos
            
            //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos 
            for (var i=0; i<string.length; i++)
            if (filtro.indexOf(string.charAt(i)) != -1) 
                    //Se añaden a la salida los caracteres validos
                out += string.charAt(i);
            
            //Retornar valor filtrado
            datos_paciente(out);
            $('#doc').text(out);
            return out;
        }

        function Textos(e){//solo letras y numeros
            var string = e.value;
            var out = '';
            //Se añaden las letras validas
            var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ ';//Caracteres validos
            
            for (var i=0; i<string.length; i++)
            if (filtro.indexOf(string.charAt(i)) != -1) 
                out += string.charAt(i);
            e.value = out.toUpperCase();
        }

        function next(section){
            // console.log(section);
            if (section === 'section2') {
                // Botones de secciones
                document.getElementById("inicio1").style.display = "none";
                document.getElementById("inicio2").style.display = "none";
                document.getElementById("fin1").style.display = "block";
                document.getElementById("fin2").style.display = "block";

                // Elementos Seccion0
                document.getElementById("tl1").style.display = "none";
                for (let i = 1; i < 5; i++) {
                    document.getElementById("stl"+i).style.display = "none";
                }
                for (let i = 1; i < 11; i++) {
                    document.getElementById("s"+i).style.display = "none";
                }
                document.getElementById("section1").style.display = "none";

                // Elementos Seccion1
                for (let i = 5; i < 7; i++) {
                    document.getElementById("stl"+i).style.display = "block";
                }
                document.getElementById("canvasSignature1").style.display = "block";
                document.getElementById("canvasSignature2").style.display = "block";

            }
        }

        function back(section){
            if (section === 'section1') {
                // Botones de secciones
                document.getElementById("fin1").style.display = "none";
                document.getElementById("fin2").style.display = "none";
                document.getElementById("inicio1").style.display = "block";
                document.getElementById("inicio2").style.display = "block";

                // Elementos Seccion0
                document.getElementById("tl1").style.display = "block";
                for (let i = 1; i < 5; i++) {
                    document.getElementById("stl"+i).style.display = "block";
                }
                for (let i = 1; i < 11; i++) {
                    document.getElementById("s"+i).style.display = "block";
                }
                document.getElementById("section1").style.display = "block";

                // Elementos Seccion1
                for (let i = 5; i < 7; i++) {
                    document.getElementById("stl"+i).style.display = "none";
                }
                document.getElementById("canvasSignature1").style.display = "none";
                document.getElementById("canvasSignature2").style.display = "none";

            }
        }
	</script>
@endsection
