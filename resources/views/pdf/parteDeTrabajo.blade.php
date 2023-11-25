<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$incidencia->numero}}</title>

    <style>
        /* Establecer el alto de la tabla al tamaño de un folio */
        #miTabla {
            width: 21.59cm;
            height: 27.94cm;
            border-collapse: collapse;
            border: 3px solid #000;
            font-size: 20px
        }

        .datostabla,
        .fechas,
        .trabajodesc {
            border: 3px solid #000;
            font-weight: bold;
            padding: 0.2cm;
            /* Ajusta este valor según tus necesidades */
        }


        .datosfechas,
        .datosincidencia,
        .descripcion {
            border: 3px solid #000;
            padding: 0.2cm;
            /* Ajusta este valor según tus necesidades */
        }


        .fechas {
            height: 0.5cm;
            width: 25%;
            /* Ancho de un folio en centímetros */
        }

        .datostabla {
            height: 1cm;
        }

        .trabajodesc {
            height: 0.5cm;
        }

        .descripcion {
            height: 9cm;
            vertical-align: top;
            /* Alineación superior */
            padding: 15px
        }
    </style>
</head>

<body>
    <div class="container mx-auto mt-8">
        <table id="miTabla" class="w-full">
            <thead>
                <tr>
                    <th colspan="4" class="trabajodesc">Incidencia Nº {{ $incidencia->numero }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="datostabla">Fecha creación:</td>
                    <td colspan="2" class="datosincidencia">{{ $incidencia->fecha }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Autor de la incidencia:</td>
                    <td colspan="2" class="datosincidencia">
                        {{ $incidencia->creador->nombre . ' ' . $incidencia->creador->primer_apellido . ' ' . $incidencia->creador->segundo_apellido }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Operario:</td>
                    <td colspan="2" class="datosincidencia">
                        {{ $incidencia->asignado->nombre . ' ' . $incidencia->asignado->primer_apellido . ' ' . $incidencia->asignado->segundo_apellido }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Estado:</td>
                    <td colspan="2" class="datosincidencia">{{ $incidencia->estado->nombre }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Ubicación:</td>
                    <td colspan="2" class="datosincidencia">{{ $incidencia->ubicacion->nombre }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Departamento:</td>
                    <td colspan="2" class="datosincidencia">{{ $incidencia->departamento->nombre }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="datostabla">Categoría:</td>
                    <td colspan="2" class="datosincidencia">{{ $incidencia->categoria->nombre }}</td>
                </tr>
                <tr>
                    <th class="trabajodesc" colspan="4">Trabajo a Realizar:</th>
                </tr>
                <tr>
                    <td colspan="4" class="descripcion">
                        <div class="h-full">
                            {{ $incidencia->descripcion }}
                        </div>
                    </td>
                </tr>
                <tr>

                    <td class="fechas">Fecha inicio:</td>
                    <td class="datosfechas">{{ $fecha_inicio }}</td>
                    <td class="fechas">Hora inicio:</td>
                    <td class="datosfechas">{{ $hora_inicio }}</td>
                </tr>
                <tr>
                    <td class="fechas">Fecha fin:</td>
                    <td class="datosfechas">{{ $fecha_fin }}</td>
                    <td class="fechas">Hora fin:</td>
                    <td class="datosfechas">{{ $hora_fin }}</td>
                </tr>
                <tr>
                    <th class="trabajodesc" colspan="4">Trabajo Realizado:</th>
                </tr>
                <tr>
                    <td colspan="4" class="descripcion">
                        <div class="h-full">{{ $trabajo_realizado }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
