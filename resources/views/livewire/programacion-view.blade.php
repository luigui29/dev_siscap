<div class="container-fluid py-4" style="background-color: #F2F2F2; max-width: 1440px; margin: 0 auto;">
     <!-- Toast Notification -->
     @if($notification)
          <div class="alert alert-{{ $notification['type'] === 'success' ? 'success' : ($notification['type'] === 'danger' ? 'danger' : 'info') }} alert-dismissible fade show shadow border-0 position-fixed d-flex align-items-center" role="alert" style="right: 20px; top: 80px; z-index: 1060; gap: 10px; border-radius: 8px; min-width: 320px;">
               <i class="fas fa-info-circle" style="font-size: 1.25rem;"></i>
               <div>{{ $notification['msg'] }}</div>
               <button type="button" class="close ml-auto" wire:click="clearNotification" style="outline: none;">
                    <span>&times;</span>
               </button>
          </div>
     @endif

     <!-- Pantalla con Cabecera -->
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 text-dark">
          <div>
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
                    Planificación y Control de Cursos (SISCAP)
               </h3>
               <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Predimensionamiento, aprobación de adiestramiento, firmas físicas de asistencia y confirmación del calendario de capacitación.
               </p>
          </div>
     </div>

     <!-- Navigation Sub-Menu Tab List -->
     <div class="card shadow-sm border-0 bg-white mb-4" style="border-radius: 8px;">
          <div class="card-body p-2 d-flex flex-wrap" style="gap: 8px;">
               <button 
                    wire:click="$set('active_tab', 'pre')" 
                    class="btn d-flex align-items-center {{ $active_tab === 'pre' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-edit"></i> 1. Registro Propuestas (Fases Pre)
               </button>

               <button 
                    wire:click="$set('active_tab', 'final')" 
                    class="btn d-flex align-items-center {{ $active_tab === 'final' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-vote-yea"></i> 2. Aprobación y Estructura
               </button>

               <button 
                    wire:click="$set('active_tab', 'ejecucion')" 
                    class="btn d-flex align-items-center {{ $active_tab === 'ejecucion' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-tasks"></i> 3. Control de Ejecución
               </button>

               <button 
                    wire:click="$set('active_tab', 'calendario')" 
                    class="btn d-flex align-items-center {{ $active_tab === 'calendario' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-calendar-alt"></i> 4. Cronograma de Adiestramiento
               </button>
          </div>
     </div>

     <!-- TAB 1: PRE-PROGRAMACIÓN FORM -->
     @if($active_tab === 'pre')
          <div class="row text-dark">
               
               <!-- Formulario Form Panel Left -->
               <div class="col-12 col-lg-7 mb-4 order-2 order-lg-2">
                    <div class="card shadow-sm border-0 bg-white h-100 mb-0" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-clipboard-list mr-2"></i> Nuevo Predimensionamiento (Propuesta de Capacitación)
                              </h5>
                         </div>

                         <form wire:submit.prevent="saveProposal" class="card-body">
                              <p class="text-secondary small mb-4">
                                   * Diseñe una propuesta técnica definiendo la subactividad y asignando las fichas participantes. El curso quedará guardado como <strong>PRE-PROGRAMADO</strong>.
                              </p>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">ÁREA DE CAPACITACIÓN</label>
                                        <select class="form-control" wire:model.live="selected_area_id" style="height: 40px;">
                                             <option value="1">Formación General y Técnica</option>
                                             <option value="2">Mantenimiento y Confiabilidad Industrial</option>
                                             <option value="3">Seguridad y Salud Laboral SHA</option>
                                        </select>
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">CATEGORÍA DE ACTIVIDAD</label>
                                        <select class="form-control" wire:model.live="selected_act_id" style="height: 40px;">
                                             <option value="101">Curso de Confiabilidad Vibracional</option>
                                             <option value="102">Taller Práctico de PLC Siemens S7</option>
                                             <option value="103">Inducción General de Ingreso SISCAP</option>
                                        </select>
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">ACTIVIDAD ADIESTRAMIENTO</label>
                                        <select class="form-control" wire:model="selected_subact_id" style="height: 40px;">
                                             <option value="1011">Análisis por Ultrasonido Acústico Pasivo</option>
                                             <option value="1012">Introducción de Ensayos No Destructivos (NDT)</option>
                                             <option value="1021">Arquitectura Profinet & Redes de Planta</option>
                                        </select>
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">FACILITADOR / INSTRUCTOR</label>
                                        <input type="text" class="form-control" wire:model="facilitador_ficha" style="height: 40px;" placeholder="Ej. Dr. Carlos Mendoza">
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-8 form-group">
                                        <label class="font-weight-bold small">INSTITUCIÓN EXECUTORA / ADIESTRADORA</label>
                                        <input type="text" class="form-control" wire:model="institucion_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-4 form-group">
                                        <label class="font-weight-bold small">FECHA PROPUESTA</label>
                                        <input type="date" class="form-control" wire:model="fecha_input" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">LUGAR / SALÓN</label>
                                        <input type="text" class="form-control" wire:model="lugar_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-3 form-group">
                                        <label class="font-weight-bold small">HORA DESDE</label>
                                        <input type="time" class="form-control" wire:model="desde_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-3 form-group">
                                        <label class="font-weight-bold small">HORA HASTA</label>
                                        <input type="time" class="form-control" wire:model="hasta_input" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="row align-items-center">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">DURACIÓN (HORAS ACADÉMICAS)</label>
                                        <input type="number" class="form-control" wire:model="duracion_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-6 form-group mt-3 mt-md-0">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="isExtraInput" wire:model="is_extra_input">
                                             <label class="custom-control-label text-muted font-weight-bold" for="isExtraInput" style="padding-top: 2px;">¿Es actividad extraordinaria / Sabatina?</label>
                                        </div>
                                   </div>
                              </div>

                              <!-- Participant Multi Selection -->
                              <hr class="my-4">
                              <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-users text-primary mr-2"></i> Seleccionar Colaboradores Convocados</h6>
                              
                              <div class="table-responsive border rounded" style="max-height: 250px; overflow-y: auto;">
                                   <table class="table table-sm mb-0 table-hover">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th style="width: 40px;" class="p-2 text-center">CONVOCADO</th>
                                                  <th class="p-2">COLABORADOR</th>
                                                  <th class="p-2">FICHA</th>
                                                  <th class="p-2">GERENCIA</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($colaboradores as $c)
                                                  <tr class="cursor-pointer" wire:click="toggleParticipant('{{ $c->ficha }}')">
                                                       <td class="text-center p-2">
                                                            <input type="checkbox" class="pointer" value="{{ $c->ficha }}" wire:model="selected_participants" style="transform: scale(1.15);">
                                                       </td>
                                                       <td class="p-2 font-weight-bold text-dark" style="font-size: 0.85rem;">{{ $c->name }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;"><span class="badge badge-light px-2 py-1">{{ $c->ficha }}</span></td>
                                                       <td class="p-2" style="font-size: 0.85rem; color: #475569;">{{ $c->texto_gerencia ?? 'GERENCIA DE PLANTAS' }}</td>
                                                  </tr>
                                             @endforeach
                                        </tbody>
                                   </table>
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Pre-programar Propuesta
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>

               <!-- Draft Proposals Right Column -->
               <div class="col-12 col-lg-5 mb-4 order-1 order-lg-1">
                    <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-folder-open mr-2"></i> Propuestas Registradas
                              </h5>
                         </div>

                         <div class="card-body p-0">
                              <div style="max-height: 700px; overflow-y: auto;">
                                   @forelse($proposals->whereNull('aprobado') as $p)
                                        <div class="p-3 border-bottom hover-gradient-soft">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <strong class="text-dark" style="font-size: 0.95rem;">#{{ $p->id }} - ID Act: {{ $p->actividad_id }}</strong>
                                                  <span class="badge badge-warning text-uppercase" style="font-size: 0.68rem; padding: 0.25rem 0.5rem; border-radius: 50px;">EVALUACIÓN</span>
                                             </div>
                                             <span class="text-secondary small d-block my-1">
                                                  <i class="far fa-user mr-1"></i> Facilitador: {{ $p->facilitador }} <br>
                                                  <i class="far fa-calendar mr-1"></i> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}
                                             </span>
                                             <div class="d-flex justify-content-between align-items-center mt-2">
                                                  <span class="badge badge-info text-dark" style="background-color: #E0F2FE;">{{ $p->duracion }} Horas / Hombre</span>
                                                  <span class="text-muted small"><i class="fas fa-users"></i> {{ count($p->participantes ?? []) }} Convocados</span>
                                             </div>
                                        </div>
                                   @empty
                                        <div class="text-center py-5 text-muted">
                                             <i class="fas fa-inbox text-muted mb-2" style="font-size: 2.5rem;"></i>
                                             <p class="mb-0 font-weight-bold">No hay propuestas pendientes de evaluación</p>
                                        </div>
                                   @endforelse
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     @endif

     <!-- TAB 2: APROBACIONES FINALES -->
     @if($active_tab === 'final')
          <div class="row text-dark">
               <div class="col-12 col-lg-9 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1.05rem;">
                                   <i class="fas fa-shield-alt mr-2"></i> Bandeja de Decisiones del Coordinador y Gerencia de SISCAP
                              </h5>
                         </div>

                         <div class="table-responsive">
                              <table class="table table-hover mb-0 align-middle">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3">CURSO / ACTIVIDAD</th>
                                             <th class="p-3">COORDINACIÓN</th>
                                             <th class="p-3">CONVOCADOS</th>
                                             <th class="p-3 text-center">APROBACIÓN</th>
                                             <th class="p-3 text-right">ACCIONES</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @forelse($proposals as $p)
                                             <tr>
                                                  <td class="p-3">
                                                       <strong class="text-dark d-block" style="font-size: 0.9rem;">#{{ $p->id }} - ID Act: {{ $p->actividad_id }}</strong>
                                                       <small class="text-muted">{{ $p->lugar }} | {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</small>
                                                  </td>
                                                  <td class="p-3">
                                                       <span class="small d-block text-dark"><strong>Facilitador:</strong> {{ $p->facilitador }}</span>
                                                       <span class="small text-secondary"><strong>Institución:</strong> {{ $p->institucion }}</span>
                                                  </td>
                                                  <td class="p-3">
                                                       <span class="badge badge-light border text-dark font-weight-bold" style="font-size: 0.8rem;">
                                                            <i class="fas fa-users text-primary mr-1"></i> {{ count($p->participantes ?? []) }} Trabajadores
                                                       </span>
                                                  </td>
                                                  <td class="p-3 text-center">
                                                       @if($p->aprobado === true)
                                                            <span class="badge badge-success text-uppercase font-weight-bold py-2 px-3" style="font-size: 0.72rem; border-radius: 50px;">Aprobado</span>
                                                       @elseif($p->aprobado === false)
                                                            <span class="badge badge-danger text-uppercase font-weight-bold py-2 px-3" style="font-size: 0.72rem; border-radius: 50px;">Evaluado NO</span>
                                                       @else
                                                            <span class="badge badge-warning text-uppercase font-weight-bold py-2 px-3 animate-pulse" style="font-size: 0.72rem; border-radius: 50px;">Evaluación</span>
                                                       @endif
                                                  </td>
                                                  <td class="p-3 text-right">
                                                       <div class="d-flex justify-content-end" style="gap: 6px;">
                                                            @if($p->aprobado === null)
                                                                 <button wire:click="approveProposal({{ $p->id }})" class="btn btn-sm btn-outline-success border font-weight-bold">
                                                                      <i class="fas fa-check"></i> Aprobar
                                                                 </button>
                                                                 <button wire:click="rejectProposal({{ $p->id }})" class="btn btn-sm btn-outline-danger border font-weight-bold">
                                                                      <i class="fas fa-times"></i> Rechazar
                                                                 </button>
                                                            @endif

                                                            @if($p->aprobado === true)
                                                                 <button class="btn btn-sm btn-secondary font-weight-bold" onclick="alert('Descargando planilla de asistencia firmada para este curso')">
                                                                      <i class="fas fa-print"></i> Planilla Firmas
                                                                 </button>
                                                            @endif
                                                       </div>
                                                  </td>
                                             </tr>
                                        @empty
                                             <tr>
                                                  <td colspan="5" class="text-center py-5">
                                                       <i class="fas fa-folder text-muted mb-2" style="font-size: 2rem;"></i>
                                                       <p class="mb-0 text-secondary">No se registran planificaciones</p>
                                                  </td>
                                             </tr>
                                        @endforelse
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>

               <!-- Stats Sidebar Right Column -->
               <div class="col-12 col-lg-3 mb-4">
                    <div class="d-flex flex-column" style="gap: 16px;">
                         
                         <!-- Stats Card 1 -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #E0F2FE; color: #0369A1; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-folder" style="font-size: 0.9rem; color: #0369A1;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">PROPUESTAS REGISTRADAS</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $proposals->count() }} Planificaciones</span>
                              </div>
                         </div>

                         <!-- Stats Card 2 -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #DCFCE7; color: #15803D; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-check-circle" style="font-size: 0.9rem; color: #15803D;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">APROBACIONES FIRMES</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $proposals->where('aprobado', true)->count() }} Cursos Listos</span>
                              </div>
                         </div>

                         <!-- Stats Card 3 -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #FEF3C7; color: #B45309; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-hourglass-half" style="font-size: 0.9rem; color: #B45309;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">PROPUESTAS PENDIENTES</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $proposals->whereNull('aprobado')->count() }} en Evaluación</span>
                              </div>
                         </div>

                    </div>
               </div>
          </div>
     @endif

     <!-- TAB 3: CONTROL DE EJECUCIÓN -->
     @if($active_tab === 'ejecucion')
          <div class="row text-dark">
               
               <div class="col-12 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-0" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-tasks text-white mr-2"></i> Control de Ejecución (Seleccionar Capacitación Activa)
                              </h5>
                         </div>

                         <div class="card-body p-3">
                              <div class="p-3 bg-light text-muted small border rounded mb-3">
                                   <i class="fas fa-info-circle text-primary mr-1"></i> Seleccione un curso aprobado del panel a continuación para registrar qué trabajadores asistieron al curso y registrar de manera formal sus Horas/Hombre en el historial de capacitación de SISCAP.
                              </div>

                              <div class="row" style="max-height: 420px; overflow-y: auto;">
                                   @forelse($proposals->where('aprobado', true) as $p)
                                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                                             <div 
                                                  wire:click="startExecution({{ $p->id }})"
                                                  class="p-3 border rounded shadow-sm h-100 cursor-pointer d-flex flex-column justify-content-between position-relative {{ $selected_execution_id === $p->id ? 'border-primary' : 'border-light' }} {{ $p->ejecutado ? 'bg-disabled opacity-60' : 'hover-gradient-soft bg-white' }}"
                                                  style="min-height: 130px; transition: all 0.2s; border-width: {{ $selected_execution_id === $p->id ? '2px' : '1px' }};"
                                             >
                                                  <div>
                                                       <div class="d-flex justify-content-between align-items-start">
                                                            <strong class="text-dark d-block text-truncate" style="max-width: 85%; font-size: 0.92rem;">#{{ $p->id }} - ID Act: {{ $p->actividad_id }}</strong>
                                                            @if(!$p->ejecutado && $selected_execution_id === $p->id)
                                                                 <span class="text-primary font-weight-bold" style="font-size: 0.75rem;"><i class="fas fa-chevron-circle-down"></i> Activo</span>
                                                            @endif
                                                       </div>
                                                       <span class="text-secondary small d-block mb-1">Facilitador: {{ $p->facilitador }} <br> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</span>
                                                  </div>
                                                  <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                                       <span class="badge badge-info text-dark font-weight-bold" style="font-size: 0.72rem; background-color: #E0F2FE;">{{ $p->duracion }} Horas</span>
                                                       @if($p->ejecutado)
                                                            <span class="badge badge-success text-uppercase" style="font-size: 0.7rem;">Ejecutado <i class="fas fa-check-circle"></i></span>
                                                       @else
                                                            <span class="badge badge-warning text-uppercase" style="font-size: 0.7rem;">Pendiente <i class="far fa-clock"></i></span>
                                                       @endif
                                                  </div>
                                             </div>
                                        </div>
                                   @empty
                                        <div class="col-12 text-center py-5 text-muted">No existen cursos aprobados.</div>
                                   @endforelse
                              </div>
                         </div>
                    </div>
               </div>

               @if($selected_execution_id)
                    <div class="col-12 mb-4">
                         <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                              <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                   <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                             <i class="fas fa-users-cog mr-2"></i> Pasar Lista de Firmas Físicas (Asistencia Real del Curso #{{ $selected_execution_id }})
                                        </h5>
                                        <button class="btn btn-sm btn-light font-weight-bold" wire:click="$set('selected_execution_id', null)">
                                             Cancelar
                                        </button>
                                   </div>
                              </div>

                              <div class="card-body">
                                   <p class="text-muted small">
                                        Marque las casillas únicamente para aquellos trabajadores que consignaron su firma física en la planilla física de firmas. Las Horas/Hombre equivalentes de adiestramiento se registrarán exclusivamente para los preseleccionados asistentes marcados con <strong>Asistió</strong>.
                                   </p>

                                   <div class="table-responsive border rounded my-3">
                                        <table class="table table-hover mb-0">
                                             <thead class="bg-light">
                                                  <tr>
                                                       <th class="p-3 text-center" style="width: 120px;">¿ASISTIÓ?</th>
                                                       <th class="p-3">TRABAJADOR CONVOCADO</th>
                                                       <th class="p-3">FICHA</th>
                                                       <th class="p-3">GERENCIA DE ADSCRIPCIÓN</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  @php
                                                       $active_course = $proposals->firstWhere('id', $selected_execution_id);
                                                       $participants = $active_course ? ($active_course->participantes ?? []) : [];
                                                  @endphp
                                                  @forelse($participants as $p_ficha)
                                                       @php
                                                            $colab = $colaboradores->firstWhere('ficha', $p_ficha);
                                                       @endphp
                                                       <tr class="cursor-pointer" wire:click="toggleAttendance('{{ $p_ficha }}')">
                                                            <td class="text-center p-3">
                                                                 <input type="checkbox" checked="{{ in_array($p_ficha, $asistentes_fichas) }}" style="transform: scale(1.35);">
                                                            </td>
                                                            <td class="p-3">
                                                                 <strong class="text-dark">{{ $colab ? $colab->name : 'Trabajador no especificado' }}</strong>
                                                            </td>
                                                            <td class="p-3"><span class="badge badge-light border">{{ $p_ficha }}</span></td>
                                                            <td class="p-3 text-secondary">{{ $colab ? ($colab->texto_gerencia ?? 'SOPORTE MECÁNICO') : 'N/A' }}</td>
                                                       </tr>
                                                  @empty
                                                       <tr>
                                                            <td colspan="4" class="text-center py-4 text-muted">Ningún convocado registrado para este curso.</td>
                                                       </tr>
                                                  @endforelse
                                             </tbody>
                                        </table>
                                   </div>

                                   <div class="mt-4 pt-3 border-top text-right">
                                        <button wire:click="saveExecution" class="btn btn-success px-5 py-2 font-weight-bold">
                                             <i class="fas fa-check-circle"></i> Confirmar y Registrar Asistencia Real
                                        </button>
                                   </div>
                              </div>
                         </div>
                    </div>
               @endif

          </div>
     @endif

     <!-- TAB 4: CALENDARIO CRONOGRAMA -->
     @if($active_tab === 'calendario')
          <div class="row text-dark">
               <div class="col-12 col-lg-8 order-2 order-lg-2">
                    <div class="card shadow-sm border-0 bg-white">
                         <div class="calendario-select-meses border-0 p-3 d-flex justify-content-between align-items-center" style="background-color: #5DADE2; color: #FFF;">
                              <button wire:click="$set('calendar_month', 'junio')" class="btn btn-link text-white font-weight-bold" style="text-decoration: none;">
                                   <i class="fas fa-chevron-left"></i> Junio 2026
                              </button>
                              <h5 class="mb-0 font-weight-bold uppercase" style="letter-spacing: 1px;">
                                   {{ strtoupper($calendar_month) }} 2026
                              </h5>
                              <button wire:click="$set('calendar_month', 'julio')" class="btn btn-link text-white font-weight-bold" style="text-decoration: none;">
                                   Julio 2026 <i class="fas fa-chevron-right"></i>
                              </button>
                         </div>

                         <div class="p-3">
                              <div class="table-responsive">
                                   <table class="table table-bordered table-calendario text-center mb-0" style="table-layout: fixed;">
                                        <thead>
                                             <tr style="background-color: #F8FAFC;">
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Lun</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Mar</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Mie</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Jue</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem;">Vie</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem; color: #C0392B;">Sab</th>
                                                  <th class="p-1 text-muted font-weight-bold text-uppercase" style="width: 14%; font-size: 0.78rem; color: #C0392B;">Dom</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <!-- Grid of Calendar -->
                                             @if($calendar_month === 'junio')
                                                  <!-- Example calendar grid for June 2026 (Starts on Monday June 1) -->
                                                  <tr>
                                                       @for($i = 1; $i <= 7; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                                 @if($i === 4)
                                                                      <div class="evento p-1 mb-1 text-white border-0" style="background-color: #58D68D; border-radius: 4px; font-size: 0.65rem; line-height: 1.2;">
                                                                           <strong>#101 - PLC Siemens</strong> <br> 08:00 (Ejecutado)
                                                                      </div>
                                                                 @endif
                                                                 @if($i === 15)
                                                                      <div class="evento p-1 mb-1 text-white border-0" style="background-color: #5DADE2; border-radius: 4px; font-size: 0.65rem; line-height: 1.2;">
                                                                           <strong>#102 - NDT Ultrasonido</strong> <br> 14:00 (Aprobado)
                                                                      </div>
                                                                 @endif
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 8; $i <= 14; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 15; $i <= 21; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                                 @if($i === 15)
                                                                      <div class="evento p-1 mb-1 text-white border-0" style="background-color: #5DADE2; border-radius: 4px; font-size: 0.65rem; line-height: 1.2;">
                                                                           <strong>#103 - Profinet Redes</strong> <br> 09:00 (Aprobado)
                                                                      </div>
                                                                 @endif
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 22; $i <= 28; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 29; $i <= 30; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                       @for($i = 1; $i <= 5; $i++)
                                                            <td class="mes-otro p-2 text-muted" style="height: 100px; background-color: #F1F5F9; text-align: left; vertical-align: top; opacity: 0.5;">
                                                                 <span class="numero-dia font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                             @else
                                                  <!-- July 2026 -->
                                                  <tr>
                                                       @for($i = 29; $i <= 30; $i++)
                                                            <td class="mes-otro p-2 text-muted" style="height: 100px; background-color: #F1F5F9; text-align: left; vertical-align: top; opacity: 0.5;">
                                                                 <span class="numero-dia font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                       @for($i = 1; $i <= 5; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 6; $i <= 12; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                                  <tr>
                                                       @for($i = 13; $i <= 19; $i++)
                                                            <td class="mes-actual p-2 position-relative" style="height: 100px; text-align: left; vertical-align: top;">
                                                                 <span class="numero-dia text-muted font-weight-bold">{{ $i }}</span>
                                                            </td>
                                                       @endfor
                                                  </tr>
                                             @endif
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>

               <!-- Calendar Details & Color Legend Sidebar -->
               <div class="col-12 col-lg-4 mb-4 mt-4 mt-lg-0 order-1 order-lg-1">
                    <div class="card shadow-sm border-0 bg-white p-4 h-100 d-flex flex-column justify-content-between" style="border-radius: 8px;">
                         <div>
                              <h5 class="font-weight-bold text-dark border-bottom pb-2">
                                   <i class="fas fa-calendar-alt text-secondary mr-2"></i> Leyenda y Estados
                              </h5>
                              <div class="d-flex flex-column mt-3" style="gap: 12px;">
                                   <div class="p-3 rounded border bg-light d-flex align-items-center" style="gap: 12px;">
                                        <div style="width: 16px; height: 16px; border-radius: 4px; background-color: #58D68D; flex-shrink: 0;"></div>
                                        <div>
                                             <small class="text-secondary font-weight-bold d-block" style="font-size: 0.72rem;">EJECUTADO / CONCLUIDO</small>
                                             <span class="badge badge-success" style="font-size: 0.65rem;">Cursos del mes completados</span>
                                        </div>
                                   </div>
                                   
                                   <div class="p-3 rounded border bg-light d-flex align-items-center" style="gap: 12px;">
                                        <div style="width: 16px; height: 16px; border-radius: 4px; background-color: #5DADE2; flex-shrink: 0;"></div>
                                        <div>
                                             <small class="text-secondary font-weight-bold d-block" style="font-size: 0.72rem;">APROBADO / PENDIENTE</small>
                                             <span class="badge badge-info text-dark" style="font-size: 0.65rem; background-color: #E0F2FE;">Programados</span>
                                        </div>
                                   </div>

                                   <div class="p-3 rounded border bg-light d-flex align-items-center" style="gap: 12px;">
                                        <div style="width: 16px; height: 16px; border-radius: 4px; background-color: #F8C471; flex-shrink: 0;"></div>
                                        <div>
                                             <small class="text-secondary font-weight-bold d-block" style="font-size: 0.72rem;">PRE-PROGRAMADO / EVALUACIÓN</small>
                                             <span class="badge badge-warning text-dark" style="font-size: 0.65rem; background-color: #FEF3C7;">En Propuesta</span>
                                        </div>
                                   </div>
                              </div>
                         </div>

                         <!-- Tips Section -->
                         <div class="mt-4 pt-3 border-top">
                              <span class="text-secondary font-weight-bold uppercase d-block mb-1" style="font-size: 0.75rem;">Resumen Mensual</span>
                              <p class="text-muted mb-0" style="font-size: 0.75rem; lineHeight: 1.4;">
                                   El cronograma está sincronizado en tiempo real con las propuestas enviadas por los coordinadores y las ejecuciones de los cursos de SISCAP.
                              </p>
                         </div>
                    </div>
               </div>
          </div>
     @endif
</div>
