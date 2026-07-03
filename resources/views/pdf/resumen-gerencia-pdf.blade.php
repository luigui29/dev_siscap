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
        <h4>RESUMEN DE CAPACITACIÓN POR GERENCIA</h4>
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>

    <!-- Información General -->
    <table class="table-pdf grid">
        <thead>
            <tr>
                <th class="text-left align-middle" colspan="2">Gerencia: {{ $nombre_gerencia }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>    
                <td class="text-left align-middle"><strong>Total de Empleados:</strong> {{ $total_empleados }}</td>
                <td class="text-left align-middle"><strong>Total Horas de Capacitación:</strong> {{ number_format($total_horas, 1) }} Hrs</td>
            </tr>
            <tr>
                <td class="text-left align-middle"><strong>Pre-programaciones:</strong> {{ $total_pre_program }}</td>
                <td class="text-left align-middle"><strong>Programaciones Finales:</strong> {{ $total_program_final }}</td>
            </tr>
            <tr>
                <td class="text-left align-middle" colspan="2"><strong>Ejecuciones Realizadas:</strong> {{ $total_ejecuciones }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Capacitación y Desarrollo por Unidad -->
    <div class="section-title"><h4>CAPACITACIÓN Y DESARROLLO POR UNIDAD</h4></div>
    <table class="table-pdf striped grid">
        <thead>
            <tr>
                <th class="text-left">UNIDAD</th>
                <th class="text-center">EMPLEADOS</th>
                <th class="text-center">PRE-PROG.</th>
                <th class="text-center">PROG. FINALES</th>
                <th class="text-center">EJECUCIONES</th>
                <th class="text-center">TOTAL HORAS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unidades as $unidad)
                <tr>
                    <td class="text-left">{{ $unidad->texto_unidad }}</td>
                    <td class="text-center">{{ $unidad->numero_empleados }}</td>
                    <td class="text-center">{{ $unidad->pre_program }}</td>
                    <td class="text-center">{{ $unidad->program_final }}</td>
                    <td class="text-center">{{ $unidad->ejecuciones }}</td>
                    <td class="text-center">{{ number_format($unidad->horas, 1) }} Hrs</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay unidades registradas para esta gerencia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>