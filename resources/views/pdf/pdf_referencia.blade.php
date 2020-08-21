<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{{ $text }}}</title>
        <meta charset="utf-8">

        <!-- estilo de la tabla -->
        <style>
        #principal {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            border-collapse: collapse;
            width: 100%;
        }

        #principal td, #principal th {
            border: 1px solid #ddd;
        }
        </style>

    </head>
    <body>

        <header>
            <i style="float: right; font-size: 14px;">
                Fecha y Hora de Impresion 
                <?php date_default_timezone_set('America/Bogota'); echo now(); ?>
            </i>
        </header>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <td style="width: 10%;">
                        <img src="{{ asset('public/images/logopag.png') }}" style="width: 7em;">
                    </td>
                    <td>
                        
                    </td>
                    <td style="width: 10%; text-align: center;">
                        N° ORDEN
                        {{ $orden }}
                    </td>
                </tr>
            </thead>
        </table>
    <br>
    @foreach($referencia as $ref)
        <table id="principal">
            <thead>
                <tr>
                    <td colspan="4">
                        DETALLE EMPRESA
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
                        DEPARTAMENTO
                    </th>
                    <th>
                        MUNICIPIO
                    </th>
                    <th>
                        REGIMEN
                    </th>
                    <th>
                        EMPRESA
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ $ref->name_departamento }}
                    </td>
                    <td>
                        {{ $ref->name_municipio }}
                    </td>
                    <td>
                        {{ $ref->name_regimen }}
                    </td>
                    <td>
                        {{ $ref->nombre_empresa }}
                    </td>
                </tr>
            </tbody>
        </table>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <td colspan="4">
                        DETALLE USUARIO
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
                        TIPO DOCUMENTO
                    </th>
                    <th>
                        N° DOCUMENTO
                    </th>
                    <th>
                        FECHA NACIMIENTO
                    </th>
                    <th>
                        GENERO
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ $ref->name_tipo_ident }}
                    </td>
                    <td>
                        {{ $ref->identification_number }}
                    </td>
                    <td>
                        {{ $ref->birthday }}
                    </td>
                    <td>
                        {{ $ref->name_sexo }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        PRIMER APELLIDO
                    </th>
                    <th>
                        SEGUNDO APELLIDO
                    </th>
                    <th>
                        PRIMER NOMBRE
                    </th>
                    <th>
                        SEGUNDO NOMBRE
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ $ref->first_lastname }}
                    </td>
                    <td>
                        {{ $ref->second_lastname }}
                    </td>
                    <td>
                        {{ $ref->first_name }}
                    </td>
                    <td>
                        {{ $ref->second_name }}
                    </td>
                </tr>
            </tfoot>
        </table>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <td colspan="4">
                        DETALLE SERVICIO 
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>
                        EPS
                    </th>
                    <th>
                        MEDICO REMITENTE
                    </th>
                    <th>
                        DIAGNOSTICO
                    </th>
                    <th>
                        SERVICIO
                    </th>
                </tr>
                <tr>
                    <td>
                        {{ $ref->name_eps }}
                    </td>
                    <td>
                        {{ $ref->name_doctor }}
                    </td>
                    <td>
                        {{ $ref->name_diagnostico }}
                    </td>
                    <td>
                        {{ $ref->name_servicio }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>
                        IPS REMITENTE
                    </th>
                    <th>
                        MUNICIPIO REMITENTE
                    </th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>
                        {{ $ref->name_ips }}
                    </td>
                    <td>
                        {{ $ref->municipio_rem }}
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                </tr>
            </tfoot>
        </table>
    @endforeach
    </body>
</html>
