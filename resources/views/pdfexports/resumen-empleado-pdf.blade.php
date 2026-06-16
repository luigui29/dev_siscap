<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen de Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #5DADE2;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #2C3E50;
            text-transform: uppercase;
        }
        .section-title {
            background-color: #64748B;
            color: #FFF;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .info-box {
            border: 1px solid #CCC;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #F8F9FA;
        }
        .info-box p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            border: 1px solid #DDD;
            padding: 6px;
            text-align: left;
            font-size: 11px;
        }
        table th {
            background-color: #E9ECEF;
            color: #495057;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            color: #FFF;
            font-size: 10px;
            font-weight: bold;
        }
        .bg-success { background-color: #28A745; }
        .bg-danger { background-color: #DC3545; }
        .bg-warning { background-color: #FFC107; color: #333; }
        .small-title {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 5px;
            font-size: 12px;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Resumen de Perfil del Empleado</h2>
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>

    <!-- Información General -->
    <div class="section-title">Información General</div>
    <div class="info-box">
        <p><strong>Nombre Completo:</strong> {{ $empleado->nombre_empleado }}</p>
        <p><strong>Ficha:</strong> {{ $empleado->ficha }}</p>
        <p><strong>Cargo:</strong> {{ $empleado->texto_cargo ?? 'No definido' }}</p>
        <p><strong>Gerencia:</strong> {{ $empleado->texto_gerencia ?? 'No definida' }}</p>
        <p><strong>Unidad:</strong> {{ $empleado->texto_unidad ?? 'No definida' }}</p>
    </div>

    <!-- Desarrollo Académico -->
    <div class="section-title">Nivel Educativo</div>
    <table>
        <thead>
            <tr>
                <th>NIVEL DE EDUCACIÓN</th>
                <th>TÍTULO / CARRERA</th>
                <th>INSTITUTO</th>
                <th class="text-center">GRADUADO</th>
                <th class="text-center">ÚLTIMO NIVEL</th>
                <th class="text-center">AÑO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($educaciones as $edu)
                <tr>
                    <td>{{ $edu->nivel_educativo }}</td>
                    <td>{{ $edu->titulo }} @if($edu->especialidad) <br><small>{{ $edu->especialidad }}</small> @endif</td>
                    <td>{{ $edu->instituto }}</td>
                    <td class="text-center">{{ $edu->graduado ? 'SÍ' : 'NO' }}</td>
                    <td class="text-center">{{ $edu->ultimo_nivel ? 'SÍ' : 'NO' }}</td>
                    <td class="text-center">{{ $edu->fecha_culminado }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay formación registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Experiencia Laboral Interna -->
    <div class="section-title">Experiencia Laboral Interna</div>
    <table>
        <thead>
            <tr>
                <th>CARGO DESEMPEÑADO</th>
                <th>EMPRESA</th>
                <th class="text-center">DESDE/HASTA</th>
                <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experienciasInternas as $exp)
                <tr>
                    <td>{{ $exp->cargo_desempeñado }}</td>
                    <td>{{ $exp->empresa }}</td>
                    <td class="text-center">
                        {{ $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('d/m/Y') : '' }} - 
                        {{ $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('d/m/Y') : 'Actualidad' }}
                    </td>
                    <td>{{ $exp->observacion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay experiencia interna registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Experiencia Laboral Externa -->
    <div class="section-title">Experiencia Laboral Externa</div>
    <table>
        <thead>
            <tr>
                <th>CARGO DESEMPEÑADO</th>
                <th>EMPRESA</th>
                <th class="text-center">DESDE/HASTA</th>
                <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experienciasExternas as $exp)
                <tr>
                    <td>{{ $exp->cargo_desempeñado }}</td>
                    <td>{{ $exp->empresa }}</td>
                    <td class="text-center">
                        {{ $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('d/m/Y') : '' }} - 
                        {{ $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('d/m/Y') : 'Actualidad' }}
                    </td>
                    <td>{{ $exp->observacion }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No hay experiencia externa registrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Nivel de Inglés -->
    <div class="section-title">Nivel de Inglés</div>
    <div class="info-box">
        @if($ingles)
            <p>
                @if($ingles->i1) [X] Instrumental 1 (I1) &nbsp; @endif
                @if($ingles->i2) [X] Instrumental 2 (I2) &nbsp; @endif
                @if($ingles->bb) [X] Básico Básico (BB) &nbsp; @endif
                @if($ingles->ba) [X] Básico Alto (BA) &nbsp; @endif
                @if($ingles->ib) [X] Intermedio Básico (IB) &nbsp; @endif
                @if($ingles->ia) [X] Intermedio Alto (IA) &nbsp; @endif
                @if($ingles->ab) [X] Avanzado Básico (AB) &nbsp; @endif
                @if($ingles->aa) [X] Avanzado Alto (AA) &nbsp; @endif

                @if(!$ingles->i1 && !$ingles->i2 && !$ingles->bb && !$ingles->ba && !$ingles->ib && !$ingles->ia && !$ingles->ab && !$ingles->aa)
                    No se han registrado niveles de inglés aprobados.
                @endif
            </p>
        @else
            <p>No se han registrado niveles de inglés aprobados.</p>
        @endif
    </div>

    <!-- Cursos de Capacitación -->
    <div class="section-title">Participación en Cursos de Capacitación</div>
    @foreach($cursosPorArea as $areaData)
        <div class="small-title">ÁREA: {{ $areaData['area_nombre'] }}</div>
        <table>
            <thead>
                <tr>
                    <th>CURSO / PROGRAMA</th>
                    <th class="text-center" style="width: 15%">FECHA</th>
                    <th class="text-center" style="width: 15%">DURACIÓN</th>
                    <th class="text-center" style="width: 15%">ESTATUS</th>
                    <th class="text-center" style="width: 15%">CAUSA</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areaData['cursos'] as $curso)
                    <tr>
                        <td>{{ $curso->nombre }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($curso->fecha)->format('d/m/Y') }}</td>
                        <td class="text-center">{{ number_format($curso->duracion, 1) }} Hrs</td>
                        <td class="text-center">
                            @if(is_null($curso->estatus))
                                <span class="badge bg-warning">Pendiente</span>
                            @elseif($curso->estatus)
                                <span class="badge bg-success">Asistente</span>
                            @else
                                <span class="badge bg-danger">Inasistente</span>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $curso->causa ?: 'N/A' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay participación en cursos de esta área.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>