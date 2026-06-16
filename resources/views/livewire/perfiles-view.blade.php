<div class="container-fluid py-4 mx-auto" style="background-color: #F2F2F2;">
     <!-- Notificacion (Toast) -->
     @if($notificacion)
          <div class="alert alert-{{ $notificacion['tipo'] === 'success' ? 'success' : ($notificacion['tipo'] === 'danger' ? 'danger' : 'info') }} alert-dismissible fade show shadow border-0 position-fixed d-flex align-items-center" role="alert" style="right: 20px; top: 80px; z-index: 1060; gap: 10px; border-radius: 8px; min-width: 320px;">
               <i class="fas fa-info-circle" style="font-size: 1.25rem;"></i>
               <div>{{ $notificacion['mensaje'] }}</div>
               <button type="button" class="close ml-auto" wire:click="limpiarNotificacion" style="outline: none;">
                    <span>&times;</span>
               </button>
          </div>
     @endif

     <!-- Cabecera -->
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mx-5 text-dark">
          <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
               Gestión de Perfiles
          </h3>
     </div>

     <!-- PERFIL INDIVIDUAL -->
     @if($pestania_activa === 'individual')
          <div class="mx-5">
               @include('partials.filtro-empleados')
          </div>

          <div class="row mx-5 text-dark">
               <div class="col-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-search mr-2"></i> Consultar Empleado
                              </h5>
                         </div>

                         <div class="card-body">
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small text-muted">SELECCIONAR EMPLEADO</label>
                                   <select class="form-control" wire:model.live="ficha_usuario_seleccionado" style="height: 44px; font-weight: 600;">
                                        @foreach($empleados as $e)
                                             <option value="{{ $e->ficha }}">[{{ $e->ficha }}] - {{ $e->nombre_empleado }}</option>
                                        @endforeach
                                   </select>
                              </div>

                              @php
                                   $active_employee = $empleados->firstWhere('ficha', $ficha_usuario_seleccionado);
                              @endphp

                              @if($active_employee)
                                   <div class="p-3 bg-light rounded text-center border mt-4">
                                        <div class="avatar-text m-auto d-flex align-items-center justify-content-center text-white font-weight-bold" style="background-color: #5DADE2; width: 64px; height: 64px; border-radius: 50%; font-size: 1.5rem; border: 2px solid #FFF; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                             {{ substr($active_employee->nombre_empleado, 0, 2) }}
                                        </div>
                                        <h5 class="font-weight-bold text-dark mt-3 mb-1" style="font-size: 1.1rem;">
                                             {{ $active_employee->nombre_empleado }}
                                        </h5>
                                        <span class="badge badge-success px-2 py-1 mb-2 text-uppercase font-weight-bold" style="font-size: 0.7rem; border-radius: 50px;">
                                             FICHA: {{ $active_employee->ficha }}
                                        </span>

                                        <div class="text-left mt-2 pt-3 border-top" style="font-size: 0.85rem;">
                                             <p class="mb-2 text-dark"><strong>Cargo:</strong> {{ $active_employee->texto_cargo ?? 'No definido' }}</p>
                                             <p class="mb-2 text-dark"><strong>Gerencia:</strong> {{ $active_employee->texto_gerencia ?? 'No definida' }}</p>
                                             <p class="mb-0 text-dark"><strong>Unidad:</strong> {{ $active_employee->texto_unidad ?? 'No definida' }}</p>
                                        </div>
                                   </div>
                              @endif
                         </div>
                    </div>

                    <!-- Exportar Resumen del Trabajador -->
                    <hr class="my-4">

                    <h6 class="font-weight-bold text-dark my-2">
                         Exportar Resumen del Trabajador
                    </h6>

                    <div class="mt-3 mb-2 d-flex">     
                         <button wire:click="exportarPerfilExcel" wire:loading.attr="disabled" class="btn btn-sm btn-excel font-weight-bold mr-2" style="width: 100px">
                              <span wire:loading.remove wire:target="exportarPerfilExcel">
                                   <i class="fas fa-file-excel mr-1"></i> Excel
                              </span>
                              <span wire:loading wire:target="exportarPerfilExcel">
                                   <i class="fas fa-spinner fa-spin mr-1"></i> Excel
                              </span>
                         </button>
                         <button wire:click="exportarPerfilPdf" wire:loading.attr="disabled" class="btn btn-sm btn-pdf font-weight-bold" style="width: 100px">
                              <span wire:loading.remove wire:target="exportarPerfilPdf">
                                   <i class="fas fa-file-pdf mr-1"></i> PDF
                              </span>
                              <span wire:loading wire:target="exportarPerfilPdf">
                                   <i class="fas fa-spinner fa-spin mr-1"></i> PDF
                              </span>
                         </button>
                    </div>
               </div>

               <div class="col-12 col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-file-invoice mr-2 text-white"></i> Desarrollo Académico & Técnico del Empleado
                              </h5>
                         </div>

                         <div class="p-4">
                              
                              <!-- Sección 1: Nivel Educativo  -->
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                   <h6 class="font-weight-bold text-dark mb-0">
                                        <i class="fas fa-graduation-cap text-primary mr-2"></i> Formación Educativa / Títulos Obtenidos
                                   </h6>
                              </div>

                              <div class="table-responsive mb-4 border rounded">
                                   <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2" style="font-size: 0.75rem;">NIVEL DE EDUCACIÓN</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">TÍTULO / CARRERA TÉCNICA</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">INSTITUTO</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">GRADUADO</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">ULTIMO NIVEL</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">AÑO</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem; width: 40px;"></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($educacionesDb as $edu)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">
                                                            {{ $edu->nivel_educativo }}
                                                       </td>
                                                       <td class="p-2" style="font-size: 0.85rem;">
                                                            {{ $edu->titulo }} <br>
                                                            @if($edu->especialidad)<small class="text-muted">{{ $edu->especialidad }}</small>@endif
                                                       </td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $edu->instituto }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">@if($edu->graduado) &#10003 @endif</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">@if($edu->ultimo_nivel) &#10003 @endif</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ $edu->fecha_culminado }}</td>
                                                       <td class="p-2 text-center" style="white-space: nowrap;">
                                                            <button wire:click="cargarEducacionParaEdicion({{ $edu->id }})" class="btn btn-sm btn-link text-primary p-0 m-0 mr-2"><i class="fas fa-edit"></i></button>
                                                            <button wire:confirm="¿Está seguro de que desea eliminar este registro de educación?" wire:click="eliminarEducacion({{ $edu->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
                                                       </td>
                                                  </tr>
                                             @empty
                                                  <tr>
                                                       <td colspan="5" class="text-center py-3 text-muted small">No hay formación previa cargada.</td>
                                                  </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>

                              <!-- Añadir Educación -->
                              <div class="p-3 border rounded bg-light mb-4">
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-{{ $edu_id_editando ? 'edit' : 'plus-circle' }} text-primary"></i> {{ $edu_id_editando ? 'Editar Registro de Educación' : 'Ingresar Registro de Educación' }}</strong>
                                   <div class="row">
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_nivel_educativo" placeholder="Nivel Educativo">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_titulo" placeholder="Título Obtenido (Opcional)">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_especialidad" placeholder="Especialidad (Opcional)">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_instituto" placeholder="Instituto/Universidad (Opcional)">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <label for="educacion_fecha_culminado" class="small text-muted mb-0">Culminación (Opcional)</label>
                                             <input id="educacion_fecha_culminado" type="date" class="form-control form-control-sm" wire:model="edu_fecha_culminado" placeholder="Fecha Culminado">
                                        </div>
                                        <div class="col-md-3 form-group mb-2 d-flex align-items-end justify-content-center">
                                             <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" id="edu_graduado" wire:model="edu_graduado">
                                                  <label class="custom-control-label font-weight-bold small" for="edu_graduado">Graduado</label>
                                             </div>
                                        </div>
                                        <div class="col-md-3 form-group mb-2 d-flex align-items-end justify-content-center">
                                             <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" id="edu_ultimo_nivel" wire:model="edu_ultimo_nivel">
                                                  <label class="custom-control-label font-weight-bold small" for="edu_ultimo_nivel">Último Nivel</label>
                                             </div>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-end justify-content-center">
                                             @if($edu_id_editando)
                                                  <div class="btn-group w-100">
                                                       <button wire:click="agregarEducacion" class="btn btn-sm btn-success">Actualizar</button>
                                                       <button wire:click="cancelarEdicionEducacion" class="btn btn-sm btn-secondary">Cancelar</button>
                                                  </div>
                                             @else
                                                  <button wire:click="agregarEducacion" class="btn btn-sm btn-primary w-100">Cargar</button>
                                             @endif
                                        </div>
                                   </div>
                              </div>

                              <!-- Sección 2: Experiencia Laboral -->
                              <hr class="my-4">

                              <div class="d-flex justify-content-between align-items-center mb-3">
                                   <h6 class="font-weight-bold text-dark mb-0">
                                        <i class="fas fa-briefcase text-primary mr-2"></i> Experiencia Laboral 
                                   </h6>
                              </div>

                              <h6 class="font-weight-bold text-dark mt-3 mb-2 small"> Experiencia Laboral Interna </h6>
                              <div class="table-responsive mb-4 border rounded">
                                   <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2" style="font-size: 0.75rem;">CARGO DESEMPEÑADO</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">EMPRESA</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">DESDE/HASTA</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">OBSERVACIONES</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem; width: 40px;"></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($experienciasInternas as $exp)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">{{ $exp->cargo_desempeñado }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $exp->empresa }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('Y-m-d') : '' }} / {{ $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('Y-m-d') : 'Actualidad' }}</td>
                                                       <td class="p-2 text-muted small" style="font-size: 0.85rem;">{{ $exp->observacion }}</td>
                                                       <td class="p-2 text-center" style="white-space: nowrap;">
                                                            <button wire:click="cargarExperienciaParaEdicion({{ $exp->id }})" class="btn btn-sm btn-link text-primary p-0 m-0 mr-2"><i class="fas fa-edit"></i></button>
                                                            <button wire:confirm="¿Está seguro de que desea eliminar esta experiencia laboral interna?" wire:click="eliminarExperiencia({{ $exp->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
                                                       </td>
                                                  </tr>
                                             @empty
                                                  <tr>
                                                       <td colspan="5" class="text-center py-3 text-muted small">No hay experiencia interna cargada.</td>
                                                  </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>

                              <h6 class="font-weight-bold text-dark mt-3 mb-2 small"> Experiencia Laboral Externa</h6>
                              <div class="table-responsive mb-4 border rounded">
                                   <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2" style="font-size: 0.75rem;">CARGO DESEMPEÑADO</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">EMPRESA</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">DESDE/HASTA</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">OBSERVACIONES</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem; width: 40px;"></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($experienciasExternas as $exp)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">{{ $exp->cargo_desempeñado }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $exp->empresa }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ $exp->desde ? \Carbon\Carbon::parse($exp->desde)->format('Y-m-d') : '' }} / {{ $exp->hasta ? \Carbon\Carbon::parse($exp->hasta)->format('Y-m-d') : 'Actualidad' }}</td>
                                                       <td class="p-2 text-muted small" style="font-size: 0.85rem;">{{ $exp->observacion }}</td>
                                                       <td class="p-2 text-center" style="white-space: nowrap;">
                                                            <button wire:click="cargarExperienciaParaEdicion({{ $exp->id }})" class="btn btn-sm btn-link text-primary p-0 m-0 mr-2"><i class="fas fa-edit"></i></button>
                                                            <button wire:confirm="¿Está seguro de que desea eliminar esta experiencia laboral externa?" wire:click="eliminarExperiencia({{ $exp->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
                                                       </td>
                                                  </tr>
                                             @empty
                                                  <tr>
                                                       <td colspan="5" class="text-center py-3 text-muted small">No hay experiencia externa cargada.</td>
                                                  </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>

                              <!-- Añadir Experiencia Laboral -->
                              <div class="p-3 border rounded bg-light mb-4">
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-{{ $exp_id_editando ? 'edit' : 'plus-circle' }} text-primary"></i> {{ $exp_id_editando ? 'Editar Experiencia Laboral' : 'Ingresar Experiencia Laboral' }}</strong>
                                   <div class="row">
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_cargo" placeholder="Cargo Desempeñado">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_empresa" placeholder="Empresa (Opcional)">
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-3 form-group mb-2 d-flex align-items-end">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_observacion" placeholder="Observaciones (Opcional)">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <label for="experiencia_desde" class="small text-muted mb-0">Desde</label>
                                             <input id="experiencia_desde" type="date" class="form-control form-control-sm" wire:model="exp_desde">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <label for="experiencia_hasta" class="small text-muted mb-0">Hasta (Opcional)</label>
                                             <input id="experiencia_hasta" type="date" class="form-control form-control-sm" wire:model="exp_hasta">
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-end">
                                             @if($exp_id_editando)
                                                  <div class="btn-group w-100">
                                                       <button wire:click="agregarExperiencia" class="btn btn-sm btn-success">Actualizar</button>
                                                       <button wire:click="cancelarEdicionExperiencia" class="btn btn-sm btn-secondary">Cancelar</button>
                                                  </div>
                                             @else
                                                  <button wire:click="agregarExperiencia" class="btn btn-sm btn-primary w-100">Cargar</button>
                                             @endif
                                        </div>
                                   </div>
                              </div>

                              <!-- Sección 3: Nivel de Inglés -->
                              <hr class="my-4">

                              <h6 class="font-weight-bold text-dark mb-2">
                                   <i class="fas fa-language text-primary mr-2"></i> Nivel de Competencia en Inglés Técnico
                              </h6>
                              <p class="text-secondary small mb-3">Marque los niveles correspondientes aprobados validamente según directrices de RRHH:</p>

                              <div class="p-3 border rounded bg-light row mx-0">
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_i1" wire:click="alternarIngles('i1')" @if(optional($inglesDb)->i1) checked @endif wire:key="chk_i1_{{ optional($inglesDb)->i1 ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_i1">Instrumental 1 (I1)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_i2" wire:click="alternarIngles('i2')" @if(optional($inglesDb)->i2) checked @endif wire:key="chk_i2_{{ optional($inglesDb)->i2 ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_i2">Instrumental 2 (I2)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_bb" wire:click="alternarIngles('bb')" @if(optional($inglesDb)->bb) checked @endif wire:key="chk_bb_{{ optional($inglesDb)->bb ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_bb">Básico Básico (BB)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_ba" wire:click="alternarIngles('ba')" @if(optional($inglesDb)->ba) checked @endif wire:key="chk_ba_{{ optional($inglesDb)->ba ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_ba">Básico Alto (BA)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_ib" wire:click="alternarIngles('ib')" @if(optional($inglesDb)->ib) checked @endif wire:key="chk_ib_{{ optional($inglesDb)->ib ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_ib">Intermedio Básico (IB)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_ia" wire:click="alternarIngles('ia')" @if(optional($inglesDb)->ia) checked @endif wire:key="chk_ia_{{ optional($inglesDb)->ia ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_ia">Intermedio Alto (IA)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_ab" wire:click="alternarIngles('ab')" @if(optional($inglesDb)->ab) checked @endif wire:key="chk_ab_{{ optional($inglesDb)->ab ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_ab">Avanzado Básico (AB)</label>
                                        </div>
                                   </div>
                                   <div class="col-md-3 mb-3">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="ing_aa" wire:click="alternarIngles('aa')" @if(optional($inglesDb)->aa) checked @endif wire:key="chk_aa_{{ optional($inglesDb)->aa ? '1' : '0' }}">
                                             <label class="custom-control-label font-weight-bold" for="ing_aa">Avanzado Alto (AA)</label>
                                        </div>
                                   </div>
                               </div>

                               <!-- Sección 4: Cursos de Capacitación -->
                               <hr class="my-4">

                               <h6 class="font-weight-bold text-dark mb-3">
                                    <i class="fas fa-chalkboard-teacher text-primary mr-2"></i> Participación en Cursos de Capacitación
                               </h6>

                               @foreach($cursosPorArea as $areaData)
                                    <h6 class="font-weight-bold text-dark mt-3 mb-2 small"> ÁREA: {{ $areaData['area_nombre'] }} </h6>
                                    <div class="table-responsive mb-4 border rounded">
                                         <table class="table table-sm mb-0">
                                              <thead class="bg-light">
                                                   <tr>
                                                        <th class="p-2" style="font-size: 0.75rem;">CURSO / PROGRAMA</th>
                                                        <th class="p-2 text-center" style="font-size: 0.75rem; width: 15%;">FECHA</th>
                                                        <th class="p-2 text-center" style="font-size: 0.75rem; width: 15%;">DURACIÓN</th>
                                                        <th class="p-2 text-center" style="font-size: 0.75rem; width: 15%;">ESTATUS</th>
                                                        <th class="p-2 text-center" style="font-size: 0.75rem; width: 20%;">CAUSA</th>
                                                   </tr>
                                              </thead>
                                              <tbody>
                                                   @forelse($areaData['cursos'] as $curso)
                                                        <tr>
                                                             <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">{{ $curso->nombre }}</td>
                                                             <td class="p-2 text-center" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($curso->fecha)->format('Y-m-d') }}</td>
                                                             <td class="p-2 text-center" style="font-size: 0.85rem;">{{ number_format($curso->duracion, 1) }} Hrs</td>
                                                             <td class="p-2 text-center" style="font-size: 0.85rem;">
                                                                  @if(is_null($curso->estatus))
                                                                       <span class="badge badge-warning px-2 py-1 text-dark" style="border-radius: 4px;">Pendiente</span>
                                                                  @elseif($curso->estatus)
                                                                       <span class="badge badge-success px-2 py-1" style="border-radius: 4px;">Asistente</span>
                                                                  @else
                                                                       <span class="badge badge-danger px-2 py-1" style="border-radius: 4px;">Inasistente</span>
                                                                  @endif
                                                             </td>
                                                             <td class="p-2 text-center text-muted" style="font-size: 0.85rem;">
                                                                  {{ $curso->causa ?: 'N/A' }}
                                                             </td>
                                                        </tr>
                                                   @empty
                                                        <tr>
                                                             <td colspan="5" class="text-center py-3 text-muted small">No hay participación en cursos de esta área.</td>
                                                        </tr>
                                                   @endforelse
                                              </tbody>
                                         </table>
                                    </div>
                               @endforeach
                          </div>
                     </div>
               </div>
          </div>
     @endif

     <!-- TAB 2: MATRIZ HORAS GERENCIAS -->
     @if($pestania_activa === 'gerencia')
          <div class="row mx-5 text-dark">
               <div class="col-3 pr-2 pl-0">
                    <div class="card shadow-sm border-0 mb-4 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-filter mr-2"></i> Filtro de Gerencias
                              </h5>
                         </div>
                         <div class="card-body p-3 bg-light">
                              <div class="row">
                                   <div class="col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-sitemap mr-1"></i> Gerencia</label>
                                        <input type="text" list="lista_gerencias" class="form-control form-control-sm" wire:model="filtro_gerencia" placeholder="Escriba o seleccione una gerencia...">
                                        <datalist id="lista_gerencias">
                                             @foreach($gerencias_opciones as $opcion_gerencia)
                                                  <option value="{{ $opcion_gerencia }}"></option>
                                             @endforeach
                                        </datalist>
                                   </div>
                                   <div class="col-12 mb-2">
                                        <label class="small font-weight-bold text-muted mb-1"><i class="fas fa-users-cog mr-1"></i> Unidad</label>
                                        <input type="text" list="lista_unidades" class="form-control form-control-sm" wire:model="filtro_unidad" placeholder="Escriba o seleccione una unidad...">
                                        <datalist id="lista_unidades">
                                             @foreach($unidades_opciones as $opcion_unidad)
                                                  <option value="{{ $opcion_unidad }}"></option>
                                             @endforeach
                                        </datalist>
                                   </div>
                                   <div class="col-12 my-2">
                                        <div class="d-flex">
                                             <button class="btn btn-sm btn-primary w-50 mr-2" wire:click="buscarResultados">
                                                  <i class="fas fa-search mr-1"></i> Buscar
                                             </button>
                                             <button class="btn btn-sm btn-outline-secondary w-50" wire:click="limpiarFiltros">
                                                  <i class="fas fa-eraser mr-1"></i> Limpiar
                                             </button>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>

                    <hr class="my-4">

                    <div class="container mt-2">
                         <h6 class="font-weight-bold text-dark my-2">
                              Exportar Resumen de Gerencia
                         </h6>

                         <div class="d-flex mt-2">
                              <button class="btn btn-sm btn-excel font-weight-bold w-50">
                                   <i class="fas fa-file-excel mr-1"></i> Excel
                              </button>
                         </div>
                    </div>
               </div>
               <div class="col-9 pl-2 pr-0">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-th-large mr-2"></i> Perfil Gerencial
                              </h5>
                         </div>

                         <div class="card-body">
                              <div class="table-responsive border rounded">
                                   <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2">{{ strtoupper($nivel_agrupacion) }}</th>
                                                  <th class="p-2 text-center">Nº TRABAJADORES</th>
                                                  <th class="p-2 text-center">CURSOS APROBADOS</th>
                                                  <th class="p-2 text-center">CURSOS EJECUTADOS</th>
                                                  <th class="p-2 text-center">HORAS HOMBRE TOTAL</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($matriz_datos as $fila)
                                             <tr>
                                                  <td class="p-2"><strong>{{ $fila['nombre'] }}</strong></td>
                                                  <td class="p-2 text-center">{{ $fila['trabajadores'] }} Trabajadores</td>
                                                  <td class="p-2 text-center"><span class="badge badge-primary px-2 font-weight-bold">{{ $fila['aprobados'] }}</span></td>
                                                  <td class="p-2 text-center"><span class="badge badge-success px-2 font-weight-bold">{{ $fila['ejecutados'] }}</span></td>
                                                  <td class="p-2 text-center font-weight-bold text-dark">{{ $fila['horas'] }} Horas</td>
                                             </tr>
                                             @empty
                                             <tr>
                                                  <td colspan="5" class="text-center py-3 text-muted small">No hay datos registrados para mostrar.</td>
                                             </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif
</div>