<div class="modal fade" id="modal_ingles" tabindex="-1" aria-labelledby="modal_inglesLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="position: relative;">
            
            <!-- Indicador de carga -->
            <div wire:loading.flex wire:target="i1, i2, bb, ba, ib, ia, ab, aa" style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 1055; align-items: center; justify-content: center; border-radius: 12px;">
                <div class="text-center">
                    <div class="spinner-border text-primary mb-2" role="status"></div>
                    <div class="text-primary small font-weight-bold">Procesando...</div>
                </div>
            </div>

            <div class="modal-header text-white" style="background-color: #64748B; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title font-weight-bold" id="modal_inglesLabel">
                    <i class="fas fa-users mr-2"></i> Gestionar Nivel de Inglés del Empleado: {{ $this->nombre_empleado() }}
                </h5>
                <button type="button" class="close text-white" aria-label="Close" style="outline: none;" x-on:click="$dispatch('cerrar-modal-ingles')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-5">
                @error('nivel_ingles_unico')
                    <div class="text-danger font-weight-bold small">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ $message }}
                    </div>
                @enderror
                <div class="row p-4">
                    <div class="col-3 mb-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="i1" type="checkbox" wire:model.live="i1" class="custom-control-input">
                            <label for="i1" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Introductorio 1</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="i2" type="checkbox" wire:model.live="i2" class="custom-control-input">
                            <label for="i2" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Introductorio 2</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="bb" type="checkbox" wire:model.live="bb" class="custom-control-input">
                            <label for="bb" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Básico Bajo</label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="ba" type="checkbox" wire:model.live="ba" class="custom-control-input">
                            <label for="ba" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Básico Alto</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="ib" type="checkbox" wire:model.live="ib" class="custom-control-input">
                            <label for="ib" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Intermedio Bajo</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="ia" type="checkbox" wire:model.live="ia" class="custom-control-input">
                            <label for="ia" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Intermedio Alto</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="ab" type="checkbox" wire:model.live="ab" class="custom-control-input">
                            <label for="ab" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Avanzado Bajo</label>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="custom-control custom-switch pt-1">
                            <input id="aa" type="checkbox" wire:model.live="aa" class="custom-control-input">
                            <label for="aa" class="custom-control-label font-weight-bold text-muted mb-1 pt-1" style="line-height: 1.1;">Avanzado Alto</label>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-ingles')">Cerrar</button>
            </div>
        </div>
    </div>
</div>