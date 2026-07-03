<div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h5 class="font-weight-bold mb-0 text-white">
            <i class="fas fa-filter mr-2"></i> Filtro de Empleados
        </h5>
    </div>
    <div class="card-body p-3 bg-light">
        <div class="row">
            <div class="col-2 mb-2">
                <label for="ficha_filtro" class="font-weight-bold text-muted mb-1">Ficha</label>
                @error('filtro_ficha') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="ficha_filtro" type="number" step="1" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_ficha" placeholder="Ingrese sólo números" style="border-radius: 4px;">
            </div>
            <div class="col-2 mb-2">
                <label for="cedula_filtro" class="font-weight-bold text-muted mb-1">Cédula</label>
                @error('filtro_cedula') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="cedula_filtro" type="number" step="1" min="0" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_cedula" placeholder="Ingrese sólo números" style="border-radius: 4px;">
            </div>
            <div class="col-4 mb-2">
                <label for="nombre_filtro" class="font-weight-bold text-muted mb-1">Nombre</label>
                @error('filtro_nombre') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="nombre_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_nombre" placeholder="Apellido y Nombre del empleado" style="border-radius: 4px;">
            </div>
            <div class="col-4 mb-2">
                <label for="cargo_filtro" class="font-weight-bold text-muted mb-1">Cargo</label>
                @error('filtro_cargo') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="cargo_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_cargo" placeholder="Ej: Analista" style="border-radius: 4px;">
            </div>
            <div class="col-6 mb-2">
                <label for="gerencia_filtro" class="font-weight-bold text-muted mb-1">Gerencia</label>
                @error('filtro_gerencia') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="gerencia_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_gerencia" placeholder="GCIA. o Gerencia..." style="border-radius: 4px;">
            </div>
            <div class="col-6 mb-2">
                <label for="unidad_filtro" class="font-weight-bold text-muted mb-1">Unidad</label>
                @error('filtro_unidad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                <input id="unidad_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_unidad" placeholder="Departamento..." style="border-radius: 4px;">
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button class="btn btn-sm btn-outline-secondary" wire:click="limpiar">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
</div>
