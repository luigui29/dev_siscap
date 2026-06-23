<div class="card-corporate shadow-sm border-0 mb-4 mx-5" wire:loading.class="opacity-50">
    <div class="card-header d-flex justify-content-end py-3" style="background-color: #5DADE2; border-bottom: none;">
        <div class="d-flex align-items-center mr-auto">
            <i class="fas fa-calendar-alt mr-2" style="font-size: 1.25rem; color: #FFFFFF;"></i>
            <h5 class="mb-0 font-weight-bold text-white">
                Cronograma
            </h5>
        </div>
        
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center mr-3">
                <button wire:click="cambiarMes(-1)" class="btn btn-sm btn-light font-weight-bold" style="border-radius: 5px;" title="Mes anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5 class="mb-0 mx-3 text-white font-weight-bold text-capitalize" style="min-width: 120px; text-align: center;">{{ \Carbon\Carbon::create($year, $month, 1)->locale('es')->isoFormat('MMMM') }}</h5>
                <button wire:click="cambiarMes(1)" class="btn btn-sm btn-light font-weight-bold" style="border-radius: 5px;" title="Mes siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="d-flex align-items-center">
                <button wire:click="cambiarAnio(-1)" class="btn btn-sm btn-light font-weight-bold" style="border-radius: 5px;" title="Año anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5 class="mb-0 mx-3 text-white font-weight-bold" style="min-width: 50px; text-align: center;">{{ $year }}</h5>
                <button wire:click="cambiarAnio(1)" class="btn btn-sm btn-light font-weight-bold" style="border-radius: 5px;" title="Año siguiente">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
    
    <div class="card-body p-4 bg-light">
        <div class="row text-dark">
            <!-- Barra Lateral (Info del Día) -->
            <div class="col-12 col-lg-4 ">
                <div class="card shadow-sm border-0 bg-white p-4 h-100 position-relative" style="border-radius: 8px; overflow-y: auto; max-height: 700px;">
                    <!-- Indicador de Carga -->
                    <div wire:loading wire:target="seleccionarFecha" class="position-absolute w-100 h-100" style="background-color: rgba(255, 255, 255, 0.8); z-index: 10; top: 0; left: 0; border-radius: 8px;">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="spinner-border text-primary mb-2" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <span class="text-primary font-weight-bold">Cargando detalles...</span>
                        </div>
                    </div>

                    <div wire:loading.class="opacity-50" wire:target="seleccionarFecha">
                        @if($fechaSeleccionada)
                            @php
                                $cursosDelDia = isset($eventos[$fechaSeleccionada]) ? $eventos[$fechaSeleccionada] : [];
                            @endphp
                            <h5 class="font-weight-bold text-dark mb-4 border-bottom pb-2">
                                <i class="fas fa-calendar-day text-primary mr-2"></i>
                                {{ \Carbon\Carbon::parse($fechaSeleccionada)->locale('es')->isoFormat('dddd, D [de] MMMM') }}
                            </h5>
                            @if(count($cursosDelDia) > 0)
                                <div class="list-group">
                                    @foreach($cursosDelDia as $curso)
                                        <div class="list-group-item flex-column align-items-start border-0 border-bottom px-0 py-3">
                                            <div class="d-flex w-100 justify-content-between mb-2">
                                                <h6 class="mb-0 font-weight-bold" style="color: #2C3E50; line-height: 1.4;">{{ $curso->actividad->nombre ?? 'Actividad no especificada' }}</h6>
                                            </div>
                                            @if($curso->subactividad)
                                                <p class="mb-2 text-muted" style="font-size: 0.85rem;">{{ $curso->subactividad->nombre }}</p>
                                            @endif
                                            
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <div>
                                                    @if($curso->ejecutado)
                                                        <span class="text-success"><i class="fas fa-check-circle "></i> Ejecutado</span>
                                                        <a href="{{ route('programacion', ['pestania' => 'ejecucion', 'exec_id' => $curso->id]) }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-solid fa-eye text-white mr-2"></i>REVISAR</a>
                                                    @elseif($curso->aprobado)
                                                        <span class="text-success"><i class="fas fa-check-circle text-success"></i> Aprobado</span>
                                                        <a href="{{ route('programacion', ['pestania' => 'final', 'filter_id' => $curso->id]) }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-solid fa-eye text-white mr-2"></i>REVISAR</a>
                                                    @else
                                                        <span class="text-warning"><i class="fas fa-clock text-warning"></i> Pendiente</span>
                                                        <a href="{{ route('programacion', ['pestania' => 'final', 'filter_id' => $curso->id]) }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-solid fa-eye text-white mr-2"></i>REVISAR</a>
                                                    @endif
                                                </div>
                                                @if($curso->facilitador)
                                                    <small class="text-muted" title="Facilitador">
                                                        <i class="fas fa-chalkboard-teacher mr-1"></i> {{ $curso->facilitador->nombre }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center mt-5">
                                    <i class="fas fa-calendar-times text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                    <p class="text-muted font-weight-bold mb-0">Sin programaciones</p>
                                    <small class="text-muted">No hay cursos para este día.</small>
                                </div>
                            @endif
                        @else
                            <div class="text-center text-muted" style="margin-top: 50%;">
                                <i class="fas fa-hand-pointer mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                                <h6 class="font-weight-bold">Selecciona un día</h6>
                                <p class="small">Haz clic en un día del calendario para ver las programaciones.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 bg-white h-100 position-relative">
                    <!-- Indicador de Carga del Calendario -->
                    <div wire:loading wire:target="cambiarMes, cambiarAnio" class="position-absolute w-100 h-100" style="background-color: rgba(255, 255, 255, 0.7); z-index: 10; top: 0; left: 0; border-radius: 8px;">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100">
                            <div class="spinner-border text-primary mb-2" role="status">
                                <span class="sr-only">Cargando...</span>
                            </div>
                            <span class="text-primary font-weight-bold">Actualizando calendario...</span>
                        </div>
                    </div>

                    <div class="p-3" wire:loading.class="opacity-50" wire:target="cambiarMes, cambiarAnio">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" style="table-layout: fixed;">
                                <thead>
                                    <tr style="background-color: #F8FAFC;">
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 20%; font-size: 0.78rem;">Lun</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 20%; font-size: 0.78rem;">Mar</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 20%; font-size: 0.78rem;">Mie</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 20%; font-size: 0.78rem;">Jue</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 20%; font-size: 0.78rem;">Vie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calendario['semanas'] as $week)
                                    <tr>
                                        @foreach($week as $day)
                                            @php
                                                $fechaStr = $day['date']->format('Y-m-d');
                                                $esFinDeSemana = $day['is_weekend'];
                                                $esFeriado = $day['is_feriado'];
                                                $esMesActual = $day['is_current_month'];
                                                $tieneEventos = $esMesActual && !$esFinDeSemana && !$esFeriado && isset($eventos[$fechaStr]);

                                                $pre_programados = 0;
                                                $programados = 0;
                                                $ejecutados = 0;

                                                if ($tieneEventos) {
                                                    foreach ($eventos[$fechaStr] as $evento) {
                                                        if ($evento->ejecutado) {
                                                            $ejecutados++;
                                                        } elseif ($evento->aprobado) {
                                                            $programados++;
                                                        } else {
                                                            $pre_programados++;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @if(!$esMesActual)
                                                <td class="p-2 text-muted" style="height: 100px; background-color: #F1F5F9; text-align: left; vertical-align: top; opacity: 0.5;">
                                                    <span class="numero-dia font-weight-bold">{{ $day['date']->format('j') }}</span>
                                                </td>
                                            @elseif($esFeriado)
                                                <td class="p-2" style="height: 100px; background-color: rgba(231, 76, 60, 0.05); text-align: left; vertical-align: top;" title="Feriado">
                                                    <span class="numero-dia font-weight-bold" style="color: #E74C3C;">{{ $day['date']->format('j') }}</span>
                                                    <div style="margin-top: 4px;">
                                                        <span style="font-size: 0.6rem; font-weight: 700; color: #E74C3C; text-transform: uppercase; letter-spacing: 0.3px;">Feriado</span>
                                                    </div>
                                                </td>
                                            @else
                                                <td wire:click="seleccionarFecha('{{ $fechaStr }}')" 
                                                    class="mes-actual p-2 position-relative" 
                                                    style="height: 100px; text-align: left; vertical-align: top; cursor: pointer; transition: all 0.2s; {{ $fechaSeleccionada === $fechaStr ? 'background-color: #EBF5FB; border: 2px solid #3498DB !important;' : '' }}"
                                                    onmouseover="this.style.backgroundColor='#F4F6F7'" 
                                                    onmouseout="this.style.backgroundColor='{{ $fechaSeleccionada === $fechaStr ? '#EBF5FB' : 'transparent' }}'">
                                                    <span class="numero-dia font-weight-bold {{ $fechaSeleccionada === $fechaStr ? 'text-primary' : 'text-muted' }}">{{ $day['date']->format('j') }}</span>
                                                    @if($tieneEventos)
                                                        <div style="margin-top: 4px; display: flex; flex-direction: column; gap: 3px;">
                                                            @if($ejecutados > 0)
                                                                <div class="evento p-1 text-white border-0" style="background-color: #58D68D; border-radius: 4px; font-size: 0.65rem; line-height: 1.3;">
                                                                    <strong>{{ $ejecutados >= 10 ? '9+' : $ejecutados }}</strong> ejecutado(s)
                                                                </div>
                                                            @endif
                                                            @if($programados > 0)
                                                                <div class="evento p-1 text-white border-0" style="background-color: #58D68D; border-radius: 4px; font-size: 0.65rem; line-height: 1.3;">
                                                                    <strong>{{ $programados >= 10 ? '9+' : $programados }}</strong> aprobado(s)
                                                                </div>
                                                            @endif
                                                            @if($pre_programados > 0)
                                                                <div class="evento p-1 text-dark border-0" style="background-color: #F8C471; border-radius: 4px; font-size: 0.65rem; line-height: 1.3;">
                                                                    <strong>{{ $pre_programados >= 10 ? '9+' : $pre_programados }}</strong> propuesta(s)
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
