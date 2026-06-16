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
        <h2>Resumen de Horas Hombres de Capacitación</h2>
        <p class="small-title mt-2">{{ $tituloGerencia }}</p>
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>

    <div class="info-box">
        <p><strong>Total Horas Hombres (Gerencia):</strong> {{ number_format($totalHorasGerencia, 1) }} Hrs</p>
    </div>

    @foreach($datosPorUnidad as $unidad)
        <div class="section-title">UNIDAD: {{ $unidad['nombre'] }}</div>
        <div style="margin-bottom: 5px;"><strong>Total Horas Unidad:</strong> {{ number_format($unidad['total_horas'], 1) }} Hrs</div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 70%">ÁREA DE CAPACITACIÓN</th>
                    <th class="text-center" style="width: 30%">HORAS HOMBRES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unidad['areas'] as $areaNombre => $horas)
                    <tr>
                        <td>{{ $areaNombre }}</td>
                        <td class="text-center">{{ number_format($horas, 1) }} Hrs</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">No hay horas de capacitación registradas en esta unidad.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

</body>
</html>