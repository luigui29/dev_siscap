<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Control de Asistencias</title>
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
        <h4>CONTROL DE ASISTENCIAS</h4>
        <p>Generado el {{ date('d/m/Y') }}</p>
    </div>

    <h4 class="section-title">Empleados Matriculados</h4>

    <table class="table-pdf striped">
        <thead>
            <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Ficha</th>
                <th class="text-center">Cédula</th>
                <th class="text-left">Nombre</th>
                <th class="text-center">Firma</th>
            </tr>
        </thead>
        <tbody>
            @forelse($empleados as $index => $empleado)
                <tr>
                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                    <td class="text-center align-middle">{{ $empleado->ficha }}</td>
                    <td class="text-center align-middle">{{ $empleado->cedula }}</td>
                    <td class="text-left align-middle">{{ $empleado->nombre_empleado }}</td>
                    <td class="text-center align-middle"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay empleados matriculados en esta programación.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>