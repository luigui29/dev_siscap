<div class="card-corporate shadow-sm border-0 mb-4 mx-5" wire:loading.class="opacity-50">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #5DADE2; border-bottom: none;">
        <div class="d-flex align-items-center">
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
        <div class="row text-dark">
            <!-- Barra Lateral (Info del Día) -->
            <div class="col-12 col-lg-4 ">
                <div class="card shadow-sm border-0 bg-white p-4 h-100 d-flex flex-column justify-content-between" style="border-radius: 8px;">
                    <div>
                    </div>
                </div>
            </div>

            <!-- Calendario -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 bg-white h-100">
                    <div class="p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" style="table-layout: fixed;">
                                <thead>
                                    <tr style="background-color: #F8FAFC;">
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Lun</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Mar</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Mie</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Jue</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Vie</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem; color: #C0392B;">Sab</th>
                                        <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem; color: #C0392B;">Dom</th>
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
                                            @elseif($esFinDeSemana)
                                                <td class="p-2" style="height: 100px; background-color: #FFF5F5; text-align: left; vertical-align: top;">
                                                    <span class="numero-dia font-weight-bold" style="color: #C0392B;">{{ $day['date']->format('j') }}</span>
                                                </td>
                                            @elseif($esFeriado)
                                                <td class="p-2" style="height: 100px; background-color: rgba(231, 76, 60, 0.05); text-align: left; vertical-align: top;" title="Feriado">
                                                    <span class="numero-dia font-weight-bold" style="color: #E74C3C;">{{ $day['date']->format('j') }}</span>
                                                    <div style="margin-top: 4px;">
                                                        <span style="font-size: 0.6rem; font-weight: 700; color: #E74C3C; text-transform: uppercase; letter-spacing: 0.3px;">Feriado</span>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                    <span class="numero-dia text-muted font-weight-bold">{{ $day['date']->format('j') }}</span>
                                                    @if($tieneEventos)
                                                        <div style="margin-top: 4px; display: flex; flex-direction: column; gap: 3px;">
                                                            @if($ejecutados > 0)
                                                                <div class="evento p-1 text-white border-0" style="background-color: #58D68D; border-radius: 4px; font-size: 0.65rem; line-height: 1.3;">
                                                                    <strong>{{ $ejecutados >= 10 ? '9+' : $ejecutados }}</strong> ejecutado(s)
                                                                </div>
                                                            @endif
                                                            @if($programados > 0)
                                                                <div class="evento p-1 text-white border-0" style="background-color: #5DADE2; border-radius: 4px; font-size: 0.65rem; line-height: 1.3;">
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
