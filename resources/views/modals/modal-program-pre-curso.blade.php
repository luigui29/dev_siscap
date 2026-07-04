<div class="modal fade" id="modal_pre_program_curso" tabindex="-1" aria-labelledby="modal_pre_program_cursoLabel" aria-hidden="true" wire:ignore.self>
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
                <h5 class="modal-title font-weight-bold" id="modal_pre_program_cursoLabel">
                    <i class="fas fa-chalkboard-teacher mr-2"></i> {{ $this->programacion_id ? 'Editar Pre-Programación' : 'Añadir Pre-Programación' }}
                </h5>
                <button type="button" class="close text-white" aria-label="Close" style="outline: none;" x-on:click="$dispatch('cerrar-modal-pre-program-curso')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-5">
                <div class="row p-4">
                    <!-- Selects de área, actividad, sub-actividad y facilitador -->
                    <div class="col-6 mb-4">
                        <label for="area_modal" class="font-weight-bold text-muted mb-1">Área</label>
                        <select id="area_modal" class="form-control" wire:model.live="area_seleccionada">
                            <option value="">Seleccione un área</option>
                            @foreach($this->areas as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="actividad_modal" class="font-weight-bold text-muted mb-1">Actividad</label>
                        @error('actividad_seleccionada') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <select id="actividad_modal" class="form-control" wire:model.live="actividad_seleccionada">
                            <option value="">Seleccione una actividad</option>
                            @foreach($this->actividades as $a)
                                <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="subactividad_modal" class="font-weight-bold text-muted mb-1">Sub-Actividad</label>
                        @error('subactividad_seleccionada') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <select id="subactividad_modal" class="form-control" wire:model.live="subactividad_seleccionada">
                            <option value="">Seleccione una sub-actividad</option>
                            @foreach($this->subactividades as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-4">
                        <label for="facilitador_modal" class="font-weight-bold text-muted mb-1">Facilitador</label>
                        @error('facilitador_seleccionado') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <select id="facilitador_modal" class="form-control" wire:model.live="facilitador_seleccionado">
                            <option value="">Seleccione un facilitador</option>
                            @foreach($this->facilitadores as $f)
                                <option value="{{ $f->id }}">{{ $f->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Campos editables -->
                    <div class="col-6 mb-4">
                        <label for="institucion_modal" class="font-weight-bold text-muted mb-1">Institución</label>
                        @error('institucion') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="institucion_modal" type="text" wire:model="institucion" class="form-control form-control-md" placeholder="Nombre de la institución" style="border-radius: 4px;">
                    </div>
                    <div class="col-3 mb-4">
                        <label for="fecha_modal" class="font-weight-bold text-muted mb-1">Fecha</label>
                        @error('fecha') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="fecha_modal" type="date" wire:model="fecha" class="form-control form-control-md" style="border-radius: 4px;">
                    </div>
                    <div class="col-9 mb-4">
                        <label for="lugar_modal" class="font-weight-bold text-muted mb-1">Lugar</label>
                        @error('lugar') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="lugar_modal" type="text" wire:model="lugar" class="form-control form-control-md" placeholder="Lugar de la actividad" style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="desde_modal" class="font-weight-bold text-muted mb-1">Hora de Inicio</label>
                        @error('desde') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="desde_modal" type="time" wire:model="desde" class="form-control form-control-md" style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="hasta_modal" class="font-weight-bold text-muted mb-1">Hora de Fin</label>
                        @error('hasta') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="hasta_modal" type="time" wire:model="hasta" class="form-control form-control-md" style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mb-4">
                        <label for="duracion_modal" class="font-weight-bold text-muted mb-1">Duración (horas)</label>
                        @error('duracion') <span class="text-danger font-weight-bold"><i class="fas fa-info-circle ml-1 mr-2"></i>{{ $message }}</span> @enderror
                        <input id="duracion_modal" type="number" step="0.5" min="0" wire:model="duracion" class="form-control form-control-md" placeholder="Duración en horas" style="border-radius: 4px;">
                    </div>
                    <div class="col-4 mt-2">
                        <div class="custom-control custom-switch pt-1">
                            <input id="extra_modal" type="checkbox" wire:model="extra" class="custom-control-input">
                            <label for="extra_modal" class="custom-control-label font-weight-bold text-muted mb-1 pt-1">Extra</label>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-pre-program-curso')">Cerrar</button>
                @if($this->programacion_id)
                    <button type="button" class="btn btn-danger font-weight-bold px-4" wire:click="eliminar" wire:confirm="¿Está seguro de que desea eliminar este registro?">Eliminar</button>
                @endif
                <button type="button" class="btn btn-primary font-weight-bold px-4" wire:click="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>