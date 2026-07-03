<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Perfil</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            font-size: 16px;
        }

        .section-title{
            text-align: left;
            font-size: 18px;
            margin: 20px auto;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .align-middle {
            vertical-align: middle;
        }

        .table-pdf {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; 
            font-size: 13px;
            color: #505050;              
            border-collapse: collapse;    
            width: 100%;
        }

        .table-pdf th, 
        .table-pdf td {
            padding: 8px 12px;              
            vertical-align: middle;       
        }

        .table-pdf thead th,
        .table-pdf tfoot td {
            background-color: #555555ff;    
            color: #ffffff;
            font-weight: bold;
        }

        .table-pdf.striped tbody tr {
            background-color: #ffffff;
        }

        .table-pdf.striped tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .table-pdf.grid tbody tr {
            background-color: #ffffff;
        }

        .table-pdf.grid th,
        .table-pdf.grid td {
            border: 1px solid #c8c8c8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h4>RESUMEN DE PERFIL DEL EMPLEADO</h4>
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>

    <!-- Información General -->
    <table class="table-pdf grid">
        <thead>
            <tr>
                <th class="text-left align-middle">Empleado: [ {{$empleado->ficha}} ] - {{$empleado->nombre_empleado}} </th>
            </tr>
        </thead>
        <tbody>
            <tr>    
                <td class="text-left align-middle"><strong>Cargo:</strong> {{ $empleado->texto_cargo ?? 'No definido' }}</td>
            </tr>
            <tr>
                <td class="text-left align-middle"><strong>Gerencia:</strong> {{ $empleado->texto_gerencia ?? 'No definida' }}</td> 
            </tr>
            <tr>
                <td class="text-left align-middle"><strong>Unidad:</strong> {{ $empleado->texto_unidad ?? 'No definida' }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Nivel Educativo -->
    <div class="section-title"><h4>EDUCACIÓN</h4></div>
    <table class="table-pdf striped grid">
        <thead>
            <tr>
                <th class="text-left">NIVEL</th>
                <th class="text-left">TÍTULO</th>
                <th class="text-center">INSTITUTO</th>
                <th class="text-center">GRADUADO</th>
                <th class="text-center">ÚLTIMO NIVEL</th>
                <th class="text-center">AÑO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($educaciones as $edu)
                <tr>
                    <td class="text-left">{{ $edu->nivel_educativo }}</td>
                    <td class="text-left">{{ $edu->titulo }} @if($edu->especialidad) <br><small>{{ $edu->especialidad }}</small> @endif</td>
                    <td class="text-center">{{ $edu->instituto }}</td>
                    <td class="text-center">{{ $edu->graduado ? 'SÍ' : 'NO' }}</td>
                    <td class="text-center">{{ $edu->ultimo_nivel ? 'SÍ' : 'NO' }}</td>
                    <td class="text-center">{{ $edu->fecha_culminado }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay educación registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Experiencia Laboral Interna -->
    <div class="section-title"><h4>EXPERIENCIA LABORAL INTERNA</h4></div>
    <table class="table-pdf striped grid">
        <thead>
            <tr>
                <th class="text-left">CARGO DESEMPEÑADO</th>
                <th class="text-left">EMPRESA</th>
                <th class="text-center">DESDE</th>
                <th class="text-center">HASTA</th>
                <th class="text-center">OBSERVACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experiencias_internas as $exp)
                <tr>
                    <td class="text-left">{{ $exp->cargo_desempeñado }}</td>
                    <td class="text-left">{{ $exp->empresa }}</td>
                    <td class="text-center">{{ $exp->desde ? : '---' }} </td>
                    <td class="text-center">{{ $exp->hasta ? : 'Actualidad' }} </td>
                    <td class="text-left">{{ $exp->observacion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay experiencia laboral registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Experiencia Laboral Externa -->
    <div class="section-title"><h4>EXPERIENCIA LABORAL EXTERNA</h4></div>
    <table class="table-pdf striped grid">
        <thead>
            <tr>
                <th class="text-left">CARGO DESEMPEÑADO</th>
                <th class="text-left">EMPRESA</th>
                <th class="text-center">DESDE</th>
                <th class="text-center">HASTA</th>
                <th class="text-center">OBSERVACIÓN</th>>
            </tr>
        </thead>
        <tbody>
            @forelse($experiencias_externas as $exp)
                <tr>
                    <td class="text-left">{{ $exp->cargo_desempeñado }}</td>
                    <td class="text-left">{{ $exp->empresa }}</td>
                    <td class="text-center">{{ $exp->desde ? : '---' }} </td>
                    <td class="text-center">{{ $exp->hasta ? : 'Actualidad' }} </td>
                    <td class="text-left">{{ $exp->observacion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No hay experiencia laboral registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Nivel de Inglés -->
    <div class="section-title"><h4>NIVEL DE INGLÉS</h4></div>
    <table class="table-pdf grid">
        <thead>
            <tr>
                <th class="text-center" style="width: 10%;">INTROD. 1 </th>
                <th class="text-center" style="width: 10%;">INTROD. 2 </th>
                <th class="text-center" style="width: 10%;">BASICO BAJO </th>
                <th class="text-center" style="width: 10%;">BASICO ALTO </th>
                <th class="text-center" style="width: 10%;">INTERM. BAJO </th>
                <th class="text-center" style="width: 10%;">INTERM. ALTO </th>
                <th class="text-center" style="width: 10%;">AVANZD. BAJO </th>
                <th class="text-center" style="width: 10%;">AVANZD. ALTO </th>
            </tr>
        </thead>
        <tbody>
        @if($ingles)
            <tr>
                <td class="text-center"><strong>{{ $ingles->i1 ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->i2 ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->bb ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->ba ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->ib ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->ia ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->ab ? '[X]' : '' }}</strong></td>
                <td class="text-center"><strong>{{ $ingles->aa ? '[X]' : '' }}</strong></td>
            </tr>
        @else
            <tr>
                <td colspan="8" class="text-center">No hay nivel de inglés registrado.</td>
            </tr>
        @endif
        </tbody>
    </table>

    <!-- Cursos -->
    <div class="section-title"><h4>CAPACITACIÓN Y DESARROLLO</h4></div>
    @foreach($cursos_en_area as $area_data)
        <div class="section-title">ÁREA: {{ $area_data['area_nombre'] }}</div>
        <table class="table-pdf striped grid">
            <thead>
                <tr>
                    <th class=" text-left" style="width: 10%;">ACTIVIDAD </th>
                    <th class=" text-left" style="width: 20%;">SUBACTIVIDAD </th>
                    <th class=" text-center" style="width: 20%;">INSTITUCION Y FACILITADOR </th>
                    <th class=" text-center" style="width: 10%;">FECHA Y LUGAR </th>
                    <th class=" text-center" style="width: 10%;">DURACION </th>
                    <th class=" text-center" style="width: 10%;">ASISTENCIA </th>
                    <th class=" text-center" style="width: 20%;">OBSERVACIONES </th>
                </tr>
            </thead>
            <tbody>
                @forelse($area_data['cursos'] as $curso)
                    <tr>
                        <td class="text-left"><strong>{{ $curso->nombre_actividad }}</strong></td>
                        <td class="text-left">{{ $curso->nombre_subactividad ?? '---' }}</td>
                        <td class="text-center"><strong>{{ $curso->institucion }}</strong><br><small>{{ $curso->nombre_facilitador }}</small></td>
                        <td class="text-center">{{ $curso->fecha }}<br><small>{{ $curso->lugar }}</small></td>
                        <td class="text-center">{{ $curso->duracion }} horas</td>
                        <td class="text-center">{{ is_null($curso->asistencia) ? '---' : ( $curso->asistencia ? 'SI' : 'NO') }}</td>
                        <td class="text-left">{{ $curso->causa ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay participación en cursos de esta área.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>