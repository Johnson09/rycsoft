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
                $('#i2').text(ClassObj.name_municipio);
                $('#i3').text(ClassObj.name_regimen);
                $('#i4').text(ClassObj.nombre_empresa);
                $('#i5').text(ClassObj.name_tipo_ident);
                $('#i6').text(ClassObj.id_paciente);
                $('#i7').text(ClassObj.fecha_nacimiento);
                $('#i8').text(ClassObj.name_sexo);
                $('#i9').text(ClassObj.primer_apellido);
                $('#i10').text(ClassObj.segundo_apellido);
                $('#i11').text(ClassObj.primer_nombre);
                $('#i12').text(ClassObj.segundo_nombre);
                $('#i13').text(ClassObj.name_eps);
                $('#i14').text(ClassObj.name_doctor);
                $('#i15').text(ClassObj.name_diagnostico);
                $('#i16').text(ClassObj.name_servicio);
                $('#s20').val(ClassObj.id_estado);
            })
        }
    });
}
function addCup(){

    var cup = document.getElementById('secci13').value;
    var cups_des = document.getElementById('secci131').value;

    sessionStorage.setItem(cup,cups_des); //ó sessionStorage[producto]=precio

    mostrarDatos(cup);
}

function mostrarDatos(cup){

    var cups = [];
    var table = document.getElementById("myTable");
    var row = table.insertRow(0);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);

    var cups_des = sessionStorage.getItem(cup);
    cell1.innerHTML = cup;
    cell2.innerHTML = cups_des;

    for(var i=0; i<sessionStorage.length; i++){
        var c = sessionStorage.key(i);
        cups.push(c);
    }

    console.log(cups);
}

