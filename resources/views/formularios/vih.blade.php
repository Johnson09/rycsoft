@extends('layout.app')

@section('content')

<script type="text/javascript">

function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
}

function datos_paciente(id_paciente) { 
    $.get('{{ action('PacienteController@getPaciente') }}?id_paciente=' + id_paciente, function(data) {
        if (data == "") {
            $('#s1').val('');
            $('#s3').val('');
            $('#s4').val('');
            $('#s5').val('');
            $('#s6').val('');
            $('#s7').val('');
            $('#s8').val('');
            $('#s9').val('');
            $('#s10').val('');
            $('#s11').val('');
            $('#nombre_user').text('');
        }else{
            // console.log(data);
            $.each(data, function(index, ClassObj){
                $('#s1').val(ClassObj.id_tipo_ident);
                $('#s3').val(ClassObj.primer_apellido);
                $('#s4').val(ClassObj.segundo_apellido);
                $('#s5').val(ClassObj.primer_nombre);
                $('#s6').val(ClassObj.segundo_nombre);
                $('#s7').val(ClassObj.fecha_nacimiento);
                $('#s8').val(ClassObj.id_sexo);
                $('#s9').val(ClassObj.direccion);
                $('#s10').val(ClassObj.telefono);
                $('#s11').val(ClassObj.email);
                $('#nombre_user').text(ClassObj.primer_nombre+' '+ClassObj.primer_apellido);
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
            <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Ver Registros</button>
        <hr>

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
                <div class="col-xs-8 col-md-8 col-md-8">
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
                <div class="col-xs-4 col-md-4 col-md-4">
                    
                </div>
            </div>

            <label id="stl5">Nombre y Firma del consultante o representante legal:</label>
            <div id="canvasDiv1">
                <canvas id="canvasSignature1" style="border: 2px solid black;">
                </canvas>
                <input type="hidden" name="firma_consultante" value="" id="firma_consultante">
            </div>
                    <script>
                        var canvas = document.getElementById('canvasSignature1');
                        var ctx = canvas.getContext('2d');
                        
                        var painting = document.getElementById('canvasDiv1');
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

                        var image = canvas.toDataURL(); // data:image/png....
                        document.getElementById('firma_consultante').value = image;
                    </script>

            <label id="stl6">Nombre y Firma responsable de asesoria:</label>
            <div id="canvasDiv2">
                <canvas id="canvasSignature2" style="border: 2px solid black;">
                </canvas>
                <input type="hidden" name="firma_responsable" value="" id="firma_responsable">
            </div>
                    <script>
                        var canvass = document.getElementById('canvasSignature2');
                        var ctxs = canvass.getContext('2d');
                        
                        var paintings = document.getElementById('canvasDiv2');
                        var paint_styles = getComputedStyle(paintings);
                        canvass.width = parseInt(paint_styles.getPropertyValue('width'));
                        canvass.height = parseInt(paint_styles.getPropertyValue('height'));

                        var mouses = {x: 0, y: 0};
                        
                        canvass.addEventListener('mousemove', function(e) {
                        mouses.x = e.pageX - this.offsetLeft;
                        mouses.y = e.pageY - this.offsetTop;
                        }, false);

                        ctxs.lineWidth = 2;
                        ctxs.lineJoin = 'round';
                        ctxs.lineCap = 'round';
                        ctxs.strokeStyle = '#000000';
                        
                        canvass.addEventListener('mousedown', function(e) {
                            ctxs.beginPath();
                            ctxs.moveTo(mouses.x, mouses.y);
                        
                            canvass.addEventListener('mousemove', onPaints, false);
                        }, false);
                        
                        canvass.addEventListener('mouseup', function() {
                            canvass.removeEventListener('mousemove', onPaints, false);
                        }, false);
                        
                        var onPaints = function() {
                            ctxs.lineTo(mouses.x, mouses.y);
                            ctxs.stroke();
                        };

                        var images = canvass.toDataURL(); // data:image/png....
                        document.getElementById('firma_responsable').value = images;
                    </script>

            <hr>
            <div class="row">
                <div class="col-xs-6 col-md-6">
                    <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="Borrar Firmas" onclick="canvas.width=canvas.width; canvass.width=canvass.width;">
                </div>
                <div class="col-xs-6 col-md-6">
                    <input type="submit" class="btn btn-info btn-block btn-lg" tabindex="20" value="Guardar Registro">
                </div>
            </div>
            </form>
            <!-- Fin del formulario -->
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
                <h3 class="modal-title"><b>Registros Consentimiento Toma (VIH)</b></h3>
            </div>
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div class="table-responsive" style="background: #f9f9f9;">
                    <table id="table_docu" class="cell-border compact stripe" style="background: #f9f9f9; font-size: 12px;">
                        <thead>
                            <tr>
                                <th>TIPO DOC</th>
                                <th>N° IDEN USUARIO</th>
                                <th>NOMBRES</th>
                                <th>APELLIDOS</th>
                                <th>EDAD</th>
                                <th>GENERO</th>
                                <th>DIRECCIÓN</th>
                                <th>TELEFONO</th>
                                <th>FIRMA CONSULTANTE</th>
                                <th>FIRMA RESPONSABLE</th>
                                <th>FECHA REGISTRO</th>
                            </tr>
                        </thead>
                        
                        <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                            <tbody style="text-align: center;">
                                @foreach($consentimiento as $re)
                                    <tr>
                                        <td>{{ $re->name_tipo_ident }}</td>
                                        <td>{{ $re->id_paciente }}</td>
                                        <td>{{ $re->primer_nombre }} {{ $re->segundo_nombre }}</td>
                                        <td>{{ $re->primer_apellido }} {{ $re->segundo_apellido }}</td>
                                        <td>{{ $re->edad }}</td>
                                        <td>{{ $re->name_sexo }}</td>
                                        <td>{{ $re->direccion }}</td>
                                        <td>{{ $re->telefono }}</td>
                                        <td>
                                            <canvas id="imagen1"></canvas>
                                            <script>
                                                var canva1 = document.getElementById("imagen1");
                                                var ctx1 = canvas.getContext("2d");
                                                var data1 = '{{$re->firma_consultante}}';
                                                var img = new Image();
                                                img.onload = function() {
                                                    ctx1.drawImage(img, 0, 0, 320, 200);
                                                };
                                                img.src = data1;
                                                if (img.complete) img.onload();
                                            </script>
                                        </td>
                                        <td>
                                            <?php
                                                $imgs = str_replace('data:image/png;base64,', '', $re->firma_responsable);
                                                $fileDatas = base64_decode($imgs);
                                                $fileNames = uniqid().'.png';

                                                file_put_contents($fileNames, $fileDatas);

                                                header('Content-Type: image/png');
                                            ?>
                                        </td>
                                        <td>{{ $re->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Final del modal de registro de referencia -->

<style>
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
	</script>
@endsection
