<div class="row text-dark">
    <!-- Tarjeta con selección de empleado -->
    <div class="col-4">
        <div class="card shadow-sm border-0 bg-white" style="position: sticky; top: 20px;">
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

                        <div class="text-left mt-2 pt-3 border-top">
                            <p class="mb-2 text-dark"><strong>Cargo:</strong> {{ $this->empleado_seleccionado->texto_cargo ?? 'No definido' }}</p>
                            <p class="mb-2 text-dark"><strong>Gerencia:</strong> {{ $this->empleado_seleccionado->texto_gerencia ?? 'No definido' }}</p>
                            <p class="mb-0 text-dark"><strong>Unidad:</strong> {{ $this->empleado_seleccionado->texto_unidad ?? 'No definido' }}</p>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <p class="mb-0">Sin empleado seleccionado.</p>
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
                <div class="d-flex flex-column justify-content-start mb-3 border-bottom">
                    <h5 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-graduation-cap text-primary mr-2"></i> Educación
                    </h5>
                    
                    <div class="col-auto p-0">
                        <button class="btn btn-md btn-primary mb-2 p-2 flex-grow-0" wire:click="$dispatch('abrir-modal-educacion', { ficha: {{ $ficha_seleccionada }} })">
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
                        <table class="table table-sm table-fixed-layout mb-0">
                            <thead class="bg-light">
                                    <tr>
                                        <th class="p-2" style="width: 20%;">NIVEL </th>
                                        <th class="p-2" style="width: 20%;">TÍTULO </th>
                                        <th class="p-2" style="width: 20%;">INSTITUTO</th>
                                        <th class="p-2 text-center" style="width: 10%;">GRADUADO</th>
                                        <th class="py-2 text-center" style="width: 10%;">ULTIMO NIVEL</th>
                                        <th class="p-2 text-center" style="width: 10%;">AÑO</th>
                                        <th class="p-2 text-center" style="width: 10%;">ACCIONES</th>
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

                <!-- Sección 2/4: Experiencia Laboral  -->
                <div class="d-flex flex-column justify-content-start mb-3 border-bottom">
                    <h5 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-briefcase text-primary mr-2"></i> Experiencia Laboral
                    </h5>
                    
                    <div class="col-auto p-0">
                        <button class="btn btn-md btn-primary mb-2 p-2 flex-grow-0" wire:click="$dispatch('abrir-modal-experiencia', { ficha: {{ $ficha_seleccionada }} })">
                            <i class="fas fa-plus mr-1"></i> Agregar
                        </button>
                    </div>

                    <!-- Experiencia Laboral Interna (VENPRECAR)-->
                    <h5 class="font-weight-bold text-dark mb-2">
                        Interna
                    </h5>

                    <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                        <!-- Indicador de carga -->    
                        <div x-show="$store.experiencias.cargando" 
                             style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                             :class="$store.experiencias.cargando ? 'd-flex' : 'd-none'">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <div class="text-primary small font-weight-bold">Cargando...</div>
                            </div>
                        </div>
                        <table class="table table-sm table-fixed-layout mb-0">
                            <thead class="bg-light">
                                    <tr>
                                        <th class="p-2" style="width: 20%;">CARGO </th>
                                        <th class="p-2" style="width: 25%;">EMPRESA </th>
                                        <th class="p-2" style="width: 15%;">DESDE </th>
                                        <th class="p-2" style="width: 15%;">HASTA </th>
                                        <th class="p-2" style="width: 25%;">OBSERVACIÓN
                                        </th>
                                        <th class="p-2 text-center">ACCIONES</th>
                                    </tr>
                            </thead>
                            <tbody>
                                @forelse($this->exp_internas as $e)
                                    <tr>
                                        <td class="p-2 font-weight-bold"> {{ $e->cargo_desempeñado }} </td>
                                        <td class="p-2"> {{ $e->empresa }} </td>
                                        <td class="p-2"> {{ $e->desde?->format('d-m-Y') }} </td>
                                        <td class="p-2"> {{ $e->hasta?->format('d-m-Y') }} </td>
                                        <td class="p-2"> {{ $e->observacion }} </td>
                                        <td class="p-2 text-center">
                                            <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('abrir-modal-experiencia', { id: {{ $e->id }} })">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">No hay experiencia laboral registrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Experiencia Laboral Externa -->
                    <h5 class="font-weight-bold text-dark mb-2">
                        Externa
                    </h5>

                    <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                        <!-- Indicador de carga -->    
                        <div x-show="$store.experiencias.cargando" 
                             style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                             :class="$store.experiencias.cargando ? 'd-flex' : 'd-none'">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <div class="text-primary small font-weight-bold">Cargando...</div>
                            </div>
                        </div>
                        <table class="table table-sm table-fixed-layout mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="p-2" style="width: 20%;">CARGO </th>
                                    <th class="p-2" style="width: 25%;">EMPRESA </th>
                                    <th class="p-2" style="width: 15%;">DESDE </th>
                                    <th class="p-2" style="width: 15%;">HASTA </th>
                                    <th class="p-2" style="width: 25%;">OBSERVACIÓN</th>
                                    <th class="p-2 text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->exp_externas as $e)
                                    <tr>
                                        <td class="p-2 font-weight-bold"> {{ $e->cargo_desempeñado }} </td>
                                        <td class="p-2"> {{ $e->empresa }} </td>
                                        <td class="p-2"> {{ $e->desde->format('d-m-Y') }} </td>
                                        <td class="p-2"> {{ $e->hasta?->format('d-m-Y') }} </td>
                                        <td class="p-2"> {{ $e->observacion }} </td>
                                        <td class="p-2 text-center">
                                            <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('abrir-modal-experiencia', { id: {{ $e->id }} })">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-3 text-muted">No hay experiencia laboral registrada.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sección 3/4: Nivel de Inglés -->
                <div class="d-flex flex-column justify-content-start mb-3 border-bottom">
                    <h5 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-language text-primary mr-2"></i> Nivel de Inglés
                    </h5>

                    <div class="col-auto p-0">
                        <button class="btn btn-md btn-primary mb-2 p-2 flex-grow-0" wire:click="$dispatch('abrir-modal-ingles', { ficha: {{ $ficha_seleccionada }} })">
                            <i class="fas fa-plus mr-1"></i> Gestionar
                        </button>
                    </div>

                    <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                        <!-- Indicador de carga -->    
                        <div x-show="$store.ingles.cargando" 
                             style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                             :class="$store.ingles.cargando ? 'd-flex' : 'd-none'">
                            <div class="text-center">
                                <div class="spinner-border text-primary mb-2" role="status"></div>
                                <div class="text-primary small font-weight-bold">Cargando...</div>
                            </div>
                        </div>
                        <table class="table table-sm table-fixed-layout mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="p-2 text-center" style="width: 10%;">INTROD. 1 </th>
                                    <th class="p-2 text-center" style="width: 10%;">INTROD. 2 </th>
                                    <th class="p-2 text-center" style="width: 10%;">BASICO BAJO </th>
                                    <th class="p-2 text-center" style="width: 10%;">BASICO ALTO </th>
                                    <th class="p-2 text-center" style="width: 15%;">INTERM. BAJO </th>
                                    <th class="p-2 text-center" style="width: 15%;">INTERM. ALTO </th>
                                    <th class="p-2 text-center" style="width: 15%;">AVANZD. BAJO </th>
                                    <th class="p-2 text-center" style="width: 15%;">AVANZD. ALTO </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->i1 ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->i2 ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->bb ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->ba ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->ib ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->ia ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->ab ? '✓' : '' }}</td>
                                    <td class="p-2 text-center">{{ $this->nivel_ingles?->aa ? '✓' : '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sección 4/4: Cursos -->
                <div class="d-flex flex-column justify-content-start mb-3">
                    <h5 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-tasks text-primary mr-2"></i>Capacitación y Desarrollo
                    </h5>

                    @forelse($this->cursos as $nombre_area => $cursos_area)
                        @include('partials.tabla-perfil-individual-cursos-por-area', [
                            'nombre_area' => $nombre_area,
                            'cursos_area' => $cursos_area
                        ])
                    @empty
                        <div class="p-3 bg-light rounded text-center border mt-4">
                            <p class="mb-0">No se encuentra participación registrada para el empleado seleccionado.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="p-3 bg-light rounded text-center border mt-4">
                    <p class="mb-0">La información del empleado seleccionado se mostrará aquí.</p>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>