function borrarTodo() {
    for(var i=0; i<sessionStorage.length; i++){
        document.getElementById("myTable").deleteRow(i);
    }
    sessionStorage.clear(); 
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
                        <th>REMISIÓN</th>
                        <th>REG</th>
                        <th>TIPO IDEN</th>
                        <th>N° IDEN USUARIO</th>
                        <th>PRIMER APELLIDO</th>
                        <th>SEG APELLIDO</th>
                        <th>PRIMER NOMBRE</th>
                        <th>SEG NOMBRE</th>
                        <th>EAPB</th>
                        <th>FECHA NAC</th>
                        <th>EDAD</th>
                        <th>SEXO</th>
                        <th>DIAGNOSTICO CIE 10</th>
                        <th>MEDICO REMITE</th>
                        <th>SERVICIO</th>
                        <th>IPS REMITE</th>
                        <th>SERVICIO SOLICITADO</th>
                        <th>MPIO REMITE</th>
                        <th>FECHA REMISION</th>
                        <th>TIEMPO ESP DIAS</th>
                        <th>EST FINAL REM</th>
                        <th>COD APRO</th>
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
                                    @if($ref->id_estado == 2)
                                        <button onclick="modalActualizar('{{ $ref->id_orden }}')" class="btn btn-info" disabled>
                                            <span class="fa fa-pencil" aria-hidden="true"></span>
                                        </button>
                                    @else
                                        <button onclick="modalActualizar('{{ $ref->id_orden }}')" class="btn btn-info">
                                            <span class="fa fa-pencil" aria-hidden="true"></span>
                                        </button>
                                    @endif
                                </td>
                                <td>{{ $ref->id_orden }}</td>
                                <td>{{ $ref->name_regimen }}</td>
                                <td>{{ $ref->alias_tipo_ident }}</td>
                                <td>{{ $ref->id_paciente }}</td>
                                <td>{{ $ref->primer_apellido }}</td>
                                <td>{{ $ref->segundo_apellido }}</td>
                                <td>{{ $ref->primer_nombre }}</td>
                                <td>{{ $ref->segundo_nombre }}</td>
                                <td>{{ $ref->name_eps }}</td>
                                <td>{{ $ref->fecha_nacimiento }}</td>
                                <td>{{ $ref->edad }}</td>
                                <td>{{ $ref->alias_sexo }}</td>
                                <td>{{ $ref->id_diagnostico }}</td>
                                <td>{{ $ref->name_doctor }}</td>
                                <td>{{ $ref->alias_servicio }}</td>
                                <td>{{ $ref->name_ips }}</td>
                                <td>{{ $ref->name_servicio }}</td>
                                <td>{{ $ref->municipio_rem }}</td>
                                <td>{{ $ref->updated_at }}</td>
                                <td>{{ $ref->espera_dias }}</td>
                                <td>{{ $ref->descripcion }}</td>
                                <td>{{ $ref->cod_apro }}</td>
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
                    <form role="form" action="{{ url('gestion_referencia') }}" method="post" autocomplete="on" enctype="multipart/form-data">
                    @csrf

                    <h5 id="tl1"><b>INFORMACION DEL PRESTADOR</b></h5>
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
                                <span id="t1">REMISION SOFTWARE INSTITUCIONAL:</span>
                                <input type="file" name="uploadedFile1" class="form-control input-lg" required="required" id="sec3" accept=".pdf,.png,.jpg">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="t2">RESULTADO LABORATORIO: (Opcional)</span>
                                <input type="file" name="uploadedFile2" class="form-control input-lg" id="sec4" accept=".pdf,.png,.jpg">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="t3">RESULTADO RX: (Opcional)</span>
                                <input type="file" name="uploadedFile3" class="form-control input-lg" id="sec5" accept=".pdf,.png,.jpg">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="t4">FICHA EPIDEMIOLOGICA: (Opcional)</span>
                                <input type="file" name="uploadedFile4" class="form-control input-lg" id="sec6" accept=".pdf,.png,.jpg">
                            </div>
                        </div>
                    </div>

                    <h5 id="tl2" style="display: none; margin-top: -3em;"><b>DATOS DEL PACIENTE</b></h5>
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
                                <input type="text" name="identification_number" onkeyup="this.value=Numeros(this.value);" placeholder="# IDENTIFICACIÓN" class="form-control input-lg" tabindex="11" required="required" id="secc2" style="display: none;" maxlength="10">
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
                                <input type="text" name="second_lastname" onkeyup="Textos(this);" placeholder="SEGUNDO APELLIDO" class="form-control input-lg" tabindex="7" autocomplete="off"  id="secc6" style="display: none;">
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
                                <input type="text" name="second_name" onkeyup="Textos(this);" placeholder="SEGUNDO NOMBRE" class="form-control input-lg" tabindex="9" autocomplete="off"  id="secc8" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_municipio_paciente" class="selectpicker form-control input-lg" data-style="btn-info" id="secc9" required="required" style="display: none;">
                                    <option value="">MUNICIPIO</option>
                                    @foreach($municipio_remitente as $mpio)
                                        <option value="{{ $mpio->id_municipio }}">{{ $mpio->name_municipio }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="address" placeholder="DIRECCIÓN" class="form-control input-lg" tabindex="9" id="secc10" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="tel" name="telefono" placeholder="TELEFONO" class="form-control input-lg" tabindex="8" required="required" id="secc11" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="email" name="email" placeholder="EMAIL" class="form-control input-lg" tabindex="9" id="secc12" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <h5 id="tl3" style="display: none; margin-top: -9em;"><b>INFORMACION DE LA ATENCION Y SERVICIOS SOLICITADOS</b></h5>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_eps" required="required" id="secci1" style="display: none;">
                                    <option value="">EPS QUE SE ENCUENTRA AFILIADO</option>
                                    @foreach($regimen_eps as $eps)
                                    <option value="{{ $eps->id_eps }}">{{ $eps->name_eps }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <input type="text" name="name_doctor" onkeyup="Textos(this);" placeholder="MEDICO REMITENTE" class="form-control input-lg" tabindex="15" required="required" id="secci2" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_servicio" required="required" id="secci3" style="display: none;">
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
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_origen_atencion" required="required" id="secci4" style="display: none;">
                                    <option value="">ORIGEN ATENCIÓN</option>
                                    @foreach($origen as $ori)
                                    <option value="{{ $ori->id_origen_atencion }}">{{ $ori->descripcion_origen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_tipo_servicio_sol" required="required" id="secci5" style="display: none;">
                                    <option value="">SERVICIO SOLICITADO</option>
                                    @foreach($servicio_sol as $sol)
                                    <option value="{{ $sol->id_tipo_servicio_sol }}">{{ $sol->descripcion_servicio_sol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="12" name="id_prioridad_atencion" required="required" id="secci6" style="display: none;">
                                    <option value="">ATENCIÓN</option>
                                    @foreach($atencion as $ate)
                                    <option value="{{ $ate->id_prioridad_atencion }}">{{ $ate->descripcion_prioridad }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" tabindex="17" name="id_ubicacion_pte" required="required" id="secci7" style="display: none;">
                                    <option value="">UBICACION PACIENTE</option>
                                    @foreach($ubicacion as $ubi)
                                    <option value="{{ $ubi->id_ubicacion_pte }}">{{ $ubi->descripcion_ubicacion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci91.value=this.value" tabindex="16" id="secci9" style="display: none;">
                                    <option value="">CÓDIGO CUP</option>
                                    @foreach($cup as $c)
                                        <option value="{{ $c->cups }}">{{ $c->cups }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci9.value=this.value" tabindex="16" id="secci91" style="display: none;">
                                    <option value="">DESCRIPCIÓN CUP</option>
                                    @foreach($cup as $c)
                                        <option value="{{ $c->cups }}">{{ $c->descripcion_cups }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="button" onclick="addCup()" name="guardar" value="GUARDAR CUP" id="secci10" style="display: none;">
                            </div>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="button" onclick="borrarTodo()" name="borrar" value="BORRAR CUPS" id="secci11" style="display: none;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <table id="secci8" style="display: none;" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>CODIGO CUP</td>
                                            <td>DESCRIPCIÓN CUP</td>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci121.value=this.value" tabindex="16" name="id_diagnostico" required="required" id="secci12" style="display: none;">
                                    <option value="">PRINCIPAL DIAG.</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci12.value=this.value" tabindex="16" name="id_diagnostico" required="required" id="secci121" style="display: none;">
                                    <option value="">DES. DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->name_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci131.value=this.value" tabindex="16" name="id_diagnostico_1" id="secci13" style="display: none;">
                                    <option value="">RELACIONADO 1 DIAG.</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci13.value=this.value" tabindex="16" name="id_diagnostico_1" id="secci131" style="display: none;">
                                    <option value="">DES. DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->name_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci141.value=this.value" tabindex="16" name="id_diagnostico_2" id="secci14" style="display: none;">
                                    <option value="">RELACIONADO 2 DIAG.</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci14.value=this.value" tabindex="16" name="id_diagnostico_2" id="secci141" style="display: none;">
                                    <option value="">DES. DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->name_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci151.value=this.value" tabindex="16" name="id_diagnostico_3" id="secci15" style="display: none;">
                                    <option value="">RELACIONADO 3 DIAG.</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->id_diagnostico }}</option>
                                    @endforeach
                                </select>
                                <select class="selectpicker form-control input-lg" data-style="btn-info" onchange="secci15.value=this.value" tabindex="16" name="id_diagnostico_3" id="secci151" style="display: none;">
                                    <option value="">DES. DIAGNOSTICO</option>
                                    @foreach($diagnostico as $diag)
                                    <option value="{{ $diag->id_diagnostico }}">{{ $diag->name_diagnostico }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="form-group">
                                <textarea class="form-control input-lg" name="justificacion_clinica" placeholder="JUSTIFICACIÓN CLINICA" id="secci16" cols="30" rows="2" style="display: none;"></textarea>
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
                                <span id="s1">DEPARTAMENTO: <i id="i1"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s2">MUNICIPIO: <i id="i2"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="seccion1.1">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s3">REGIMEN: <i id="i3"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s4">EMPRESA: <i id="i4"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s5" style="display: none;">TIPO DOCUMENTO: <i id="i5"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s6" style="display: none;"># DOCUMENTO: <i id="i6"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s7" style="display: none;">FECHA NACIMIENTO: <i id="i7"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s8" style="display: none;">GENERO: <i id="i8"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s9" style="display: none;">PRIMER APELLIDO: <i id="i9"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s10" style="display: none;">SEGUNDO APELLIDO: <i id="i10"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s11" style="display: none;">PRIMER NOMBRE: <i id="i11"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s12" style="display: none;">SEGUNDO NOMBRE: <i id="i12"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s13" style="display: none;">EPS: <i id="i13"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s14" style="display: none;">MEDICO: <i id="i14"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s15" style="display: none;">DIAGNOSTICO: <i id="i15"></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span id="s16" style="display: none;">SERVICIO: <i id="i16"></i></span>
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
                                <select name="id_ambulancia" class="selectpicker form-control input-lg" data-style="btn-info" id="s19" required="required" style="display: none;">
                                    <option value="">TIPO AMBULANCIA</option>
                                    @foreach($ambulancia as $am)
                                    <option value="{{ $am->id_ambulancia }}">{{ $am->alias_ambulancia }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select name="id_estado" class="selectpicker form-control input-lg" data-style="btn-info" id="s20" required="required" style="display: none;">
                                    <option value="">ESTADO</option>
                                    @foreach($estado as $est)
                                    <option value="{{ $est->id_estado }}">{{ $est->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" name="cod_autorizacion" placeholder="CÓDIGO AUTORIZACIÓN" id="s21" class="form-control input-lg" style="display: none;" required="required">
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

                // Elementos Seccion1
                document.getElementById("tl1").style.display = "none";
                for (let i = 1; i < 5; i++) {
                    document.getElementById("t"+i).style.display = "none";
                    
                }
                for (let i = 1; i < 7; i++) {
                    document.getElementById("sec"+i).style.display = "none";
                    
                }

                // Elementos Seccion2
                document.getElementById("tl2").style.display = "block";
                document.getElementById("birth").style.display = "block";

                for (let j = 1; j < 13; j++) {
                    document.getElementById("secc"+j).style.display = "block";
                    
                }
            }else if (section === 'section3') {
                document.getElementById("medio1").style.display = "none";
                document.getElementById("medio2").style.display = "none";
                document.getElementById("medio11").style.display = "block";
                document.getElementById("medio21").style.display = "block";

                // Elementos Seccion2
                document.getElementById("tl2").style.display = "none";
                document.getElementById("birth").style.display = "none";

                for (let i = 1; i < 13; i++) {
                    document.getElementById("secc"+i).style.display = "none";
                    
                }

                // Elementos Seccion3
                document.getElementById("tl3").style.display = "block";
                document.getElementById("secci91").style.display = "block";

                for (let j = 1; j < 12; j++) {
                    document.getElementById("secci"+j).style.display = "block";
                }
            }else {
                document.getElementById("medio11").style.display = "none";
                document.getElementById("medio21").style.display = "none";
                document.getElementById("fin1").style.display = "block";
                document.getElementById("fin2").style.display = "block";

                // Elementos Seccion3
                document.getElementById("secci91").style.display = "none";

                for (let j = 1; j < 12; j++) {
                    document.getElementById("secci"+j).style.display = "none";
                }

                // Elementos Seccion4
                for (let j = 12; j < 16; j++) {
                    document.getElementById("secci"+j+"1").style.display = "block";
                    
                }

                for (let j = 12; j < 17; j++) {
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
                document.getElementById("tl1").style.display = "block";
                for (let i = 1; i < 5; i++) {
                    document.getElementById("t"+i).style.display = "block";
                    
                }
                for (let i = 1; i < 7; i++) {
                    document.getElementById("sec"+i).style.display = "block";
                    
                }

                // Elementos Seccion2
                document.getElementById("tl2").style.display = "none";
                document.getElementById("birth").style.display = "none";

                for (let j = 1; j < 13; j++) {
                    document.getElementById("secc"+j).style.display = "none";
                    
                }
            }else if (section === 'section2') {
                document.getElementById("medio11").style.display = "none";
                document.getElementById("medio21").style.display = "none";
                document.getElementById("medio1").style.display = "block";
                document.getElementById("medio2").style.display = "block";

                // Elementos Seccion2
                document.getElementById("tl2").style.display = "block";
                document.getElementById("birth").style.display = "block";

                for (let i = 1; i < 13; i++) {
                    document.getElementById("secc"+i).style.display = "block";
                    
                }

                // Elementos Seccion3
                document.getElementById("tl3").style.display = "none";
                document.getElementById("secci91").style.display = "none";

                for (let j = 1; j < 12; j++) {
                    document.getElementById("secci"+j).style.display = "none";
                    
                }
            }else {
                document.getElementById("fin1").style.display = "none";
                document.getElementById("fin2").style.display = "none";
                document.getElementById("medio11").style.display = "block";
                document.getElementById("medio21").style.display = "block";

                // Elementos Seccion3
                document.getElementById("secci91").style.display = "block";

                for (let i = 1; i < 12; i++) {
                    document.getElementById("secci"+i).style.display = "block";
                    
                }

                // Elementos Seccion4
                for (let j = 12; j < 16; j++) {
                    document.getElementById("secci"+j+"1").style.display = "none";
                    
                }

                for (let j = 12; j < 17; j++) {
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
                for (let j = 5; j < 13; j++) {
                    document.getElementById("s"+j).style.display = "block";
                    
                }
            }else {
                document.getElementById("med1").style.display = "none";
                document.getElementById("med2").style.display = "none";
                document.getElementById("f1").style.display = "block";
                document.getElementById("f2").style.display = "block";

                // Elementos Seccion2
                for (let i = 5; i < 13; i++) {
                    document.getElementById("s"+i).style.display = "none";
                    
                }

                // Elementos Seccion3
                for (let j = 13; j < 22; j++) {
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
                for (let j = 5; j < 13; j++) {
                    document.getElementById("s"+j).style.display = "none";
                    
                }
            }else {
                document.getElementById("f1").style.display = "none";
                document.getElementById("f2").style.display = "none";
                document.getElementById("med1").style.display = "block";
                document.getElementById("med2").style.display = "block";

                // Elementos Seccion2
                for (let i = 5; i < 13; i++) {
                    document.getElementById("s"+i).style.display = "block";
                    
                }

                // Elementos Seccion3
                for (let j = 13; j < 22; j++) {
                    document.getElementById("s"+j).style.display = "none";
                    
                }
            }
        }

	</script>
@endsection
