<div class="modal fade" id="modal_experiencia" tabindex="-1" aria-labelledby="modal_experienciaLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="position: relative;">
            
            <!-- Indicador de carga -->
            <div wire:loading.flex wire:target="guardar, eliminar" style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 1055; align-items: center; justify-content: center; border-radius: 12px;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div class="text-primary small font-weight-bold">Procesando...</div>
                </div>
            </div>

            <div class="modal-header text-white" style="background-color: #64748B; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-weight-bold" id="modal_experienciaLabel">
                    <i class="fas fa-users mr-2"></i> Gestionar Experiencia del Empleado: {{ $this->nombre_empleado() }}
                </h5>
                <button type="button" class="close text-white" aria-label="Close" style="outline: none;" x-on:click="$dispatch('cerrar-modal-experiencia')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-5">
                <div class="row p-4">
                    <div class="col-4 mb-4">
                        <label for="cargo_desempenado" class="font-weight-bold text-muted mb-1">Cargo Desempeñado</label>
                        @error('cargo_desempenado') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="cargo_desempenado" type="text" wire:model="cargo_desempenado" class="form-control form-control-md" placeholder="Nombre del cargo asumido..." style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="empresa" class="font-weight-bold text-muted mb-1">Empresa</label>
                        @error('empresa') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="empresa" type="text" wire:model="empresa" class="form-control form-control-md" placeholder="Nombre de la empresa..." style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="observacion" class="font-weight-bold text-muted mb-1">Observación</label>
                        @error('observacion') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="observacion" type="text" wire:model="observacion" class="form-control form-control-md" placeholder="Rellenar en caso de no haber fecha de culminación clara..." style="border-radius: 4px;">
                    </div>
                    <div class="col-6 mb-4">
                        <label for="desde" class="font-weight-bold text-muted mb-1">Fecha de Inicio</label>
                        @error('desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="desde" type="date" wire:model="desde" class="form-control form-control-md" style="border-radius: 4px;">
                    </div>
                    <div class="col-6 mb-4">
                        <label for="hasta" class="font-weight-bold text-muted mb-1">Fecha de Culminación</label>
                        @error('hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="hasta" type="date" wire:model="hasta" class="form-control form-control-md" style="border-radius: 4px;">
                    </div>
                </div>    
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-experiencia')">Cerrar</button>
                @if($this->experiencia_id)
                    <button type="button" class="btn btn-danger font-weight-bold px-4" wire:click="eliminar" wire:confirm="¿Está seguro de que desea eliminar este registro?">Eliminar</button>
                @endif
                <button type="button" class="btn btn-primary font-weight-bold px-4" wire:click="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>