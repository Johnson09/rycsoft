<script type="text/javascript">

function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
}

function actualizar(id_orden){
    document.getElementById("form").action = "gestion_referencia/"+id_orden;

    for (let j = 1; j < 19; j++) {
        $('#s'+j).val("");
    }

    actBack();
    actBack('section1');

    $.get('{{ action('ReferenciaController@getReferencia') }}?id_orden=' + id_orden, function(data) {

        if (data == "") {
            console.log('error');
        }else{
            // console.log(data);
            $.each(data, function(index, ClassObj){
                $('#s1').val(ClassObj.name_departamento);
                $('#s2').val(ClassObj.name_municipio);
                $('#s3').val(ClassObj.name_regimen);
                $('#s4').val(ClassObj.nombre_empresa);
                $('#s5').val(ClassObj.name_tipo_ident);
                $('#s6').val(ClassObj.identification_number);
                $('#s7').val(ClassObj.birthday);
                $('#s8').val(ClassObj.name_sexo);
                $('#s9').val(ClassObj.first_lastname);
                $('#s10').val(ClassObj.second_lastname);
                $('#s11').val(ClassObj.first_name);
                $('#s12').val(ClassObj.second_name);
                $('#s13').val(ClassObj.name_eps);
                $('#s14').val(ClassObj.name_doctor);
                $('#s15').val(ClassObj.name_diagnostico);
                $('#s16').val(ClassObj.name_servicio);
                $('#s19').val(ClassObj.id_estado);
            })
        }
    });
}
</script>
<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <div class="container-fluid text-center">
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Referencia y Contrareferencia</b></h1>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Añadir Referencia</button>
        <hr>

        <div class="table-responsive" style="background: #f9f9f9;">
            <table id="table_doc" class="cell-border compact stripe" style="background: #f9f9f9; font-size: 12px;">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>ORDEN</th>
                        <th>DEPT</th>
                        <th>MPIO</th>
                        <th>REG</th>
                        <th>NIT PREST SERV SALUD</th>
                        <th>COD HAB PRESTADOR</th>
                        <th>PRIMER APELLIDO</th>
                        <th>SEG APELLIDO</th>
                        <th>PRIMER NOMBRE</th>
                        <th>SEG NOMBRE</th>
                        <th>TIPO IDEN</th>
                        <th>N° IDEN USUARIO</th>
                        <th>EAPB</th>
                        <th>FECHA NAC</th>
                        <th>EDAD</th>
                        <th>SEXO</th>
                        <th>DIAGNOSTICO CIE 10</th>
                        <th>NOMBRE DIAG</th>
                        <th>MEDICO REMITE</th>
                        <th>SERVICIO</th>
                        <th>IPS REMITE</th>
                        <th>SERVICIO SOLICITADO</th>
                        <th>MPIO REMITE</th>
                        <th>FECHA NOT REM EPS AA/MM/DD</th>
                        <th>FECHA REMISION</th>
                        <th>TIEMPO ESP DIAS</th>
                        <th>HORA NOT REM (fecha y hora)</th>
                        <th>HORA ASIG SITIO REM</th>
                        <th>TIEMPO ESP HORAS</th>
                        <th>FECHA CANCEL REF</th>
                        <!-- <th>N° VECES RECHADAS</th> -->
                        <th>EST FINAL REM</th>
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                        @foreach($referencias as $ref)
                            <tr>
                                <td>
                                    <a class="btn btn-secondary" href="{{ action('ReferenciaController@getPdf', $ref->id_orden) }}" target="_blank">
                                        <span class="fa fa-file-pdf-o" aria-hidden="true"></span>
                                    </a>
                                </td>
                                <td>
                                    <button onclick="actualizar('{{ $ref->id_orden }}')" class="btn btn-info" data-toggle="modal" data-target="#actModal">
                                        <span class="fa fa-pencil" aria-hidden="true"></span>
                                    </button>
                                </td>
                                <td>{{ $ref->id_orden }}</td>
                                <td>{{ $ref->name_departamento }}</td>
                                <td>{{ $ref->name_municipio }}</td>
                                <td>{{ $ref->name_regimen }}</td>
                                <td>{{ $ref->nit_empresa }}</td>
                                <td>{{ $ref->cod_hab_empresa }}</td>
                                <td>{{ $ref->first_lastname }}</td>
                                <td>{{ $ref->second_lastname }}</td>
                                <td>{{ $ref->first_name }}</td>
                                <td>{{ $ref->second_name }}</td>
                                <td>{{ $ref->alias_tipo_ident }}</td>
                                <td>{{ $ref->identification_number }}</td>
                                <td>{{ $ref->name_eps }}</td>
                                <td>{{ $ref->birthday }}</td>
                                <td>{{ $ref->edad }}</td>
                                <td>{{ $ref->alias_sexo }}</td>
                                <td>{{ $ref->id_diagnostico }}</td>
                                <td>{{ $ref->name_diagnostico }}</td>
                                <td>{{ $ref->name_doctor }}</td>
                                <td>{{ $ref->alias_servicio }}</td>
                                <td>{{ $ref->name_ips }}</td>
                                <td>{{ $ref->name_servicio }}</td>
                                <td>{{ $ref->municipio_rem }}</td>
                                <td>{{ $ref->created_at }}</td>
                                <td>{{ $ref->updated_at }}</td>
                                <td>{{ $ref->espera_dias }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ $ref->espera_horas }}</td>
                                <td></td>
                                <!-- <td></td> -->
                                <td>{{ $ref->descripcion }}</td>
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
                <h3 class="modal-title">REGISTRO REFERENCIA</h3>
                <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
            </div>
            
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="{{ url('gestion_referencia') }}" method="post" autocomplete="on">
                    @csrf

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="3" name="id_regimen" required="required" id="sec1">
                                    <option value="">REGIMEN</option>
                                    @foreach($regimen as $reg)
                                    <option value="{{ $reg->id_regimen }}">{{ $reg->name_regimen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                @foreach($empresa as $emp)
                                    <input type="text" name="id_empresa" class="form-control input-lg" required="required" value="{{ $emp->id_empresa }}" style="display: none;">
                                    <input type="text" name="nombre_empresa" placeholder="EMPRESA" disabled class="form-control input-lg" tabindex="4" required="required" id="sec2" value="{{ $emp->nombre_empresa }}">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="10" name="id_tipo_ident" required="required" id="secc1" style="display: none;">
                                    <option value="">TIPO IDENTIFICACIÓN</option>
                                    @foreach($tipo_identificacion as $ti)
                                    <option value="{{ $ti->id_tipo_ident }}">{{ $ti->name_tipo_ident }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="identification_number" onkeyup="this.value=Numeros(this.value);" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" tabindex="11" required="required" id="secc2" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label id="birth" style="display: none;">FECHA DE NACIMIENTO</label>
                                <input type="date" name="birthday" class="form-control input-lg" tabindex="13" required="required" id="secc3" style="display: none;" onchange="if('{{$date}}'<=this.value){this.value=''}">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label> </label>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="14" name="id_sexo" required="required" id="secc4" style="display: none;">
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
                                <input type="text" name="first_lastname" onkeyup="Textos(this);" placeholder="PRIMER APELLIDO" class="form-control input-lg" tabindex="6" required="required" autocomplete="off"  id="secc5" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_lastname" onkeyup="Textos(this);" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" tabindex="7" required="required" autocomplete="off"  id="secc6" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name" onkeyup="Textos(this);" placeholder="PRIMER NOMBRE" class="form-control input-lg" tabindex="8" required="required" autocomplete="off"  id="secc7" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_name" onkeyup="Textos(this);" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" tabindex="9" required="required" autocomplete="off"  id="secc8" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required" id="secci1" style="display: none;">
                                    <option value="">EPS QUE SE ENCUENTRA AFILIADO</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="name_doctor" onkeyup="Textos(this);" placeholder="MEDICO REMITENTE" class="form-control input-lg" tabindex="15" required="required" id="secci3" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci21.value=this.value" tabindex="16" name="id_diagnostico" required="required" id="secci2" style="display: none;">
                                    <option value="">COD DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci2.value=this.value" tabindex="16" name="id_diagnostico" required="required" id="secci21" style="display: none;">
                                    <option value="">DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->name_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_servicio" required="required" id="secci4" style="display: none;">
                                    <option value="">SERVICIO</option>
                                    @foreach($servicio as $ser)
                                    <option value="{{ $ser->id_servicio }}">{{ $ser->name_servicio }}</option>
                                    @endforeach
                                </select>
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
                        <div class="col-xs-6 col-md-6" id="medio1" style="display: none;">
                            <input type="button" class="btn btn-info btn-block btn-lg" tabindex="20" value="REGRESAR" onclick="back('section1')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="medio2" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="next('section3')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="fin1" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="REGRESAR" onclick="back('section2')">
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

<!-- Modal de actualizacion de referencia -->
<div id="actModal" class="modal fade">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title">ACTUALIZAR REFERENCIA</h3>
                <span class="close" style="font-size: medium">FECHA ACTUAL: {{ $date }}</span>
            </div>
            
            <hr>
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="#" method="post" id="form">
                    @method('PATCH')
                    @csrf
                    
                    <input type="text" name="id_user" class="form-control input-lg" required="required" value="{{ $set }}" style="display: none;">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s1" class="form-control input-lg" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s2" class="form-control input-lg" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="seccion1.1">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s3" class="form-control input-lg" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s4" class="form-control input-lg" disabled>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s5" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s6" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label id="bir" style="display: none;">FECHA DE NACIMIENTO</label>
                                <input type="text" id="s7" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label> </label>
                                <input type="text" id="s8" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s9" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s10" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s11" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s12" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s13" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s14" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s15" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" id="s16" class="form-control input-lg" style="display: none;" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_ips" class="selectpicker form-control input-lg" data-style="btn-info" id="s17" required="required" style="display: none;">
                                    <option value="">IPS REMITENTE</option>
                                    @foreach($regimen_ips as $ips)
                                    <option value="{{ $ips->id_ips }}">{{ $ips->name_ips }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_municipio_rem" class="selectpicker form-control input-lg" data-style="btn-info" id="s18" required="required" style="display: none;">
                                    <option value="">MUNICIPIO REMITENTE</option>
                                    @foreach($municipio_remitente as $mpio)
                                    <option value="{{ $mpio->id_municipio }}">{{ $mpio->name_municipio }}</option>
                                    @endforeach
                                </select>
                                
                                <script type="text/javascript">
                                    $('#s17').on('change', function(e){
                                        var id_ips = e.target.value;
                                        $.get('{{ action('MunicipioController@getMunicipioIps') }}?id_ips=' + id_ips, function(data) {

                                            if (data == "") {
                                                console.log('Error, no hay datos. Revisa la consulta');
                                            }else{
                                                $.each(data, function(index, ClassObj){
                                                    $('#s18').val(ClassObj.id_municipio);
                                                })
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_estado" class="selectpicker form-control input-lg" data-style="btn-info" id="s19" required="required" style="display: none;">
                                    <option value="">ESTADO</option>
                                    @foreach($estado as $est)
                                    <option value="{{ $est->id_estado }}">{{ $est->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>
      
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6" id="ini1">
                        </div>
                        <div class="col-xs-6 col-md-6" id="ini2">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="actNext('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="med1" style="display: none;">
                            <input type="button" class="btn btn-info btn-block btn-lg" tabindex="20" value="REGRESAR" onclick="actBack('section1')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="med2" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="SIGUIENTE" onclick="actNext('section3')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="f1" style="display: none;">
                            <input type="button" class="btn btn-warning btn-block btn-lg" tabindex="14" value="REGRESAR" onclick="actBack('section2')">
                        </div>
                        <div class="col-xs-6 col-md-6" id="f2" style="display: none;">
                            <input type="submit" class="btn btn-info btn-block btn-lg" tabindex="20" value="ACTUALIZAR REGISTRO">
                        </div>
                    </div>
                    </form>
                    <!-- Fin del formulario -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Final del modal de actualizar de referencia -->

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
            var filtro = 'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ';//Caracteres validos
            
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

                // Elementos Seccion1
                for (let i = 1; i < 3; i++) {
                    document.getElementById("sec"+i).style.display = "none";
                    
                }

                // Elementos Seccion2
                document.getElementById("birth").style.display = "block";

                for (let j = 1; j < 9; j++) {
                    document.getElementById("secc"+j).style.display = "block";
                    
                }
            }else {
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("fin1").style.display = "block";
                document.getElementById("fin2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("birth").style.display = "none";

                for (let i = 1; i < 9; i++) {
                    document.getElementById("secc"+i).style.display = "none";
                    
                }

                // Elementos Seccion3
                document.getElementById("secci21").style.display = "block";

                for (let j = 1; j < 5; j++) {
                    document.getElementById("secci"+j).style.display = "block";
                    
                }
            }
        }
        function back(section){
            if (section === 'section1') {
                // Botones de secciones
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("inicio1").style.display = "block";
                document.getElementById("inicio2").style.display = "block";

                // Elementos Seccion1
                for (let i = 1; i < 3; i++) {
                    document.getElementById("sec"+i).style.display = "block";
                    
                }

                // Elementos Seccion2
                document.getElementById("birth").style.display = "none";

                for (let j = 1; j < 9; j++) {
                    document.getElementById("secc"+j).style.display = "none";
                    
                }
            }else {
                document.getElementById("fin1").style.display = "none";
                document.getElementById("fin2").style.display = "none";
                document.getElementById("medio1").style.display = "block";
                document.getElementById("medio2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("birth").style.display = "block";

                for (let i = 1; i < 9; i++) {
                    document.getElementById("secc"+i).style.display = "block";
                    
                }

                // Elementos Seccion3
                document.getElementById("secci21").style.display = "none";

                for (let j = 1; j < 5; j++) {
                    document.getElementById("secci"+j).style.display = "none";
                    
                }
            }
        }

        function actNext(section){
            // console.log(section);
            if (section === 'section2') {
                // Botones de secciones
                document.getElementById("ini1").style.display = "none";
                document.getElementById("ini2").style.display = "none";
                document.getElementById("med1").style.display = "block";
                document.getElementById("med2").style.display = "block";

                // Elementos Seccion1
                for (let i = 1; i < 5; i++) {
                    document.getElementById("s"+i).style.display = "none";
                    
                }

                // Elementos Seccion2
                document.getElementById("bir").style.display = "block";

                for (let j = 5; j < 13; j++) {
                    document.getElementById("s"+j).style.display = "block";
                    
                }
            }else {
                document.getElementById("med1").style.display = "none";
                document.getElementById("med2").style.display = "none";
                document.getElementById("f1").style.display = "block";
                document.getElementById("f2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("bir").style.display = "none";

                for (let i = 5; i < 13; i++) {
                    document.getElementById("s"+i).style.display = "none";
                    
                }

                // Elementos Seccion3
                for (let j = 13; j < 20; j++) {
                    document.getElementById("s"+j).style.display = "block";
                    
                }
            }
        }
        function actBack(section){
            if (section === 'section1') {
                // Botones de secciones
                document.getElementById("med1").style.display = "none";
                document.getElementById("med2").style.display = "none";
                document.getElementById("ini1").style.display = "block";
                document.getElementById("ini2").style.display = "block";

                // Elementos Seccion1
                for (let i = 1; i < 5; i++) {
                    document.getElementById("s"+i).style.display = "block";
                    
                }

                // Elementos Seccion2
                document.getElementById("bir").style.display = "none";

                for (let j = 5; j < 13; j++) {
                    document.getElementById("s"+j).style.display = "none";
                    
                }
            }else {
                document.getElementById("f1").style.display = "none";
                document.getElementById("f2").style.display = "none";
                document.getElementById("med1").style.display = "block";
                document.getElementById("med2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("bir").style.display = "block";

                for (let i = 5; i < 13; i++) {
                    document.getElementById("s"+i).style.display = "block";
                    
                }

                // Elementos Seccion3
                for (let j = 13; j < 20; j++) {
                    document.getElementById("s"+j).style.display = "none";
                    
                }
            }
        }

	</script>
