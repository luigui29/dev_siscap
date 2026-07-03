<div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
    <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
        <h5 class="font-weight-bold mb-0 text-white">
            <i class="fas fa-filter mr-2"></i> Filtro de Gerencias
        </h5>
    </div>
    <div class="card-body p-3 bg-light">
        <div class="row">
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

