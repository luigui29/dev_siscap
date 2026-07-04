<!-- Tarjeta con información de las preprogramaciones registradas según filtros  -->
<div class="card shadow-sm border-0 bg-white">
    <div class="card-header border-bottom p-3">
        <h5 class="font-weight-bold mb-0 text-white">
            <i class="fas fa-th-large mr-2"></i> Pre-Programaciones Registradas
        </h5>
    </div>

    <div class="card-body">
        <!-- Indicador de carga -->
        <div x-show="$store.programaciones.cargando" 
                style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 10; justify-content: center; align-items: center; border-radius: 0 0 8px 8px;"
                :class="$store.programaciones.cargando ? 'd-flex' : 'd-none'">
            <div class="text-center">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <div class="text-primary small">Cargando pre-programaciones...</div>
            </div>
        </div>
        @forelse($this->pre_programaciones as $preprogram)
            <div class="p-3 bg-light rounded border my-2">
                <h5 class="font-weight=bold mb-2"> {{$preprogram->nombre_actividad}} </h5>
                <p class="text-secondary mb-2"> {{$preprogram->nombre_subactividad }}</p>
                <p class="text-secondary mb-2"><strong>Facilitador:</strong>{{$preprogram->nombre_facilitador}}</p>
                <p class="text-secondary mb-2"><strong>Institución:</strong>{{$preprogram->institucion}}</p>
                <p class="text-secondary mb-2"><strong>Lugar:</strong>{{$preprogram->lugar}}</p>
                <p class="text-secondary mb-2"><i class="fa-regular fa-calendar"></i>{{$preprogram->fecha}}</p>
                <p class="text-secondary mb-2"><i class="fa-regular fa-clock"></i>{{$preprogram->desde}} - {{$preprogram->hasta}} ({{$preprogram->duracion}}) Hora(s)</p>
                <div class="mb-2 d-flex flex-row-reverse">
                    <button class="ml-2 btn btn-sm btn-outline-primary" wire:click="$dispatch('abrir-modal-pre-program-curso', { id: {{ $preprogram->programacion_id }} })">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" 
                            wire:confirm="¿Está seguro de que quiere eliminar este registro de pre-programación? Este cambio no se puede deshacer" 
                            wire:click="eliminar({{ $preprogram->programacion_id }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="p-3 bg-light rounded border text-center border my-2">
                <p class="mb-0">Las pre-programaciones registradas se mostrarán aquí según los filtros usados.</p>
            </div>
        @endforelse
    </div>
</div>
