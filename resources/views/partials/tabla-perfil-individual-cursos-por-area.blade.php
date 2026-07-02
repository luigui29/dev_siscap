<div class="col-12 px-0 my-2">
    <h5 class="font-weight-bold text-secondary mb-2">
        {{ $nombre_area }}
    </h5>

    <div class="table-responsive px-0 mb-4 border rounded">
        <table class="table table-sm table-fixed-layout mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="p-2 text-center" style="width: 10%;">ACTIVIDAD </th>
                    <th class="p-2 text-center" style="width: 10%;">SUBACTIVIDAD </th>
                    <th class="p-2 text-center" style="width: 20%;">INSTITUCION Y FACILITADOR </th>
                    <th class="p-2 text-center" style="width: 20%;">FECHA Y LUGAR </th>
                    <th class="p-2 text-center" style="width: 10%;">DURACION </th>
                    <th class="p-2 text-center" style="width: 10%;">ASISTENCIA </th>
                    <th class="p-2 text-center" style="width: 20%;">OBSERVACIONES </th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos_area as $c)
                <tr>
                    <td class="p-2 text-center">{{ $c->nombre_actividad }}</td>
                    <td class="p-2 text-center">{{ $c->nombre_subactividad ?? '---' }}</td>
                    <td class="p-2 text-center">{{ $c->institucion }}<br><span class="small">{{ $c->nombre_facilitador }}</span></td>
                    <td class="p-2 text-center">{{ $c->fecha }}<br>{{ $c->lugar }}</td>
                    <td class="p-2 text-center">{{ $c->duracion }} horas</td>
                    <td class="p-2 text-center">{{ is_null($c->asistencia) ? '---' : ( $c->asistencia ? '✓' : 'X') }}</td>
                    <td class="p-2 text-center">{{ $c->causa ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>