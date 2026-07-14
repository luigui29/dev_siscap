<div class="modal fade" id="modal_program_empleados" tabindex="-1" aria-labelledby="modal_program_empleadosLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: #64748B; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title font-weight-bold" id="modal_program_empleadosLabel">
                        <i class="fas fa-users mr-2"></i> Participantes del Curso
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body p-0" style="position: relative;">
                <!-- Indicador de carga -->    
                <div x-show="$store.matriculados.cargando" 
                        style="position: absolute; inset: 0; background: rgba(255,255,255,0.7); z-index: 10; justify-content: center; align-items: center; border-radius: 4px; display: none;" 
                        :class="$store.matriculados.cargando ? 'd-flex' : 'd-none'">
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-2" role="status"></div>
                        <div class="text-primary small font-weight-bold">Cargando...</div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-fixed-layout mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="p-2 text-center align-middle" style="width: 10%;">FICHA </th>
                                <th class="p-2 text-left align-middle" style="width: 30%;">NOMBRE </th>
                                <th class="p-2 text-center align-middle" style="width: 20%;">GERENCIA </th>
                                <th class="p-2 text-center align-middle" style="width: 20%;">CARGO </th>
                                <th class="py-2 text-center align-middle" style="width: 20%;">UNIDAD </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($this->empleados_matriculados as $e)
                                <tr>
                                    <td class="p-2 text-center font-weight-bold align-middle">{{ $e->ficha }}</td>
                                    <td class="p-2 text-left align-middle"> {{ $e->nombre_empleado }} <br><small class="text-muted">C.I.: {{ $e->cedula }}</small></td>
                                    <td class="p-2 text-center align-middle">{{ $e->texto_gerencia }}</td>
                                    <td class="p-2 text-center align-middle">{{ $e->texto_cargo }}</td>
                                    <td class="p-2 text-center align-middle">{{ $e->texto_unidad }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">No hay empleados matriculados en este curso.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary font-weight-bold px-4" x-on:click="$dispatch('cerrar-modal-program-empleados')">Cerrar</button>
            </div>
        </div>
    </div>
</div>