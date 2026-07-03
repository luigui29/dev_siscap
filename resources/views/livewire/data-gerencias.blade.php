<div class="row text-dark">
    <!-- Tarjeta con selección de gerencias y unidades -->
    <div class="col-3">
        <div class="card shadow-sm border-0 bg-white" style="position: sticky; top: 20px;">
            <div class="card-header border-bottom p-3">
                <h5 class="font-weight-bold mb-0 text-white">
                    <i class="fas fa-search mr-2"></i> Consultar Gerencia
                </h5>
            </div>

            <div class="card-body">
                <!-- Indicador de carga -->
                <div x-show="$store.gerencias.cargando" 
                        style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 10; justify-content: center; align-items: center; border-radius: 0 0 8px 8px;"
                        :class="$store.gerencias.cargando ? 'd-flex' : 'd-none'">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <div class="text-primary small">Cargando gerencias y unidades...</div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="gerencia_seleccionada" class="font-weight-bold text-muted">Selección de Gerencia:</label>
                    <select id="gerencia_seleccionada" class="form-control mb-2" wire:model.live="gerencia_seleccionada" :disabled="$store.gerencias.cargando">
                        <option value=""> Todas </option>
                        @foreach($this->gerencias as $g)
                            <option value="{{ $g->texto_gerencia }}">{{ $g->texto_gerencia }}</option>
                        @endforeach
                    </select>
                </div>

                @if($this->gerencia_seleccionada)
                    <div class="form-group mb-3">
                        <label for="unidad_seleccionada" class="font-weight-bold text-muted">Selección de Unidad:</label>
                        <select id="unidad_seleccionada" class="form-control mb-2" wire:model.live="unidad_seleccionada" :disabled="$store.gerencias.cargando || !$this->gerencia_seleccionada">
                            <option value=""> Todas </option>
                            @foreach($this->unidades as $u)
                                <option value="{{ $u->texto_unidad }}">{{ $u->texto_unidad }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <h5 class="font-weight-bold text-dark my-3">
                            {{ $this->gerencia_seleccionada }}
                        </h5>

                        <div class="my-2 border-top">
                            <h5 class="my-3 font-weight-bold text-left text-dark">
                                Exportar Resumen de la Gerencia
                            </h5>
                        </div>

                        <div class="text-left">
                            <button class="btn btn-md btn-pdf p-2" wire:click="resumen_gerencias('{{ $this->gerencia_seleccionada }}')">
                                <i class="fas fa-file-pdf mr-2"></i> PDF
                            </button>
                        </div>
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <p class="mb-0">Sin gerencia especificada.</p>
                    </div>
                @endif

                @if($this->unidad_seleccionada)
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <h5 class="font-weight-bold text-dark my-3">
                            {{ $this->unidad_seleccionada }}
                        </h5>
                    </div>
                @else
                    <div class="p-3 bg-light rounded text-center border mt-4">
                        <p class="mb-0">Sin unidad especificada.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Tarjeta con información de las capacitación por gerencias -->
    <div class="col-9">
        <div class="card shadow-sm border-0 bg-white">
            <div class="card-header border-bottom p-3">
                <h5 class="font-weight-bold mb-0 text-white">
                    <i class="fas fa-th-large mr-2"></i> Desarrollo de la Gerencia
                </h5>
            </div>

            <div class="card-body">
                <!-- Indicador de carga -->
                <div x-show="$store.gerencias.cargando" 
                        style="display: none; position: absolute; inset: 0; background: rgba(255,255,255,0.8); z-index: 10; justify-content: center; align-items: center; border-radius: 0 0 8px 8px;"
                        :class="$store.gerencias.cargando ? 'd-flex' : 'd-none'">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <div class="text-primary small">Cargando gerencias...</div>
                    </div>
                </div>
                <div class="table-responsive px-0 mb-4 border rounded">
                    <table class="table table-sm table-fixed-layout mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-2 align-middle" style="width: 30%">GERENCIA</th>
                                <th class="p-2 align-middle" style="width: 30%">UNIDAD</th>
                                <th class="p-2 text-center align-middle" style="width: 5%">Nº TRABAJADORES</th>
                                <th class="p-2 text-center align-middle" style="width: 10%">PRE-PROGRAMACIONES</th>
                                <th class="p-2 text-center align-middle" style="width: 10%">PROGRAMACIONES FINALES</th>
                                <th class="p-2 text-center align-middle" style="width: 10%">EJECUCIONES</th>
                                <th class="p-2 text-right align-middle" style="width: 5%">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->gerencia as $g)
                            <tr>
                                <td class="p-2 text-break align-middle"><strong>{{ $g->texto_gerencia }}</strong></td>
                                <td class="p-2 text-break align-middle">{{ $g->texto_unidad }}</td>
                                <td class="p-2 text-center align-middle">{{ $g->numero_empleados }}</td>
                                <td class="p-1 text-center align-middle">{{ $g->pre_program }}</td>
                                <td class="p-1 text-center align-middle">{{ $g->program_final }}</td>
                                <td class="p-1 text-center align-middle">{{ $g->ejecuciones }}</td>
                                <td class="p-2 text-right font-weight-bold align-middle">{{ $g->horas }} Horas</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted small">No hay datos registrados para mostrar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>