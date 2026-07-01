<div class="row text-dark">
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
            <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                    <i class="fas fa-search mr-2"></i> Consultar Empleado
                </h5>
            </div>

            <div class="card-body">
                <!-- Indicador de carga -->
                <div x-show="$store.empleados.cargando" 
                     style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 10; justify-content: center; align-items: center; border-radius: 0 0 8px 8px;"
                     :class="$store.empleados.cargando ? 'd-flex' : 'd-none'">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <div class="text-primary small">Cargando empleados...</div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="ficha_seleccionada" class="font-weight-bold small text-muted">Selección de empleado:</label>
                    <select id="ficha_seleccionada" class="form-control" wire:model.live="ficha_seleccionada" :disabled="$store.empleados.cargando" style="border-radius: 4px;">
                        <option value="">Haga clic aquí para ver un listado de empleados según los filtros usados</option>
                        @foreach($this->empleados as $e)
                            <option value="{{ $e->ficha }}">[{{ $e->ficha }}] - {{ $e->nombre_empleado }}</option>
                        @endforeach
                    </select>
                </div>
                @if($this->empleado_seleccionado)
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <div class="avatar-text m-auto d-flex align-items-center justify-content-center text-white font-weight-bold" style="background-color: #5DADE2; width: 64px; height: 64px; border-radius: 50%; font-size: 1.5rem; border: 2px solid #FFF; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            {{ substr($this->empleado_seleccionado->nombre_empleado, 0, 2) }}
                        </div>
                        <h5 class="font-weight-bold text-dark mt-3 mb-1" style="font-size: 1.1rem;">
                            {{ $this->empleado_seleccionado->nombre_empleado }}
                        </h5>
                        <span class="badge badge-success px-2 py-1 mb-2 text-uppercase font-weight-bold" style="font-size: 0.7rem; border-radius: 50px;">
                            FICHA: {{ $this->empleado_seleccionado->ficha }}
                        </span>

                        <div class="text-left mt-2 pt-3 border-top" style="font-size: 0.85rem;">
                            <p class="mb-2 text-dark"><strong>Cargo:</strong> {{ $this->empleado_seleccionado->texto_cargo ?? 'No definido' }}</p>
                            <p class="mb-2 text-dark"><strong>Gerencia:</strong> {{ $this->empleado_seleccionado->texto_gerencia ?? 'No definido' }}</p>
                            <p class="mb-0 text-dark"><strong>Unidad:</strong> {{ $this->empleado_seleccionado->texto_unidad ?? 'No definido' }}</p>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <p class="mb-0 small">Sin empleado seleccionado.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>