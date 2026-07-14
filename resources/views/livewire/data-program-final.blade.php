<!-- Tarjeta con información de las programaciones registradas según filtros  -->
<div class="card shadow-sm border-0 bg-white">
    <div class="card-header border-bottom p-3">
        <h5 class="font-weight-bold mb-0 text-white">
            <i class="fas fa-th-large mr-2"></i> Programaciones
        </h5>
    </div>

    <div class="card-body overflow-auto" style="max-height: 900px">
        <!-- Indicador de carga -->
        <div x-show="$store.programaciones.cargando" 
                style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 10; justify-content: center; align-items: center; border-radius: 0 0 8px 8px;"
                :class="$store.programaciones.cargando ? 'd-flex' : 'd-none'">
            <div class="text-center">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div class="text-primary small">Cargando programaciones...</div>
            </div>
        </div>
        @forelse($this->programaciones as $program)
            <div class="p-3 bg-light rounded border my-3">
                <h5 class="font-weight=bold mb-2"> {{$program->nombre_actividad}} </h5>
                <p class="text-secondary mb-2"> {{$program->nombre_subactividad }}</p>
                <p class="text-secondary mb-2"><strong>Facilitador:</strong>{{$program->nombre_facilitador}}</p>
                <p class="text-secondary mb-2"><strong>Institución:</strong>{{$program->institucion}}</p>
                <p class="text-secondary mb-2"><strong>Lugar:</strong>{{$program->lugar}}</p>
                <p class="text-secondary mb-2"><i class="fas fa-calendar mr-2"></i>{{$program->fecha}}</p>
                <p class="text-secondary mb-2"><i class="fas fa-clock mr-2"></i>{{$program->desde}} - {{$program->hasta}}  <strong>({{$program->duracion}}) Hora(s)</strong></p>
                <div class="mb-2 mt-3 row">
                    <div class="col-6">
                        <button class="btn btn-md btn-outline-primary" wire:click="$dispatch('abrir-modal-program-empleados', { id: {{ $program->programacion_id }} })">
                            <i class="fas fa-users"></i>
                        </button>
                    </div>
                    @if(is_null($program->aprobado))
                    <div class="col-2 ml-auto d-flex justify-content-end">
                        <button class="btn btn-md btn-outline-success mr-2" 
                                wire:click="aprobar({{ $program->programacion_id }})"
                                wire:loading.attr="disabled"
                                wire:target="aprobar({{ $program->programacion_id }})"
                                :disabled="$store.programaciones.cargando">
                            <span wire:loading wire:target="aprobar({{ $program->programacion_id }})" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i wire:loading.remove wire:target="aprobar({{ $program->programacion_id }})" class="fas fa-check-circle"></i>
                        </button>
                        <button class="btn btn-md btn-outline-danger"
                                wire:confirm="¿Está seguro de que quiere rechazar esta programación?" 
                                wire:click="rechazar({{ $program->programacion_id }})"
                                wire:loading.attr="disabled"
                                wire:target="rechazar({{ $program->programacion_id }})"
                                :disabled="$store.programaciones.cargando">
                            <span wire:loading wire:target="rechazar({{ $program->programacion_id }})" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i wire:loading.remove wire:target="rechazar({{ $program->programacion_id }})" class="fas fa-solid fa-ban"></i>
                        </button>
                    </div>
                    @else
                    <div class="col-2 ml-auto d-flex justify-content-end">
                        @if($program->aprobado)
                        <button class="btn btn-md btn-outline-pdf mr-2" 
                                wire:click="control_asistencia({{ $program->programacion_id }})"
                                wire:loading.attr="disabled"
                                wire:target="control_asistencia({{ $program->programacion_id }})"
                                :disabled="$store.programaciones.cargando">
                            <span wire:loading wire:target="control_asistencia({{ $program->programacion_id }})" class="spinner-border spinner-border-sm mx-1" role="status" aria-hidden="true"></span>
                            <i wire:loading.remove wire:target="control_asistencia({{ $program->programacion_id }})" class="fas fa-file-pdf mx-1"></i>
                        </button>
                        @endif
                        <button class="btn btn-md btn-outline-secondary"
                                wire:confirm="¿Está seguro de que quiere retroceder esta programación? Esto puede afectar las horas de capacitación de los empleados matriculados." 
                                wire:click="retroceder({{ $program->programacion_id }})"
                                wire:loading.attr="disabled"
                                wire:target="retroceder({{ $program->programacion_id }})"
                                :disabled="$store.programaciones.cargando">
                            <span wire:loading wire:target="retroceder({{ $program->programacion_id }})" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <i wire:loading.remove wire:target="retroceder({{ $program->programacion_id }})" class="fas fa-redo"></i>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-3 bg-light rounded border text-center border my-2">
                <p class="mb-0">Las programaciones aprobadas, rechazadas y las pre-programaciones registradas se mostrarán aquí según los filtros usados.</p>
            </div>
        @endforelse
    </div>
</div>