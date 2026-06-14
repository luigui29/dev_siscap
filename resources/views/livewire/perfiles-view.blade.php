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
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">AÑO</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem; width: 40px;"></th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($educacionesDb as $edu)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">
                                                            {{ $edu->nivel_educativo }}
                                                            @if($edu->graduado)<span class="badge badge-success ml-1" style="font-size: 0.65rem;">Graduado</span>@endif
                                                            @if($edu->ultimo_nivel)<span class="badge badge-primary ml-1" style="font-size: 0.65rem;">Último Nivel</span>@endif
                                                       </td>
                                                       <td class="p-2" style="font-size: 0.85rem;">
                                                            {{ $edu->titulo }} <br>
                                                            @if($edu->especialidad)<small class="text-muted">{{ $edu->especialidad }}</small>@endif
                                                       </td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $edu->instituto }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ $edu->fecha_culminado }}</td>
                                                       <td class="p-2 text-center">
                                                            <button wire:click="eliminarEducacion({{ $edu->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
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
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-plus-circle text-primary"></i> Ingresar Registro de Educación</strong>
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
                                             <input type="date" class="form-control form-control-sm" wire:model="edu_fecha_culminado" placeholder="Fecha Culminado">
                                        </div>
                                        <div class="col-md-3 form-group mb-2 d-flex align-items-center">
                                             <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" id="edu_graduado" wire:model="edu_graduado">
                                                  <label class="custom-control-label font-weight-bold small" for="edu_graduado">Graduado</label>
                                             </div>
                                        </div>
                                        <div class="col-md-3 form-group mb-2 d-flex align-items-center">
                                             <div class="custom-control custom-switch">
                                                  <input type="checkbox" class="custom-control-input" id="edu_ultimo_nivel" wire:model="edu_ultimo_nivel">
                                                  <label class="custom-control-label font-weight-bold small" for="edu_ultimo_nivel">Último Nivel</label>
                                             </div>
                                        </div>
                                        <div class="col-md-3 mb-2 d-flex align-items-center">
                                             <button wire:click="agregarEducacion" class="btn btn-sm btn-primary w-100">Cargar</button>
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
                                                       <td class="p-2 text-center">
                                                            <button wire:click="eliminarExperiencia({{ $exp->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
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
                                                       <td class="p-2 text-center">
                                                            <button wire:click="eliminarExperiencia({{ $exp->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash"></i></button>
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
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-plus-circle text-primary"></i> Ingresar Experiencia Laboral</strong>
                                   <div class="row">
                                        <div class="col-md-4 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_cargo" placeholder="Cargo Desempeñado">
                                        </div>
                                        <div class="col-md-4 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_empresa" placeholder="Empresa (Opcional)">
                                        </div>
                                        <div class="col-md-4 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_observacion" placeholder="Observaciones (Opcional)">
                                        </div>
                                        <div class="col-md-4 form-group mb-2">
                                             <label class="small text-muted mb-0">Desde</label>
                                             <input type="date" class="form-control form-control-sm" wire:model="exp_desde">
                                        </div>
                                        <div class="col-md-4 form-group mb-2">
                                             <label class="small text-muted mb-0">Hasta (Opcional)</label>
                                             <input type="date" class="form-control form-control-sm" wire:model="exp_hasta">
                                        </div>
                                        <div class="col-md-4 mb-2 d-flex align-items-end">
                                             <button wire:click="agregarExperiencia" class="btn btn-sm btn-primary w-100">Cargar</button>
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

                              <!-- Sección 4: Exportar Resumen del Trabajador -->
                              <hr class="my-4">

                              <h6 class="font-weight-bold text-dark my-2">
                                   Exportar Resumen del Trabajador
                              </h6>

                              <div class="mt-3 mb-2 d-flex">     
                                   <button class="btn btn-sm btn-light font-weight-bold">
                                   <i class="fas fa-file-excel mr-1"></i> Excel
                                   </button>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif

     <!-- TAB 2: MATRIZ HORAS GERENCIAS -->
     @if($pestania_activa === 'gerencia')
          <div class="row text-dark">
               <div class="col-12 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-th-large mr-2"></i> Matriz de Indicadores de Adiestramiento por Unidad Gerencial
                              </h5>
                              <button class="btn btn-sm btn-light font-weight-bold" onclick="alert('Exportando matriz consolidada...')">
                                   <i class="fas fa-file-excel mr-1"></i> Despachar Excel
                              </button>
                         </div>

                         <div class="card-body">
                              <p class="text-secondary small mb-4">
                                   Visualización de la distribución acumulada de Horas-Hombre de adiestramiento formal registradas en las unidades organizativas de la factoría.
                              </p>

                              <div class="row mb-4">
                                   <div class="col-12 col-md-4 mb-3">
                                        <div class="p-3 border rounded text-center bg-light">
                                             <span class="text-muted small font-weight-bold">GERENCIA DE PLANTA</span>
                                             <h3 class="font-weight-bold mt-1 mb-0 text-dark">412 Hrs/Hombre</h3>
                                        </div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                        <div class="p-3 border rounded text-center bg-light">
                                             <span class="text-muted small font-weight-bold">GERENCIA DE PROCESOS</span>
                                             <h3 class="font-weight-bold mt-1 mb-0 text-dark">350 Hrs/Hombre</h3>
                                        </div>
                                   </div>
                                   <div class="col-12 col-md-4 mb-3">
                                        <div class="p-3 border rounded text-center bg-light">
                                             <span class="text-muted small font-weight-bold">GERENCIA GENERAL DE SHA</span>
                                             <h3 class="font-weight-bold mt-1 mb-0 text-dark">280 Hrs/Hombre</h3>
                                        </div>
                                   </div>
                              </div>

                              <div class="table-responsive border rounded">
                                   <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-3">DIVISIONAL GERENCIA</th>
                                                  <th class="p-3 text-center">Nº TRABAJADORES</th>
                                                  <th class="p-3 text-center">CURSOS APROBADOS</th>
                                                  <th class="p-3 text-center">CURSOS EJECUTADOS</th>
                                                  <th class="p-3 text-center">HORAS HOMBRE TOTAL</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                  <td class="p-3"><strong>GERENCIA PLANTA DE HOMOGENEIZACIÓN</strong></td>
                                                  <td class="p-3 text-center">26 Trabajadores</td>
                                                  <td class="p-3 text-center"><span class="badge badge-primary px-2 font-weight-bold">12</span></td>
                                                  <td class="p-3 text-center"><span class="badge badge-success px-2 font-weight-bold">8</span></td>
                                                  <td class="p-3 text-center font-weight-bold text-dark">256 Horas</td>
                                             </tr>
                                             <tr>
                                                  <td class="p-3"><strong>GERENCIA INDUSTRIAL DE SERVICIOS GENERALES</strong></td>
                                                  <td class="p-3 text-center">18 Trabajadores</td>
                                                  <td class="p-3 text-center"><span class="badge badge-primary px-2 font-weight-bold">8</span></td>
                                                  <td class="p-3 text-center"><span class="badge badge-success px-2 font-weight-bold">6</span></td>
                                                  <td class="p-3 text-center font-weight-bold text-dark">180 Horas</td>
                                             </tr>
                                             <tr>
                                                  <td class="p-3"><strong>DIVISIÓN DE ELECTROMECÁNICA Y AUTOMATIZACIÓN</strong></td>
                                                  <td class="p-3 text-center">15 Trabajadores</td>
                                                  <td class="p-3 text-center"><span class="badge badge-primary px-2 font-weight-bold">14</span></td>
                                                  <td class="p-3 text-center"><span class="badge badge-success px-2 font-weight-bold">11</span></td>
                                                  <td class="p-3 text-center font-weight-bold text-dark">320 Horas</td>
                                             </tr>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif
</div>
