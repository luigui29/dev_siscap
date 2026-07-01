<div class="modal fade" id="modalProgramacionTrabajadores" tabindex="-1" aria-labelledby="modalProgramacionTrabajadoresLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header text-white" style="background-color: #64748B; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <h5 class="modal-title font-weight-bold" id="modalProgramacionTrabajadoresLabel">
                        <i class="fas fa-users mr-2"></i> Participantes del Curso: {{ $nombre }}
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="outline: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                        <th class="p-3">FICHA</th>
                                        <th class="p-3">CÉDULA</th>
                                        <th class="p-3">NOMBRE</th>
                                        <th class="p-3">UNIDAD</th>
                                        <th class="p-3">CARGO</th>
                                        <th class="p-3">GERENCIA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trabajadores as $trabajador)
                                        <tr>
                                            <td class="p-3"><span class="badge badge-light border">{{ $trabajador->ficha }}</span></td>
                                            <td class="p-3">{{ $trabajador->cedula ?? 'N/A' }}</td>
                                            <td class="p-3 font-weight-bold text-dark">{{ $trabajador->nombre_empleado }}</td>
                                            <td class="p-3 small text-secondary">{{ $trabajador->texto_unidad }}</td>
                                            <td class="p-3 small">{{ $trabajador->texto_cargo }}</td>
                                            <td class="p-3 small text-secondary">{{ $trabajador->texto_gerencia }}</td>
                                        </tr>
                                @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No hay trabajadores matriculados en este curso.</td>
                                        </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer" style="background-color: #f8fafc; border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                    <button type="button" class="btn btn-secondary font-weight-bold px-4" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>