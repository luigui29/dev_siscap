<div class="modal fade" id="modal_pre_program_empleados" tabindex="-1" aria-labelledby="modal_pre_program_empleadosLabel" aria-hidden="true" wire:ignore.self>
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
                <h5 class="modal-title font-weight-bold" id="modal_pre_program_empleadosLabel">
                    <i class="fas fa-chalkboard-teacher mr-2"></i> Matricular Empleados
                </h5>
                <button type="button" class="close text-white" aria-label="Close" style="outline: none;" x-on:click="$dispatch('cerrar-modal-pre-program-empleados')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body py-3">
                <div class="row p-4">
                    <livewire:filtro-empleados />

                    <!-- Resultados de búsqueda para matricular empleados-->
                    <div class='col-6'>
                        <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                            <!-- Indicador de carga (mostrar también si se eliminan empleados matriculados de la tabla de abajo)-->    
                            <div x-show="$store.empleados.cargando" 
                                    style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                                    :class="$store.empleados.cargando ? 'd-flex' : 'd-none'">
                                <div class="text-center">
                                    <div class="spinner-border text-primary mb-2" role="status"></div>
                                    <div class="text-primary small font-weight-bold">Cargando...</div>
                                </div>
                            </div>
                            <table class="table table-sm table-fixed-layout mb-0">
                                <thead class="bg-light">
                                        <tr>
                                            <th class="p-2 text-left align-middle" style="width: 40%;">NOMBRE </th>
                                            <th class="p-2 text-left align-middle" style="width: 40%;">GERENCIA </th>
                                            <th class="p-2 text-center align-middle" style="width: 20%;">ACCIONES </th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @forelse($this->empleados_buscados as $e)
                                        <tr>
                                            <td class="p-2 text-left font-weight-bold align-middle">{{ $e->nombre }}<br><em class="small"> Ficha: {{$e->ficha}} | C.I. {{$e->cedula}} </em></td>
                                            <td class="p-2 text-left font-weight-bold align-middle">{{ $e->texto_gerencia }}<br><em class="small"> Unidad: {{ $e->texto_unidad }} | Cargo: {{$e->texto_cargo}} </em></td>
                                            <td class="p-2 text-center align-middle">
                                                <button class="btn btn-sm btn-outline-primary" wire:click="$dispatch('agregar_empleado', { ficha: {{ $e->ficha }} })">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">No se encontraron empleados registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Empleados ya matriculados para edición -->
                     <div class='col-6'>
                        <div class="table-responsive px-0 mb-4 border rounded" style="position: relative;">
                            <!-- Indicador de carga (cambiar para que se muestre al eliminar o agregar empleados matriculados) -->    
                            <div x-show="$store.empleados.cargando" 
                                    style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                                    :class="$store.empleados.cargando ? 'd-flex' : 'd-none'">
                                <div class="text-center">
                                    <div class="spinner-border text-primary mb-2" role="status"></div>
                                    <div class="text-primary small font-weight-bold">Cargando...</div>
                                </div>
                            </div>
                            <table class="table table-sm table-fixed-layout mb-0">
                                <thead class="bg-light">
                                        <tr>
                                            <th class="p-2 text-left align-middle" style="width: 40%;">NOMBRE </th>
                                            <th class="p-2 text-left align-middle" style="width: 40%;">GERENCIA </th>
                                            <th class="p-2 text-center align-middle" style="width: 20%;">ACCIONES </th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @forelse($this->empleados_matriculados as $e)
                                        <tr>
                                            <td class="p-2 text-left font-weight-bold align-middle">{{ $e->nombre }}<br><em class="small"> Ficha: {{$e->ficha}} | C.I. {{$e->cedula}} </em></td>
                                            <td class="p-2 text-left font-weight-bold align-middle">{{ $e->texto_gerencia }}<br><em class="small"> Unidad: {{ $e->texto_unidad }} | Cargo: {{$e->texto_cargo}} </em></td>
                                            <td class="p-2 text-center align-middle">
                                                <button class="btn btn-sm btn-outline-danger" wire:click="$dispatch('quitar_empleado', { ficha: {{ $e->ficha }} })">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">No se encontraron empleados registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>    
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-pre-program-empleados')">Cerrar</button>
                <button class="btn btn-md btn-outline-secondary" wire:click="limpiar">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
                <button type="button" class="btn btn-primary font-weight-bold px-4" wire:click="guardar">Guardar</button>
            </div>
        </div>
    </div>
</div>