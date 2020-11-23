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
            $('#s12').val('');
            $('#s10').val('');
            $('#s11').val('');
        }else{
            // console.log(data);
            $.each(data, function(index, ClassObj){
                $('#s5').val(ClassObj.primer_apellido);
                $('#s6').val(ClassObj.segundo_apellido);
                $('#s7').val(ClassObj.primer_nombre);
                $('#s8').val(ClassObj.segundo_nombre);
                $('#s3').val(ClassObj.fecha_nacimiento);
                $('#s4').val(ClassObj.id_sexo);
                $('#s10').val(ClassObj.direccion);
                $('#s11').val(ClassObj.telefono);
                $('#s12').val(ClassObj.email);
            })
        }
    });
}

</script>

<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <div class="container-fluid text-center">
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Seguimiento</b></h1>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Añadir Seguimiento</button>
        <hr>

        <div class="table-responsive" style="background: #f9f9f9;">
            <table id="table_doc" class="cell-border compact stripe" style="background: #f9f9f9; font-size: 12px;">
                <thead>
                    <tr>
                        <th>SERIAL</th>
                        <th>COD. BARRA</th>
                        <th>GRUPO</th>
                        <th>CLASE</th>
                        <th>SUBCLASE</th>
                        <th>DESCRIPCION</th>
                        <th>UND. MEDIDA</th>
                        <th>PROVEEDOR</th>
                        <th>MARCA</th>
                        <th>IVA</th>
                        <th>ACTIVO</th>
                        <th>UND. VENTA</th>
                        <th>CANT. VENTA</th>
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                        @foreach($seguimiento as $se)
                            <tr>
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
                <h3 class="modal-title">REGISTRO SEGUIMIENTO</h3>
                <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
            </div>
            
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="{{ url('gestion_seguimiento') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <h5 id="tl1"><b>DATOS DEL PACIENTE</b></h5>
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" name="id_tipo_ident" required="required" id="s1">
                                    <option value="">TIPO IDENTIFICACIÓN</option>
                                    @foreach($tipo_identificacion as $ti)
                                    <option value="{{ $ti->id_tipo_ident }}">{{ $ti->name_tipo_ident }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="identification_number" onkeyup="this.value=Numeros(this.value);" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" required="required" id="s2" maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label id="birth">FECHA DE NACIMIENTO</label>
                                <input type="date" name="birthday" class="form-control input-lg" required="required" id="s3" onchange="if('{{$date}}'<=this.value){this.value=''}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label> </label>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" name="id_sexo" required="required" id="s4">
                                    <option value="">GENERO</option>
                                    @foreach($genero as $sex)
                                    <option value="{{ $sex->id_sexo }}">{{ $sex->name_sexo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_lastname" onkeyup="Textos(this);" placeholder="PRIMER APELLIDO" class="form-control input-lg" required="required" id="s5">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_lastname" onkeyup="Textos(this);" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" id="s6">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name" onkeyup="Textos(this);" placeholder="PRIMER NOMBRE" class="form-control input-lg" required="required" id="s7">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_name" onkeyup="Textos(this);" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" id="s8">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_municipio_paciente" class="selectpicker form-control input-lg" data-style="btn-info" id="s9" required="required">
                                    <option value="">MUNICIPIO</option>
                                    @foreach($municipio_remitente as $mpio)
                                        <option value="{{ $mpio->id_municipio }}">{{ $mpio->name_municipio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="address" placeholder="DIRECCIÓN" class="form-control input-lg" id="s10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="tel" name="telefono" placeholder="TELEFONO" class="form-control input-lg" required="required" id="s11">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="EMAIL" class="form-control input-lg" id="s12">
                            </div>
                        </div>
                    </div>

                    <h5 id="tl2" style="display: none; margin-top: -6em;"><b>INFORMACION DE LA ATENCION Y SERVICIOS SOLICITADOS</b></h5>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" name="id_eps" required="required" id="si1" style="display: none;">
                                    <option value="">EPS QUE SE ENCUENTRA AFILIADO</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" name="id_servicio" required="required" id="si2" style="display: none;">
                                    <option value="">SERVICIO</option>
                                    @foreach($servicio as $ser)
                                    <option value="{{ $ser->id_servicio }}">{{ $ser->name_servicio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" name="id_via_egreso" required="required" id="si3" style="display: none;">
                                    <option value="">VIA EGRESO</option>
                                    @foreach($egreso as $e)
                                    <option value="{{ $e->id_via_egreso }}">{{ $e->descripcion_via_egreso }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label id="dare" style="display: none;">FECHA EGRESO</label>
                                <input type="date" name="fecha_egreso" class="form-control input-lg" required="required" id="si4" onchange="if('{{$date}}'<=this.value){this.value=''}" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <textarea class="form-control input-lg" name="observacion" placeholder="OBSERVACIONES" id="si5" cols="50" rows="5" style="display: none;"></textarea>
                            </div>
                        </div>
                    </div>
      
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6" id="inicio1">
                        </div>
                        <div class="col-xs-6 col-md-6" id="inicio2">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="next('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin1" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="REGRESAR" onclick="back('section1')">
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
            document.getElementById("fin1").style.display = "block";
            document.getElementById("fin2").style.display = "block";

            // Elementos Seccion1
            document.getElementById("tl1").style.display = "none";
            document.getElementById("birth").style.display = "none";

            for (let j = 1; j < 13; j++) {
                document.getElementById("s"+j).style.display = "none";    
            }

            // Elementos Seccion2
            document.getElementById("tl2").style.display = "block";
            document.getElementById("dare").style.display = "block";

            for (let i = 1; i < 6; i++) {
                document.getElementById("si"+i).style.display = "block";
            }
        }
    }

    function back(section){
        if (section === 'section1') {
            // Botones de secciones
            document.getElementById("fin1").style.display = "none";
            document.getElementById("fin2").style.display = "none";
            document.getElementById("inicio1").style.display = "block";
            document.getElementById("inicio2").style.display = "block";

            // Elementos Seccion1
            document.getElementById("tl1").style.display = "block";
            document.getElementById("birth").style.display = "block";

            for (let j = 1; j < 13; j++) {
                document.getElementById("s"+j).style.display = "block";
            }

            // Elementos Seccion2
            document.getElementById("tl2").style.display = "none";
            document.getElementById("dare").style.display = "none";

            for (let i = 1; i < 6; i++) {
                document.getElementById("si"+i).style.display = "none";
            }
        }
    }
</script>
@endsection
