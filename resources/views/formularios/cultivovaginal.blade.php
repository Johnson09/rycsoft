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
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Consentimiento Cultivo Vaginal y Rectal Mujeres<p></p>(Tercer Trimestre Embarazo)</b></h1>
            <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Ver Registros</button>
        <hr>

        <div style="text-align: center;">
            <!-- Formulario de registro de referencia -->
            <form role="form" id="form" action="{{ url('formulario_cultivoVaginal') }}" method="post" enctype="multipart/form-data">
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
                        <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required" id="s12" >
                            <option value="">EPS</option>
                            @foreach($regimen_eps as $eps)
                                <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                            @endforeach
                        </select>
                    </div>  
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <input type="text" name="nombre_acompañante" placeholder="NOMBRE ACOMPAÑANTE" class="form-control input-lg" required="required">
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <input type="tel" name="telefono_acompañante" placeholder="CELULAR" class="form-control input-lg" required="required">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-md-12">
                    <table id="section1" class="table table-hover" style="text-align: justify;">
                        <tr>
                            <th>
                                <p>El examen denominado cultivo vaginal – rectal consiste en la toma de una muestra
                                vaginal y una muestra rectal, con el fin de detectar en las mujeres embarazadas en el
                                último trimestre de gestación la bacteria Streptococcus agalactie entre otros
                                microorganismos. Este examen es de gran importancia porque la presencia de dicha
                                bacteria ya sea en la cavidad vaginal o en el tracto rectal, implica que usted o su bebé
                                pueden estar en riesgo de adquirir la infección en el momento del parto o después de
                                este. La bacteria Streptococcus agalactiae en mujeres embarazadas puede causar:
                                Infección urinaria, endometritis, sepsis puerperal, infección de la herida quirúrgica tras
                                cesárea; y en el recién nacido: bacteriemia, neumonía y meningitis.</p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p><b>Procedimiento:</b> Posterior a la orden médica en el tercer trimestre de embarazo; en el
                                laboratorio se le practicará este examen que consiste en tomar una muestra de secreción
                                vaginal con un aplicador de algodón y posteriormente se le tomará una muestra rectal con
                                otro aplicador diferente, rotándolo suavemente. La toma de esta muestra no le ocasionará
                                dolor y no implica ningún riesgo para usted ni para su bebé.</p>
                                <p>Yo <label id="nombre_user"></label> N° <label id="tipo_doc"></label> <label id="doc"></label>, autorizo la toma del examen vaginal-rectal.</p>
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <p>Manifiesto que he entendido y comprendido perfectamente la anterior información. Se me
                                ha dado la oportunidad de hacer preguntas y estas han sido contestadas
                                satisfactoriamente.</p>
                            </th>
                        </tr>       
                    </table>
                </div>
            </div>

            <div style="width: 40em; text-align: justify;">
                <label>Firma/Documento del Paciente:</label>
                <div id="canvasDiv2">
                    <canvas id="canvasSignature2" height="50" style="border: 2px solid black;">
                    </canvas>
                    <input type="hidden" name="firma_paciente" value="" id="firma_paciente">
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

                        document.getElementById('form').addEventListener("submit",function(e){
                            var images = canvass.toDataURL(); // data:image/png....
                            document.getElementById('firma_paciente').value = images;
                        },false);

                    </script>
            </div>

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
                                            <img src="public/firms_image/{{ $re->firma_consultante }}" alt="" style="width: 100%">
                                        </td>
                                        <td>
                                            <img src="public/firms_image/{{ $re->firma_responsable }}" alt="" style="width: 100%">
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

            $('#nombre_user').text($('#s5').val()+" "+$('#s6').val()
                +" "+$('#s3').val()+" "+$('#s4').val());
        }
	</script>
@endsection
