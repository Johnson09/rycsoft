<script type="text/javascript">

function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
}

function actualizar(){
    document.getElementById("form").action = "regprod/";

    $.get('=', function(data) {
        $('#cod').empty();
        $('#bar').empty();
        $('#des').empty();
        $('#cuv').empty();

        $.each(data, function(index, EmpObj){

            $('#cod').val(EmpObj.id_producto);
            $('#bar').val(EmpObj.cod_barras);
            $('#gru').val(EmpObj.id_grupo);

            $.get('?id=' + EmpObj.id_grupo, function(data) {
                    // console.log(data);
                $('#cla').empty();

                if (data == "") {
                    $('#cla').append("<option value=''>Clase</option>");
                }else{
                    $('#cla').append("<option value=''>Clase</option>");
                    $.each(data, function(index, ClassObj){
                        $('#cla').append("<option value='"+ClassObj.id_clase+"'>"+ClassObj.descripcion+"</option>");
                            // $('#ciudad').selectpicker("refresh");
                    })
                }
                $('#cla').val(EmpObj.id_clase);
            });

            $.get('?id=' + EmpObj.id_clase, function(data) {
                    // console.log(data);
                $('#sub').empty();

                if (data == "") {
                    $('#sub').append("<option value=''>Subclase</option>");
                }else{
                    $('#sub').append("<option value=''>Subclase</option>");
                    $.each(data, function(index, ClassObj){
                        $('#sub').append("<option value='"+ClassObj.id_subclase+"'>"+ClassObj.descripcion+"</option>");
                            // $('#ciudad').selectpicker("refresh");
                    })
                }
                $('#sub').val(EmpObj.id_subclase);
            });

            $('#des').val(EmpObj.descripcion);
            $('#und').val(EmpObj.id_und_med);
            $('#pro').val(EmpObj.id_proveedor);
            $('#mar').val(EmpObj.id_marca);
            $('#iva').val(EmpObj.sw_iva);
            $('#est').val(EmpObj.sw_estado);
            $('#ven').val(EmpObj.und_venta);
            $('#cuv').val(EmpObj.cant_und_venta);
        
        })
    })
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
                        <th>N° VECES RECHADAS</th>
                        <th>EST FINAL REM</th>
                        <th></th>
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                        
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
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <button onclick="actualizar('')" class="btn btn-info" data-toggle="modal" data-target="#actModal">Actualizar</button>
                                </td>
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
        <div class="modal-content" style="background:;">
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Formulario de registro de referencia -->
                    <form role="form" action="{{ url('gestion_referencia') }}" method="post">
                    @csrf
                        <h2>REGISTRO</h2>
                        <h3>REFERENCIA</h3>
                        <hr>
      
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="1" id="dept" name="id_departamento" required="required">
                                    <option value="">DEPARTAMENTO</option>
                                    @foreach($departamento as $dept)
                                    <option value="{{ $dept->id_departamento }}">{{ $dept->name_departamento }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="2" id="mpio" name="id_municipio" required="required">
                                    <option value="">MUNICIPIO</option>
                                </select>
                                <script type="text/javascript">
                                    $('#dept').on('change', function(e){
                                        var dept = e.target.value;
                                        $.get('{{ action('MunicipioController@getMunicipios') }}?id_dept=' + dept, function(data) {
                                            // console.log(data);
                                            $('#mpio').empty();

                                            if (data == "") {
                                                $('#mpio').append("<option value=''>MUNICIPIO</option>");
                                            }else{
                                                $('#mpio').append("<option value=''>MUNICIPIO</option>");
                                                $.each(data, function(index, ClassObj){
                                                    $('#mpio').append("<option value='"+ClassObj.id_municipio+"'>"+ClassObj.name_municipio+"</option>");
                                                    // $('#ciudad').selectpicker("refresh");
                                                })
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="seccion1.1">
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
                                <input type="text" name="id_empresa" placeholder="EMPRESA" disabled class="form-control input-lg" tabindex="4" required="required" id="sec2">
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="nit_prestador_servic" placeholder="NIT PRESTADOR SERVICIO" class="form-control input-lg" tabindex="4" required="required">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="cod_hab_prestador" placeholder="CODIGO HABILITACIÓN PRESTADOR" class="form-control input-lg" tabindex="5" required="required">
                            </div>
                        </div>
                    </div> -->

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
                                <input type="text" name="birthday" placeholder="FECHA DE NACIMIENTO" class="datepicker form-control input-lg" tabindex="13" required="required" id="secc3" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
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
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="15" name="id_diagnostico" required="required" id="secci2" style="display: none;">
                                    <option value="">CODIGO DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="name_doctor" placeholder="MEDICO REMITENTE" class="form-control input-lg" tabindex="16" required="required" id="secci3" style="display: none;">
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

                    <div class="row" id="seccion3.2" style="display: none;">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="18" name="id_ips" required="required" id="secci5" style="display: none;">
                                    <option value="">IPS REMITENTE</option>
                                    @foreach($regimen_ips as $ips)
                                    <option value="{{ $ips->id_ips }}">{{ $ips->name_ips }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="19" name="id_municipio_rem" required="required" id="secci6" style="display: none;">
                                    <option value="">MUNICIPIO REMITENTE</option>
                                    @foreach($municipio_remitente as $mpio)
                                    <option value="{{ $mpio->id_municipio }}">{{ $mpio->name_municipio }}</option>
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

<!-- Inicio modal actualizacion referencia -->
<div id="actModal" class="modal fade">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content" style="background:;">
            <div class="modal-body" style="font-size: 14px">
                <div style="text-align: center;">
                    <!-- Inicio formulario de actualizacion de referencia -->
                    <form role="form" action="" method="post">
                    @csrf
                        <h2>ACTUALIZACIÓN</h2>
                        <h3>REFERENCIA</h3>
                        <hr>
      
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="1" name="id_departamento" required="required">
                                    <option value="">DEPARTAMENTO</option>
                                    @foreach($departamento as $dept)
                                    <option value="{{ $dept->id_departamento }}">{{ $dept->name_departamento }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="2" name="id_municipio" required="required">
                                    <option value="">MUNICIPIO</option>
                                </select>
                                <script type="text/javascript">
                                    $('#dept').on('change', function(e){
                                        var dept = e.target.value;
                                        $.get('{{ action('MunicipioController@getMunicipios') }}?id_dept=' + dept, function(data) {
                                            // console.log(data);
                                            $('#mpio').empty();

                                            if (data == "") {
                                                $('#mpio').append("<option value=''>MUNICIPIO</option>");
                                            }else{
                                                $('#mpio').append("<option value=''>MUNICIPIO</option>");
                                                $.each(data, function(index, ClassObj){
                                                    $('#mpio').append("<option value='"+ClassObj.id_municipio+"'>"+ClassObj.name_municipio+"</option>");
                                                    // $('#ciudad').selectpicker("refresh");
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
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="3" name="id_regimen" required="required">
                                    <option value="">REGIMEN</option>
                                    @foreach($regimen as $reg)
                                    <option value="{{ $reg->id_regimen }}">{{ $reg->name_regimen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="nit_prestador_servic" placeholder="NIT PRESTADOR SERVICIO" class="form-control input-lg" tabindex="4" required="required">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="cod_hab_prestador" placeholder="CODIGO HABILITACIÓN PRESTADOR" class="form-control input-lg" tabindex="5" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_lastname" placeholder="PRIMER APELLIDO" class="form-control input-lg" tabindex="6" required="required">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_lastname" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" tabindex="7" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="first_name" placeholder="PRIMER NOMBRE" class="form-control input-lg" tabindex="8" required="required">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="second_name" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" tabindex="9" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="10" name="id_tipo_ident" required="required">
                                    <option value="">TIPO IDENTIFICACIÓN</option>
                                    @foreach($tipo_identificacion as $ti)
                                    <option value="{{ $ti->id_tipo_ident }}">{{ $ti->alias_tipo_ident }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="identification_number" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" tabindex="11" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required">
                                    <option value="">EPS QUE SE ENCUENTRA AFILIADO</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>FECHA DE NACIMIENTO</label>
                                <input type="date" name="birthday" class="form-control input-lg" tabindex="13" required="required">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="14" name="id_sexo" required="required">
                                    <option value="">GENERO</option>
                                    @foreach($genero as $sex)
                                    <option value="{{ $sex->id_sexo }}">{{ $sex->alias_sexo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="15" name="id_diagnostico" required="required">
                                    <option value="">CODIGO DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="name_doctor" placeholder="MEDICO REMITENTE" class="form-control input-lg" tabindex="16" required="required">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_servicio" required="required">
                                    <option value="">SERVICIO</option>
                                    @foreach($servicio as $ser)
                                    <option value="{{ $ser->id_servicio }}">{{ $ser->name_servicio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="18" name="id_ips" required="required">
                                    <option value="">IPS REMITENTE</option>
                                    @foreach($regimen_ips as $ips)
                                    <option value="{{ $ips->id_ips }}">{{ $ips->name_ips }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="19" name="id_municipio_rem" required="required">
                                    <option value="">MUNICIPIO REMITENTE</option>
                                    @foreach($municipio_remitente as $mpio)
                                    <option value="{{ $mpio->id_municipio }}">{{ $mpio->name_municipio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
      
                    <hr>
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                        <input type="submit" class="btn btn-info btn-block btn-lg" title="Guardar" tabindex="20" value="FINALIZAR REGISTRO">
                        </div>
                        <div class="col-xs-6 col-md-6">
                        <!-- <input type="reset" value="Restaurar" class="btn btn-warning btn-block btn-lg" tabindex="14"> -->
                        </div>
                    </div>
                    </form>
                    <!-- Final formulario actualizacion de referencia -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Final modal de actualizacion de referencia -->

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
  <!-- Files required Datepicker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript">

	 	$(".input").focus(function() {
	 		$(this).parent().addClass("focus");
        });

        $(function() {
            $(".datepicker").datepicker();
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
                document.getElementById("dept").style.display = "none";
                document.getElementById("mpio").style.display = "none";

                for (let i = 1; i < 3; i++) {
                    document.getElementById("sec"+i).style.display = "none";
                    
                }

                // Elementos Seccion2
                for (let j = 1; j < 9; j++) {
                    document.getElementById("secc"+j).style.display = "block";
                    
                }
            }else {
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("fin1").style.display = "block";
                document.getElementById("fin2").style.display = "block";

                // Elementos Seccion2
                for (let i = 1; i < 9; i++) {
                    document.getElementById("secc"+i).style.display = "none";
                    
                }

                // Elementos Seccion3
                for (let j = 1; j < 7; j++) {
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
                document.getElementById("dept").style.display = "block";
                document.getElementById("mpio").style.display = "block";

                for (let i = 1; i < 3; i++) {
                    document.getElementById("sec"+i).style.display = "block";
                    
                }

                // Elementos Seccion2
                for (let j = 1; j < 9; j++) {
                    document.getElementById("secc"+j).style.display = "none";
                    
                }
            }else {
                document.getElementById("fin1").style.display = "none";
                document.getElementById("fin2").style.display = "none";
                document.getElementById("medio1").style.display = "block";
                document.getElementById("medio2").style.display = "block";

                // Elementos Seccion2
                for (let i = 1; i < 9; i++) {
                    document.getElementById("secc"+i).style.display = "block";
                    
                }

                // Elementos Seccion3
                for (let j = 1; j < 7; j++) {
                    document.getElementById("secci"+j).style.display = "none";
                    
                }
            }
        }
	</script>
