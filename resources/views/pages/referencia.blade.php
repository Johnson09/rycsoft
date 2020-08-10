<script type="text/javascript">
function pad(input, length, padding) { 
  var str = input + "";
  return (length <= str.length) ? str : pad(padding+str, length, padding);
}
function actualizar(id){
    document.getElementById("form").action = "regprod/"+id;

    $.get('?id='+id, function(data) {
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
	 	})
	</script>
