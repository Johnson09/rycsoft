@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center text-center">
        <div class="container-fluid text-center">
            <h1 style="color: #2c53c5; margin-top: -0.8em;"><b>RYCSOFT</b></h1>
            <br>
            <img src="public/images/logopag.png" id="logo">
            <br>
            <h5>REFERENCIA Y CONTRAREFERENCIA</h5>
        </div>
    </div>
</div>
<style type="text/css">
	#logo {
		width: 35%;
		display: block;
		margin: auto;
	}
</style>
<!-- function actualizar(id_orden){
    $.get('{{ action('ReferenciaController@codeGeneration') }}?id_orden=' + id_orden, function(data) {});

    swal({
        text: 'Ingresar el código de habilitación',
        content: "input",
        button: {
            text: "Validar",
            closeModal: false,
        },
    })
    .then(codigo => {       
        if (!codigo) throw null; 
        return fetch(`{{ action('ReferenciaController@codeValidation') }}?codigo=${codigo}`);
    })
    .then(result => {
        return result.json();
    })
    .then(json => {
        const referencia = json.result[0];

        if (!referencia) {
            return swal("Código invalido");
        }else{
            swal.close();
            modalActualizar(id_orden);
        }
    })
    .catch(err => {
        if (err) {
            swal("Oh noes!", "The AJAX request failed!", "error");
        } else {
            swal.stopLoading();
            swal.close();
        }
    });
} -->
@endsection