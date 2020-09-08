@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <div class="container-fluid text-center">
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>Seguimiento</b></h1>
        </div>
        <button class="btn btn-info" data-toggle="modal" data-target="#newModal">Añadir Producto</button>
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
                        <th></th>
                        <!-- <th></th> -->
                    </tr>
                </thead>
                
                <!-- datos obtenidos mediante consulta - mostrados en la vista de la pagina -->
                    <tbody style="text-align: center;">
                        
                            <tr>
                                <td></td>
                                <td>
                                    <svg id=""></svg>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                      <input type="checkbox" checked="checked" disabled="disabled">
                                </td>
                                <td>
                                      <input type="checkbox" checked="checked" disabled="disabled">
                                </td>
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
@endsection
