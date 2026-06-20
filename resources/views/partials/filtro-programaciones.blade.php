<div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
            <i class="fas fa-filter mr-2"></i> Filtro de Cursos
        </h5>
    </div>
    <div class="card-body p-3 bg-light">
        <div class="row">
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Área</label>
                <select class="form-control form-control-sm" wire:model.live="filtro_area" style="border-radius: 4px;">
                        <option value="">Seleccione un Área</option>
                        @foreach($this->areas as $area)
                            <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                        @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Actividad</label>
                <select class="form-control form-control-sm" wire:model.live="filtro_actividad" style="border-radius: 4px;" {{ !$filtro_area ? 'disabled' : '' }}>
                    <option value="">Seleccione una actividad</option>
                    @foreach($this->actividades->where('area_id', $filtro_area) as $act)
                        <option value="{{ $act->nombre }}">{{ $act->nombre }}</option>
                    @endforeach
                </select>
                @error('filtro_actividad') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Subactividad</label>
                @php
                    $actividadSeleccionadaBusqueda = collect($this->actividades)->where('nombre', $filtro_actividad)->first();
                    $idActividadSeleccionadaBusqueda = $actividadSeleccionadaBusqueda ? $actividadSeleccionadaBusqueda->id : null;
                @endphp
                <select class="form-control form-control-sm" wire:model.live="filtro_subactividad" style="border-radius: 4px;" {{ !$filtro_actividad ? 'disabled' : '' }}>
                        <option value="">Seleccione una subactividad</option>
                        @foreach($this->subactividades->where('actividad_id', $idActividadSeleccionadaBusqueda) as $sub)
                            <option value="{{ $sub->nombre }}">{{ $sub->nombre }}</option>
                        @endforeach
                </select>
                @error('filtro_subactividad') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Facilitador</label>
                <select class="form-control form-control-sm" wire:model.live="filtro_facilitador" style="border-radius: 4px;">
                        <option value="">Seleccione un facilitador</option>
                        @foreach($this->facilitadores as $fac)
                            <option value="{{ $fac->nombre }}">{{ $fac->nombre }}</option>
                        @endforeach
                </select>
                @error('filtro_facilitador') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Institución</label>
                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="filtro_institucion" placeholder="Ej. VENPRECAR, C.A." style="border-radius: 4px;">
            </div>
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Fecha</label>
                <input type="date" class="form-control form-control-sm" wire:model.live="filtro_fecha" style="border-radius: 4px;">
            </div>
            <div class="col-md-3 mb-2">
                <label class="font-weight-bold small text-muted mb-1">Lugar</label>
                <input type="text" class="form-control form-control-sm" wire:model.live.debounce.300ms="filtro_lugar" placeholder="Ej. Sala de Eventos" style="border-radius: 4px;">
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="limpiarFiltrosBusqueda">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
</div>
