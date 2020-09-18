@extends('layout.app')

@section('content')
<script type="text/javascript">

function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
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
                        <th></th>
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
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                            <tr>
                                <td>
                                    <button onclick="modalActualizar('')" class="btn btn-info">
                                        <span class="fa fa-pencil" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
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
                    
                    <h5><b>Datos Usuario</b></h5>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="10" name="id_tipo_ident" required="required" id="secc1" >
                                    <option value="">TIPO DOCUMENTO</option>
                                    @foreach($tipo_identificacion as $ti)
                                    <option value="{{ $ti->id_tipo_ident }}">{{ $ti->name_tipo_ident }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="identification_number" onkeyup="this.value=Numeros(this.value);" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" tabindex="11" required="required" id="secc2"  maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="first_lastname" onkeyup="Textos(this);" placeholder="PRIMER APELLIDO" class="form-control input-lg" tabindex="6" required="required">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="second_lastname" onkeyup="Textos(this);" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" tabindex="7" required="required">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="first_name" onkeyup="Textos(this);" placeholder="PRIMER NOMBRE" class="form-control input-lg" tabindex="8" required="required">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="second_name" onkeyup="Textos(this);" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" tabindex="8" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>FECHA DE NACIMIENTO</label>
                                <input type="date" name="birthday" class="form-control input-lg" tabindex="13" required="required" id="secc3"  onchange="if('{{$date}}'<=this.value){this.value=''}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="14" name="id_sexo" required="required" id="secc4" >
                                    <option value="">GENERO</option>
                                    @foreach($genero as $sex)
                                    <option value="{{ $sex->id_sexo }}">{{ $sex->name_sexo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="text" name="address" placeholder="DIRECCIÓN" class="form-control input-lg" tabindex="6" required="required" id="secc5" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="tel" name="telephone" placeholder="TELEFONO" class="form-control input-lg" tabindex="7" required="required" id="secc6" >
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="EMAIL" class="form-control input-lg" tabindex="7" required="required" id="secc6" >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required" id="secci1" >
                                    <option value="">EPS</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="16" name="tipo_usuario" required="required" id="secci21" >
                                    <option value="">TIPO USUARIO</option>
                                    @foreach($tipo_usuario as $tpuser)
                                    <option value="{{ $tpuser->id_ambulancia }}">{{ $tpuser->alias_ambulancia }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_servicio" required="required" id="secci4" >
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
                                <thead>
                                    <tr>
                                        <th>
                                            1. ANTECEDENTES. ¿Ha tenido alguno de los siguientes antecedentes?
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Enfermedad cerebrovascular</td>
                                        <td><input type="radio" name="p1" value="1"></td>
                                        <td><input type="radio" name="p1" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Hipertensión arterial, o enfermedad cardio -vascular, infartos, enfermedad cerebrovascular</td>
                                        <td><input type="radio" name="p2" value="1"></td>
                                        <td><input type="radio" name="p2" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Diabetes</td>
                                        <td><input type="radio" name="p3" value="1"></td>
                                        <td><input type="radio" name="p3" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Enfermedades renales (riñores) o hepáticas (hígado)</td>
                                        <td><input type="radio" name="p4" value="1"></td>
                                        <td><input type="radio" name="p4" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Enfermedad Tiroidea</td>
                                        <td><input type="radio" name="p5" value="1"></td>
                                        <td><input type="radio" name="p5" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Malnutrición (obesidad o desnutrición)</td>
                                        <td><input type="radio" name="p6" value="1"></td>
                                        <td><input type="radio" name="p6" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Tabaquismo</td>
                                        <td><input type="radio" name="p7" value="1"></td>
                                        <td><input type="radio" name="p7" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Enfermedad Cardiaca</td>
                                        <td><input type="radio" name="p8" value="1"></td>
                                        <td><input type="radio" name="p8" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Enfermedades pulmonares crónicas (EPOC/ Asma)</td>
                                        <td><input type="radio" name="p9" value="1"></td>
                                        <td><input type="radio" name="p9" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Cáncer</td>
                                        <td><input type="radio" name="p10" value="1"></td>
                                        <td><input type="radio" name="p10" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Enfermedades autoinmunes, inmunosupresión, toma medicamentos inmunosupresores, VIH</td>
                                        <td><input type="radio" name="p11" value="1"></td>
                                        <td><input type="radio" name="p11" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Embarazo actualmente</td>
                                        <td><input type="radio" name="p12" value="1"></td>
                                        <td><input type="radio" name="p12" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Convive con personas mayores de 70 años o personas que trabajan en prestación asistencial en salud</td>
                                        <td><input type="radio" name="p13" value="1"></td>
                                        <td><input type="radio" name="p13" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Si lleva tratamiento médico por su condición de salud, marque Si, de lo contrario marque No</td>
                                        <td><input type="radio" name="p14" value="1"></td>
                                        <td><input type="radio" name="p14" value="0"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>
                                            2. ¿Ha tenido síntomas en los últimos 2 días?
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Fiebre cuantificada mayor a 38°C</td>
                                        <td><input type="radio" name="p15" value="1"></td>
                                        <td><input type="radio" name="p15" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Tos</td>
                                        <td><input type="radio" name="p16" value="1"></td>
                                        <td><input type="radio" name="p16" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Dificultad para respirar</td>
                                        <td><input type="radio" name="p17" value="1"></td>
                                        <td><input type="radio" name="p17" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Cansancio</td>
                                        <td><input type="radio" name="p18" value="1"></td>
                                        <td><input type="radio" name="p18" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Dolores musculares</td>
                                        <td><input type="radio" name="p19" value="1"></td>
                                        <td><input type="radio" name="p19" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Secreción nasal (moco o flema)</td>
                                        <td><input type="radio" name="p20" value="1"></td>
                                        <td><input type="radio" name="p20" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Dolor de cabeza</td>
                                        <td><input type="radio" name="p21" value="1"></td>
                                        <td><input type="radio" name="p21" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Dolor de garganta</td>
                                        <td><input type="radio" name="p22" value="1"></td>
                                        <td><input type="radio" name="p22" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Diarrea</td>
                                        <td><input type="radio" name="p23" value="1"></td>
                                        <td><input type="radio" name="p23" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Perdida del gusto</td>
                                        <td><input type="radio" name="p24" value="1"></td>
                                        <td><input type="radio" name="p24" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Perdida del olfato</td>
                                        <td><input type="radio" name="p25" value="1"></td>
                                        <td><input type="radio" name="p25" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Malestar general</td>
                                        <td><input type="radio" name="p26" value="1"></td>
                                        <td><input type="radio" name="p26" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Erupción cutánea</td>
                                        <td><input type="radio" name="p27" value="1"></td>
                                        <td><input type="radio" name="p27" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Nauseas</td>
                                        <td><input type="radio" name="p28" value="1"></td>
                                        <td><input type="radio" name="p28" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>Vomito</td>
                                        <td><input type="radio" name="p29" value="1"></td>
                                        <td><input type="radio" name="p29" value="0"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            3. Identificación de Contacto
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>¿Ha tenido contacto estrecho (menor a 2 metros por 15 minutos sin protección) con una persona con COVID-19 positivo?</td>
                                        <td><input type="radio" name="p30" value="1"></td>
                                        <td><input type="radio" name="p30" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>¿Ha tenido contacto estrecho (menor a 2 metros por 15 minutos sin protección) con una persona con síntomas respiratorios y Ud. no sabe si tiene COVID-19 positivo?</td>
                                        <td><input type="radio" name="p31" value="1"></td>
                                        <td><input type="radio" name="p31" value="0"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            4. Pruebas Diagnosticas
                                        </th>
                                        <th>
                                            Si
                                        </th>
                                        <th>
                                            No
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>¿Le han realizado prueba de COVID-19 con muestra en nariz que ha salido positiva?</td>
                                        <td><input type="radio" name="p32" value="1"></td>
                                        <td><input type="radio" name="p32" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>¿Le han realizado prueba de COVID-19 en sangre que ha salido positiva?</td>
                                        <td><input type="radio" name="p33" value="1"></td>
                                        <td><input type="radio" name="p33" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>¿Ha estado o está en aislamiento preventivo porque ha sido diagnosticado de COVID-19?</td>
                                        <td><input type="radio" name="p34" value="1"></td>
                                        <td><input type="radio" name="p34" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td>¿Ha tenido incapacidad temporal por caso asociado a COVID-19?</td>
                                        <td><input type="radio" name="p35" value="1"></td>
                                        <td><input type="radio" name="p35" value="0"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <input type="reset" class="btn btn-warning btn-block btn-lg" tabindex="14" value="LIMPIAR">
                        </div>
                        <div class="col-xs-6 col-md-6">
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
