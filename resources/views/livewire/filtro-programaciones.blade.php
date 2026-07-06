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
                <div class="row mb-2">
                    <div class="col-4">
                        <label for="actividad_filtro" class="font-weight-bold text-muted mb-1">Actividad</label>
                        @error('filtro_actividad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="actividad_filtro" type="text" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_actividad" :disabled="!$wire.area_seleccionada || $store.programaciones.cargando" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    </div>
                    <div class="col-8 align-self-end">
                        <select class="form-control" wire:model.live="actividad_seleccionada" :disabled="!$wire.area_seleccionada || $store.programaciones.cargando">
                            <option value="">Todas las actividades</option>
                            @foreach($this->actividades as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">
                        <label for="subactividad_filtro" class="font-weight-bold text-muted mb-1">Sub-Actividad</label>
                        @error('filtro_subactividad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="subactividad_filtro" type="text" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_subactividad" :disabled="!$wire.actividad_seleccionada || $store.programaciones.cargando" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    </div>
                    <div class="col-8 align-self-end">
                        <select class="form-control" wire:model.live="subactividad_seleccionada" :disabled="!$wire.actividad_seleccionada || $store.programaciones.cargando">
                            <option value="">Todas las subactividades</option>
                            @foreach($this->subactividades as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row pt-2 border-top">
                    <div class="col-4">
                        <label for="facilitador_filtro" class="font-weight-bold text-muted mb-1">Facilitador</label>
                        @error('filtro_facilitador') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="facilitador_filtro" type="text" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_facilitador" :disabled="$store.programaciones.cargando" placeholder="Escriba para buscar..." style="border-radius: 4px;">
                    </div>
                    <div class="col-8 align-self-end">
                        <select class="form-control" wire:model.live="facilitador_seleccionado" :disabled="$store.programaciones.cargando">
                            <option value="">Todos los facilitadores</option>
                            @foreach($this->facilitadores as $fac)
                                <option value="{{ $fac->id }}">{{ $fac->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row pb-2 my-2">
                    <div class="col-6">
                        <label for="institucion_filtro" class="font-weight-bold text-muted mb-1">Institución</label>
                        @error('filtro_institucion') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="institucion_filtro" type="text" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_institucion" :disabled="$store.programaciones.cargando" placeholder="VENPRECAR (por defecto)" style="border-radius: 4px;">
                    </div>
                    <div class="col-6">
                        <label for="lugar_filtro" class="font-weight-bold text-muted mb-1">Lugar</label>
                        @error('filtro_lugar') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="lugar_filtro" type="text" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_lugar" :disabled="$store.programaciones.cargando" placeholder="Ej: Sala de Eventos..." style="border-radius: 4px;">
                    </div>
                </div>
                <div class="row mb-3 border-top">
                    <div class="col-12 mt-2"><h5 class="font-weight-bold text-dark">Fecha</h5></div>
                    <div class="col-6">
                        <label for="fecha_desde_filtro" class="font-weight-bold text-muted mb-1">Desde</label>
                        @error('filtro_fecha_desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="fecha_desde_filtro" type="date" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_fecha_desde" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                    <div class="col-6">
                        <label for="fecha_hasta_filtro" class="font-weight-bold text-muted mb-1">Hasta</label>
                        @error('filtro_fecha_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="fecha_hasta_filtro" type="date" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_fecha_hasta" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                </div>
                <div class="row mb-3 border-top">
                    <div class="col-12 mt-2"><h5 class="font-weight-bold text-dark">Hora</h5></div>
                    <div class="col-6">
                        <label for="tiempo_desde_filtro" class="font-weight-bold text-muted mb-1">Desde</label>
                        @error('filtro_tiempo_desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="tiempo_desde_filtro" type="number" min=0 max=24 class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_tiempo_desde" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                    <div class="col-6">
                        <label for="tiempo_hasta_filtro" class="font-weight-bold text-muted mb-1">Hasta</label>
                        @error('filtro_tiempo_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="tiempo_hasta_filtro" type="number" min=0 max=24 class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_tiempo_hasta" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                </div>
                <div class="row border-top">
                    <div class="col-12 mt-2"><h5 class="font-weight-bold text-dark">Duración</h5></div>
                    <div class="col-6">
                        <label for="duracion_desde_filtro" class="font-weight-bold text-muted mb-1">Desde</label>
                        @error('filtro_duracion_desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="duracion_desde_filtro" type="number" min="0" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_duracion_desde" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                    <div class="col-6">
                        <label for="duracion_hasta_filtro" class="font-weight-bold text-muted mb-1">Hasta</label>
                        @error('filtro_duracion_hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="duracion_hasta_filtro" type="number" min="0" class="form-control form-control-md" wire:model.live.debounce.500ms="filtro_duracion_hasta" :disabled="$store.programaciones.cargando" style="border-radius: 4px;">
                    </div>
                </div>
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button class="btn btn-md btn-outline-secondary" wire:click="limpiar">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
</div>
