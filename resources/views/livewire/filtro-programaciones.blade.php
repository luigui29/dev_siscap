<div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h5 class="font-weight-bold mb-0 text-white">
            <i class="fas fa-filter mr-2"></i> Filtro de Programaciones
        </h5>
    </div>
    <div class="card-body p-3 bg-light">
        <div class="row">
            <div class="col-12 mb-2">
                <label for="area_seleccionada" class="font-weight-bold text-muted mb-1">Área</label>
                <select id="area_seleccionada" class="form-control" wire:model.live="area_seleccionada" :disabled="$store.programaciones.cargando">
                    <option value="">Todas las áreas de capacitación</option>
                    @foreach($this->areas as $a)
                        <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mb-2">
                <div class="d-flex flex-row">
                    <label for="actividad_filtro" class="font-weight-bold text-muted mb-1">Actividad</label>
                    @error('filtro_actividad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="actividad_filtro" type="number" step="1" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_actividad" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    <select class="form-control" wire:model.live="actividad_seleccionada" :disabled="$store.programaciones.cargando">
                        <option value="">Todas las actividades</option>
                        @foreach($this->actividades as $a)
                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 mb-2">
                <div class="d-flex flex-row">
                    <label for="subactividad_filtro" class="font-weight-bold text-muted mb-1">Sub-Actividad</label>
                    @error('filtro_subactividad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="subactividad_filtro" type="number" step="1" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_subactividad" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    <select class="form-control" wire:model.live="actividad_seleccionada" :disabled="$store.programaciones.cargando">
                        <option value="">Todas las sub-actividades</option>
                        @foreach($this->subactividades as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 mb-2">
                <div class="d-flex flex-row">
                    <label for="facilitador_filtro" class="font-weight-bold text-muted mb-1">Facilitador</label>
                    @error('filtro_facilitador') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="facilitador_filtro" type="number" step="1" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_facilitador" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    <select class="form-control" wire:model.live="actividad_seleccionada" :disabled="$store.programaciones.cargando">
                        <option value="">Todos los facilitadores</option>
                        @foreach($this->facilitadores as $f)
                            <option value="{{ $f->id }}">{{ $f->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-12 mb-2 border-top">
                <h5 class="font-weight-bold text-dark">Fecha</h5>
                <div class="d-flex flex-row">
                    <label for="fecha_desde_filtro" class="text-secondary mb-1">Desde</label>
                    <input id="fecha_desde_filtro" type="date" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_fecha_desde" style="border-radius: 4px;">
                    <label for="fecha_hasta_filtro" class="text-secondary mb-1">Hasta</label>
                    @error('filtro_fecha_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="fecha_hasta_filtro" type="date" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_fecha_hasta" style="border-radius: 4px;">
                </div>
            </div>
            <div class="col-12 mb-2">
                <h5 class="font-weight-bold text-dark">Horas</h5>
                <div class="d-flex flex-row">
                    <label for="tiempo_desde_filtro" class="text-secondary mb-1">Desde</label>
                    <input id="tiempo_desde_filtro" type="time" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_tiempo_desde" style="border-radius: 4px;">
                    <label for="tiempo_hasta_filtro" class="text-secondary mb-1">Hasta</label>
                    @error('filtro_tiempo_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="tiempo_hasta_filtro" type="time" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_tiempo_hasta" style="border-radius: 4px;">
                </div>
            </div>
            <div class="col-12 mb-2">
                <h5 class="font-weight-bold text-dark">Duración</h5>
                <div class="d-flex flex-row">
                    <label for="duracion_desde_filtro" class="text-secondary mb-1">Desde</label>
                    @error('filtro_duracion_desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="duracion_desde_filtro" type="number" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_duracion_desde" style="border-radius: 4px;">
                    <label for="duracion_hasta_filtro" class="text-secondary mb-1">Hasta</label>
                    @error('filtro_duracion_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                    <input id="duracion_hasta_filtro" type="number" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_duracion_hasta" style="border-radius: 4px;">
                </div>
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button class="btn btn-sm btn-outline-secondary" wire:click="limpiar">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
</div>
