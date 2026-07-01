<div class="row text-dark">
    <!-- Tarjeta con selección de empleado -->
    <div class="col-4">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-header border-bottom p-3">
                <h5 class="font-weight-bold mb-0 text-white">
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
                    <label for="ficha_seleccionada" class="font-weight-bold text-muted">Selección de empleado:</label>
                    <select id="ficha_seleccionada" class="form-control" wire:model.live="ficha_seleccionada" :disabled="$store.empleados.cargando">
                        <option value="">Haga clic aquí para ver un listado de empleados según los filtros usados</option>
                        @foreach($this->empleados as $e)
                            <option value="{{ $e->ficha }}">[{{ $e->ficha }}] - {{ $e->nombre_empleado }}</option>
                        @endforeach
                    </select>
                </div>
                @if($this->empleado_seleccionado)
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <div class="avatar avatar-text m-auto p-4 d-flex align-items-center justify-content-center text-white font-weight-bold">
                            {{ substr($this->empleado_seleccionado->nombre_empleado, 0, 2) }}
                        </div>
                        <h5 class="font-weight-bold text-dark mt-3 mb-2">
                            {{ $this->empleado_seleccionado->nombre_empleado }}
                        </h5>
                        <span class="badge badge-success p-2 text-uppercase font-weight-bold">
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

    <!-- Tarjeta con información del empleado seleccionado -->
    <div class="col-8">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-header border-bottom p-3">
                <h5 class="font-weight-bold mb-0 text-white">
                    <i class="fas fa-file-invoice mr-2 text-white"></i> Desarrollo del Empleado
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
            @if($this->empleado_seleccionado)
                <!-- Sección 1/4: Nivel Educativo  -->
                <div class="d-flex flex-column justify-content-start mb-3">
                    <h5 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-graduation-cap text-primary mr-2"></i> Educación
                    </h5>
                    
                    <div class="row">
                        <button class="btn btn-md btn-primary mb-2 p-2" wire:click="$dispatch('abrir-modal-educacion', { ficha: {{ $ficha_seleccionada }} })">
                            <i class="fas fa-plus mr-1"></i> Agregar
                        </button>
                    </div>
                
                    <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                        <!-- Indicador de carga -->    
                        <div x-show="$store.educaciones.cargando" 
                             style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                             :class="$store.educaciones.cargando ? 'd-flex' : 'd-none'">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <div class="text-primary small font-weight-bold">Cargando...</div>
                            </div>
                        </div>
                        <table class="table table-sm mb-0">
                            <thead class="bg-light">
                                    <tr>
                                        <th class="p-2">NIVEL </th>
                                        <th class="p-2">TÍTULO </th>
                                        <th class="p-2">INSTITUTO</th>
                                        <th class="p-2 text-center">GRADUADO</th>
                                        <th class="p-2 text-center">ULTIMO NIVEL</th>
                                        <th class="p-2 text-center">AÑO</th>
                                        <th class="p-2 text-center">ACCIONES</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @forelse($this->educaciones as $e)
                                    <tr>
                                        <td class="p-2 font-weight-bold">
                                            {{ $e->nivel_educativo }}
                                        </td>
                                        <td class="p-2">
                                            {{ $e->titulo }} <br>
                                            @if($e->especialidad)<small class="text-muted">{{ $e->especialidad }}</small>@endif
                                        </td>
                                        <td class="p-2">{{ $e->instituto }}</td>
                                        <td class="p-2 text-center">@if($e->graduado) &#10003 @endif</td>
                                        <td class="p-2 text-center">@if($e->ultimo_nivel) &#10003 @endif</td>
                                        <td class="p-2 text-center">{{ $e->fecha_culminado }}</td>
                                        <td class="p-2 text-center">
                                            <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('abrir-modal-educacion', { id: {{ $e->id }} })">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">No hay educación registrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="p-3 bg-light rounded text-center border mt-4">
                    <p class="mb-0 small">La información del empleado seleccionado se mostrará aquí.</p>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>