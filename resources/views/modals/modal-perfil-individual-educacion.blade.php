<div class="modal fade" id="modal_educacion" tabindex="-1" aria-labelledby="modal_educacionLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="position: relative;" x-data="{ procesando: false }" @cerrar-modal-educacion.window="procesando = true" @listo-modal-educacion.window="procesando = false">
            
            <!-- Indicador de carga (Wire:loading para peticiones, Alpine para cierre) -->
            <div wire:loading.flex wire:target="guardar, eliminar" style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 1055; align-items: center; justify-content: center; border-radius: 12px;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div class="text-primary small font-weight-bold">Procesando...</div>
                </div>
            </div>
            <div x-show="procesando" style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 1055; align-items: center; justify-content: center; border-radius: 12px; display: none;" :class="procesando ? 'd-flex' : 'd-none'">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div class="text-primary small font-weight-bold">Procesando...</div>
                </div>
            </div>

            <div class="modal-header text-white" style="background-color: #64748B; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-weight-bold" id="modal_educacionLabel">
                    <i class="fas fa-users mr-2"></i> Gestionar Educación del Empleado: {{ $this->nombre_empleado() }}
                </h5>
                <button type="button" class="close text-white" aria-label="Close" style="outline: none;" x-on:click="$dispatch('cerrar-modal-educacion')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-5">
                <div class="row p-4">
                    <div class="col-4 mb-4">
                        <label for="nivel_educativo" class="font-weight-bold text-muted mb-1">Nivel Educativo</label>
                        @error('nivel_educativo') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="nivel_educativo" type="text" wire:model="nivel_educativo" class="form-control form-control-sm" placeholder="Ej: Bachillerato, Licenciatura..." style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="titulo" class="font-weight-bold text-muted mb-1">Título</label>
                        @error('titulo') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="titulo" type="text" wire:model="titulo" class="form-control form-control-sm" placeholder="Ej: Bachiller, Licenciado..." style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="especialidad" class="font-weight-bold text-muted mb-1">Especialidad</label>
                        @error('especialidad') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="especialidad" type="text" wire:model="especialidad" class="form-control form-control-sm" placeholder="Ej: Ciencias, Administración..." style="border-radius: 4px;">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="instituto" class="font-weight-bold text-muted mb-1">Instituto</label>
                        @error('instituto') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="instituto" type="text" wire:model="instituto" class="form-control form-control-sm" placeholder="Nombre de la institución, universidad..." style="border-radius: 4px;">
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="graduado" type="checkbox" wire:model="graduado" class="custom-control-input">
                            <label for="graduado" class="custom-control-label font-weight-bold text-muted mb-1 pt-1">Graduado</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="ultimo_nivel" type="checkbox" wire:model="ultimo_nivel" class="custom-control-input">
                            <label for="ultimo_nivel" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Nivel más reciente del empleado</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <label for="fecha_culminado" class="font-weight-bold text-muted mb-1">Año de culminación</label>
                        @error('fecha_culminado') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="fecha_culminado" type="number" wire:model="fecha_culminado" step="10" min="0" max="9999" class="form-control form-control-sm" placeholder="Ingrese el año de culminación" style="border-radius: 4px;">
                    </div>
                </div>    
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-educacion')">Cerrar</button>
                @if($this->educacion_id)
                    <button type="button" class="btn btn-danger font-weight-bold px-4" wire:click="eliminar" wire:confirm="¿Está seguro de que desea eliminar este registro?">Eliminar</button>
                @endif
                <button type="button" class="btn btn-primary font-weight-bold px-4" wire:click="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>