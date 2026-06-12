<div class="card-corporate shadow-sm border-0 mb-4" wire:loading.class="opacity-50">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #334155; border-bottom: none;">
        <div class="d-flex align-items-center">
            <i class="fas fa-calendar-alt mr-2" style="font-size: 1.25rem; color: #FFFFFF;"></i>
            <h5 class="mb-0 font-weight-bold text-white">
                Calendario de Capacitación
            </h5>
        </div>
        
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center mr-3">
                <button wire:click="cambiarMes(-1)" class="btn btn-sm btn-light font-weight-bold" style="border-radius: 5px;" title="Mes anterior">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5 class="mb-0 mx-3 text-white font-weight-bold text-capitalize" style="min-width: 120px; text-align: center;">{{ $calendario['nombre_mes'] }}</h5>
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
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 8px;">
                    <div class="card-body p-3">
                        <table class="table table-borderless mb-0" style="table-layout: fixed;">
                            <thead>
                                <tr style="color: #64748B; border-bottom: 2px solid #E2E8F0;">
                                    <th class="py-3 text-center">Lunes</th>
                                    <th class="py-3 text-center">Martes</th>
                                    <th class="py-3 text-center">Miércoles</th>
                                    <th class="py-3 text-center">Jueves</th>
                                    <th class="py-3 text-center">Viernes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calendario['semanas'] as $week)
                                <tr>
                                    @foreach($week as $day)
                                        @php
                                            $fechaStr = $day['date']->format('Y-m-d');
                                            $tieneEventos = isset($eventos[$fechaStr]);

                                            $dayClasses = ['calendario-dia'];

                                            if (!$day['is_current_month']) {
                                                $dayClasses[] = 'otro-mes';
                                            } elseif ($day['is_feriado']) {
                                                $dayClasses[] = 'feriado';
                                            }

                                            $pre_programados = 0;
                                            $programados = 0;
                                            $ejecutados = 0;

                                            if ($tieneEventos && $day['is_current_month']) {
                                                $eventosDelDia = $eventos[$fechaStr];
                                                foreach ($eventosDelDia as $evento) {
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
                                        <td class="{{ implode(' ', $dayClasses) }}">
                                            <span class="dia-numero">{{ $day['date']->format('j') }}</span>
                                            @if($day['is_current_month'] && $tieneEventos)
                                                <div class="dia-eventos">
                                                    @if($pre_programados > 0)
                                                        <span class="evento-etiqueta pre-programado">{{ $pre_programados >= 10 ? '9+' : $pre_programados }} pre-prog.</span>
                                                    @endif
                                                    @if($programados > 0)
                                                        <span class="evento-etiqueta programado">{{ $programados >= 10 ? '9+' : $programados }} prog.</span>
                                                    @endif
                                                    @if($ejecutados > 0)
                                                        <span class="evento-etiqueta ejecutado">{{ $ejecutados >= 10 ? '9+' : $ejecutados }} ejec.</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="calendario-leyenda">
            <div class="leyenda-item">
                <span class="leyenda-color" style="background-color: rgba(245, 176, 65, 0.15); border: 1px solid rgba(245, 176, 65, 0.3);"></span> Pre-programado
            </div>
            <div class="leyenda-item">
                <span class="leyenda-color" style="background-color: rgba(88, 214, 141, 0.15); border: 1px solid rgba(88, 214, 141, 0.3);"></span> Programado
            </div>
            <div class="leyenda-item">
                <span class="leyenda-color" style="background-color: rgba(93, 173, 226, 0.15); border: 1px solid rgba(93, 173, 226, 0.3);"></span> Ejecutado
            </div>
            <div class="leyenda-item">
                <span class="leyenda-color" style="background-color: rgba(231, 76, 60, 0.05); border: 1px solid rgba(231, 76, 60, 0.2);"></span> Feriado
            </div>
        </div>
    </div>
</div>
