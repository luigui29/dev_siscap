<div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
            <i class="fas fa-filter mr-2"></i> Filtro de Empleados
        </h5>
    </div>
    <div class="card-body p-3 bg-light">
        <div class="row">
            <div class="col-md-2 mb-2">
                <label for="ficha_filtro" class="font-weight-bold small text-muted mb-1">Ficha</label>
                <input id="ficha_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_ficha" placeholder="Ej. 12345" style="border-radius: 4px;">
            </div>
            <div class="col-md-2 mb-2">
                <label for="cedula_filtro" class="font-weight-bold small text-muted mb-1">Cédula</label>
                <input id="cedula_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_cedula" placeholder="Ej. 15392091" style="border-radius: 4px;">
            </div>
            <div class="col-md-4 mb-2">
                <label for="nombre_filtro" class="font-weight-bold small text-muted mb-1">Nombre</label>
                <input id="nombre_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_nombre" placeholder="Nombre del empleado" style="border-radius: 4px;">
            </div>
            <div class="col-md-4 mb-2">
                <label for="cargo_filtro" class="font-weight-bold small text-muted mb-1">Cargo</label>
                <input id="cargo_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_cargo" placeholder="Ej. Analista" style="border-radius: 4px;">
            </div>
            <div class="col-md-6 mb-2">
                <label for="gerencia_filtro" class="font-weight-bold small text-muted mb-1">Gerencia</label>
                <input id="gerencia_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_gerencia" placeholder="Ej. Gerencia de Adiestramiento" style="border-radius: 4px;">
            </div>
            <div class="col-md-6 mb-2">
                <label for="unidad_filtro" class="font-weight-bold small text-muted mb-1">Unidad</label>
                <input id="unidad_filtro" type="text" class="form-control form-control-sm" wire:model.live.debounce.500ms="filtro_unidad" placeholder="Ej. Departamento TI" style="border-radius: 4px;">
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button class="btn btn-sm btn-outline-secondary" wire:click="limpiarFiltrosEmpleados">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
            </div>
        </div>
    </div>
</div>
