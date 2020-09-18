<!DOCTYPE html>
<html lang="es">
    <head>
        <title>{{ $text }}</title>
        <meta charset="utf-8">

        <!-- estilo de la tabla -->
        <style>
        #principal {
            font-family: 'Arial', sans-serif;
            font-size: 13px;
            border-collapse: collapse;
            width: 100%;
        }

        #principal thead, #principal tbody, #principal tfoot {
            border: 1px solid black;
        }

        #principal tbody td span, #principal tfoot td span{
            font-weight: bold;
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
                    <th style="width: 10%;">
                        <img src="{{ asset('public/images/escudo.png') }}" style="width: 7em;">
                    </th>
                    <th style="">
                        <p>
                            MINISTERIO DE LA PROTECCION SOCIAL
                        </p>
                        <p>
                            SOLICITUD DE AUTORIZACION DE SERVICIOS DE SALUD
                        </p>
                        <p>
                            NUMERO DE SOLICITUD: {{ $orden }} --- Fecha:  {{ $array[0] }}  Hora:   {{ $array[1] }}
                        </p>
                    </th>
                    <th style="width: 10%;">
                        <img src="{{ asset('public/images/HDN LOGO.png') }}" style="width: 7em;">
                    </th>
                </tr>
            </thead>
        </table>
    <br>
    @foreach($referencia as $ref)
        <table id="principal">
            <thead>
                <tr>
                    <th colspan="3">
                        INFORMACION DEL PRESTADOR (Solicitante)
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <span>Nombre:</span> {{ $ref->nombre_empresa }}
                    </td>
                    <td>
                        <span>NIT:</span> {{ $ref->nit_empresa }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Código:</span> {{ $ref->cod_hab_empresa }}
                    </td>
                    <td colspan="2">
                        <span>Dirección del prestador:</span> {{ $ref->direccion }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Teléfono:</span> {{ $ref->telefono }}
                    </td>
                    <td>
                        <span>Departamento:</span> {{ $ref->name_departamento }}
                    </td>
                    <td>
                        <span>Municipio:</span> {{ $ref->name_municipio }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>ENTIDAD A LA QUE SE LE SOLICITA (Pagador):</span> {{ $ref->name_eps }}
                    </td>
                    <td>
                        <span>Código:</span>
                    </td>
                </tr>
            </tbody>
        </table>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <th colspan="4">
                        DATOS DEL PACIENTE
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span>1er Apellido:</span> {{ $ref->primer_apellido }}
                    </td>
                    <td>
                        <span>2do Apellido:</span> {{ $ref->segundo_apellido }}
                    </td>
                    <td>
                        <span>1er Nombre:</span> {{ $ref->primer_nombre }}
                    </td>
                    <td>
                        <span>2do Nombre:</span> {{ $ref->segundo_nombre }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Tipo de documento:</span> {{ $ref->name_tipo_ident }}
                    </td>
                    <td colspan="2">
                        <span>Numero de documento de identificación:</span> {{ $ref->id_paciente }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Fecha de nacimiento:</span> {{ $ref->fecha_nacimiento }}
                    </td>
                    <td colspan="2">
                        <span>Teléfono:</span> {{ $ref->tel_paciente }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span>Dirección de residencia habitual:</span> {{ $ref->dir_paciente }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Departamento:</span> {{ $ref->dep_paciente }}
                    </td>
                    <td colspan="2">
                        <span>Municipio:</span> {{ $ref->mun_paciente }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span>Correo electronico:</span> {{ $ref->email }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <span>Cobertura en salud:</span> {{ $ref->name_regimen }}
                    </td>
                </tr>
            </tbody>
        </table>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <th colspan="3">
                        INFORMACION DE LA ATENCION Y SERVICIOS SOLICITADOS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3">
                        <span>Origen de la atención:</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Tipo de servicios solicitados:</span>
                    </td>
                    <td>
                        <span>Prioridad de la atención:</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>Ubicación del paciente al momento de la solicitud de autorización:</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Servicio:</span>
                    </td>
                    <td>
                        <span>Cama:</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>Manejo integral segun guia de:</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Código CUPS:</span>
                    </td>
                    <td>
                        <span>Cantidad:</span>
                    </td>
                    <td>
                        <span>Descripción:</span>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <span>Justificación clinica:</span>
                    </td>
                    <td colspan="2">
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Impresión Diagnóstica:</span>
                    </td>
                    <td>
                        <span>Código CIE10:</span>
                    </td>
                    <td>
                        <span>Descripción
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnostico principal:</span>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnostico Relacionado 1:</span>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnostico Relacionado 2:</span>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Diagnostico Relacionado 3:</span>
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        
                    </td>
                </tr>
            </tfoot>
        </table>
    <br>
        <table id="principal">
            <thead>
                <tr>
                    <th colspan="2">
                        INFORMACION DE LA PERSONA QUE SOLICITA
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">
                        <span>Nombre de quien solicita:</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Cargo o actividad:</span>
                    </td>
                    <td>
                        <span>Teléfono:</span>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
    </body>
</html>
