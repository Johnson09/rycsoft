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
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Encuesta Covid-19</b></h1>
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
                <h3 class="modal-title"><b>ENCUESTA DE SINTOMAS COVID</b></h3>
                <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
            </div>
            
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="{{ url('gestion_encuesta_covid') }}" method="post" autocomplete="on" enctype="multipart/form-data">
                    @csrf
                    
                    <h5 id="tl1"><b>Datos Usuario</b></h5>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="10" name="id_tipo_ident" required="required" id="s1" >
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
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
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
                                <input type="text" name="address" placeholder="DIRECCIÓN" class="form-control input-lg" tabindex="6" required="required" id="s9" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="tel" name="telephone" placeholder="TELEFONO" class="form-control input-lg" tabindex="7" required="required" id="s10" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="EMAIL" class="form-control input-lg" tabindex="7" required="required" id="s11" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required" id="s12" >
                                    <option value="">EPS</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="16" name="tipo_usuario" required="required" id="s13" >
                                    <option value="">TIPO USUARIO</option>
                                    @foreach($tipo_usuario as $tpuser)
                                    <option value="{{ $tpuser->id_tipo_user }}">{{ $tpuser->descripcion_tipo_user }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_servicio" required="required" id="s14" >
                                    <option value="">SERVICIO</option>
                                    @foreach($servicio as $ser)
                                    <option value="{{ $ser->id_servicio }}">{{ $ser->name_servicio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-md-12">
                            <table class="table table-hover">
                                <thead id="section1" style="display: none;">
                                    <tr>
                                        <th colspan="4">
                                            1. ANTECEDENTES. ¿Ha tenido alguno de los siguientes antecedentes?
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Observación
                                        </th>
                                    </tr>
                                    @foreach($preguntas as $pre)
                                        @if($pre->id_grupo == 1)
                                        <tr style="text-align: justify;">
                                            <td><input type="hidden" name="id_pregunta{{ $pre->id_pregunta }}" value="{{ $pre->id_pregunta }}" required="required">{{ $pre->descripcion_pregunta }}</td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="1"></td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="0" checked></td>
                                            <td><textarea name="observacion_pregunta{{ $pre->id_pregunta }}" cols="30" rows="3"></textarea></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </thead>
                                <tbody id="section2" style="display: none;">
                                    <tr>
                                        <th colspan="4">
                                            2. ¿Ha tenido síntomas en los últimos 2 días?
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Observación
                                        </th>
                                    </tr>
                                    @foreach($preguntas as $pre)
                                        @if($pre->id_grupo == 2)
                                        <tr style="text-align: justify;">
                                            <td><input type="hidden" name="id_pregunta{{ $pre->id_pregunta }}" value="{{ $pre->id_pregunta }}" required="required">{{ $pre->descripcion_pregunta }}</td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="1"></td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="0" checked></td>
                                            <td><textarea name="observacion_pregunta{{ $pre->id_pregunta }}" cols="30" rows="3"></textarea></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot id="section3" style="display: none;">
                                    <tr>
                                        <th colspan="4">
                                            3. Identificación de Contacto
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                        <th>
                                            Observación
                                        </th>
                                    </tr>
                                    @foreach($preguntas as $pre)
                                        @if($pre->id_grupo == 3)
                                        <tr style="text-align: justify;">
                                            <td><input type="hidden" name="id_pregunta{{ $pre->id_pregunta }}" value="{{ $pre->id_pregunta }}" required="required">{{ $pre->descripcion_pregunta }}</td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="1"></td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="0" checked></td>
                                            <td><textarea name="observacion_pregunta{{ $pre->id_pregunta }}" cols="30" rows="3"></textarea></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    <tr>
                                        <th colspan="4">
                                            4. Pruebas Diagnosticas
                                        </th>
                                    </tr>
                                    @foreach($preguntas as $pre)
                                        @if($pre->id_grupo == 4)
                                        <tr style="text-align: justify;">
                                            <td><input type="hidden" name="id_pregunta{{ $pre->id_pregunta }}" value="{{ $pre->id_pregunta }}" required="required">{{ $pre->descripcion_pregunta }}</td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="1"></td>
                                            <td><input type="radio" name="respuesta_pregunta{{ $pre->id_pregunta }}" value="0" checked></td>
                                            <td><textarea name="observacion_pregunta{{ $pre->id_pregunta }}" cols="30" rows="3"></textarea></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    
                                </tfoot>
                            </table>
                            <table id="section4" class="table table-hover" style="text-align: justify; display: none;">
                                <tr>
                                    <th>
                                        <p>Responsabilidad sobre la información consignada en la encuesta: </p>
                                        <p>Yo <label id="nombre_user"></label> responsable sobre la veracidad de la información que suministres a lo largo de la encuesta y que entiendes que la información es requerida para conocer tus condiciones de salud, y a partir de esta, conocer los acciones en prevención a exposición al COVID 19,  Seguridad de la Información: La ESE Hospital Divino Niño guardará absoluta confidencialidad sobre la información presentada, la cual estará sujeta a los más altos estándares de seguridad de la información. Autorizo de manera libre y espontánea a suministrar la información que he diligenciado en esta encuesta a la ESE Hospital Divino Niño, ARL, entes de control, entes gubernamentales, y autoridades sanitarias para que aporten a la implementación de los sistemas de vigilancia epidemiológica que ayudan al control y mitigación de la Pandemia Mundial del virus SARS- CoV-2 (Covid 19), pues estos datos proporcionan información relevante para construir un sistema de vigilancia epidemiológica de Colombia y contribuye a mejorar las condiciones de salud en el ámbito laboral y comunitario.</p>
                                        <p>Acepto los Términos y Condiciones <input type="checkbox" name="terminos" value="1" required></p>
                                    </th>
                                </tr>          
                            </table>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6" id="inicio1">
                        </div>
                        <div class="col-xs-6 col-md-6" id="inicio2">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="next('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="medio1" style="display: none;">
                            <input type="button" class="btn btn-info btn-block btn-lg" tabindex="20" value="REGRESAR" onclick="back('section1')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="medio2" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="next('section3')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="medio11" style="display: none;">
                            <input type="button" class="btn btn-info btn-block btn-lg" tabindex="20" value="REGRESAR" onclick="back('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="medio21" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="next('section4')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin1" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="REGRESAR" onclick="back('section3')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin2" style="display: none;">
                            <input type="submit" class="btn btn-info btn-block btn-lg" tabindex="20" value="GUARDAR REGISTRO">
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
                document.getElementById("medio1").style.display = "block";
                document.getElementById("medio2").style.display = "block";

                // Elementos Seccion0
                document.getElementById("tl1").style.display = "none";
                document.getElementById("stl1").style.display = "none";
                for (let i = 1; i < 15; i++) {
                    document.getElementById("s"+i).style.display = "none";
                    
                }

                // Elementos Seccion1
                document.getElementById("section1").style.display = "block";

                // Elementos Seccion4
                $('#nombre_user').text($('#s5').val()+" "+$('#s6').val()
                +" "+$('#s3').val()+" "+$('#s4').val());

            }else if (section === 'section3') {
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("medio11").style.display = "block";
                document.getElementById("medio21").style.display = "block";

                // Elementos Seccion1
                document.getElementById("section1").style.display = "none";

                // Elementos Seccion2
                document.getElementById("section2").style.display = "block";
            }else {
                document.getElementById("medio11").style.display = "none";
                document.getElementById("medio21").style.display = "none";
                document.getElementById("fin1").style.display = "block";
                document.getElementById("fin2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("section2").style.display = "none";

                // Elementos Seccion3
                document.getElementById("section3").style.display = "block";

                // Elementos Seccion4
                document.getElementById("section4").style.display = "block";

            }
        }

        function back(section){
            if (section === 'section1') {
                // Botones de secciones
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("inicio1").style.display = "block";
                document.getElementById("inicio2").style.display = "block";

                // Elementos Seccion0
                document.getElementById("tl1").style.display = "block";
                document.getElementById("stl1").style.display = "block";
                for (let i = 1; i < 15; i++) {
                    document.getElementById("s"+i).style.display = "block";
                    
                }

                // Elementos Seccion1
                document.getElementById("section1").style.display = "none";

            }else if (section === 'section2') {
                document.getElementById("medio11").style.display = "none";
                document.getElementById("medio21").style.display = "none";
                document.getElementById("medio1").style.display = "block";
                document.getElementById("medio2").style.display = "block";

                // Elementos Seccion1
                document.getElementById("section1").style.display = "block";

                // Elementos Seccion2
                document.getElementById("section2").style.display = "none";

            }else {
                document.getElementById("fin1").style.display = "none";
                document.getElementById("fin2").style.display = "none";
                document.getElementById("medio11").style.display = "block";
                document.getElementById("medio21").style.display = "block";

                // Elementos Seccion2
                document.getElementById("section2").style.display = "block";

                // Elementos Seccion3
                document.getElementById("section3").style.display = "none";
                
                // Elementos Seccion4
                document.getElementById("section4").style.display = "none";

            }
        }
	</script>
@endsection
