<div class="container-fluid py-4 mx-auto">
     <!-- Notificación (Toast) -->
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
          <div>
               @if($pestania_activa === 'pre')
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155;">
                    Pre-Programación 
               </h3>
               @elseif($pestania_activa === 'final')
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155;">   
                    Programación
               </h3>
               @elseif($pestania_activa === 'ejecucion')
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155;">
                    Ejecución 
               </h3>
               @endif
          </div>
     </div>

     <!-- PRE-PROGRAMACIÓN -->
     @if($pestania_activa === 'pre')
          <div class="row mx-5 text-dark">
               
               <!-- Formulario Form Panel Left -->
               <div class="col-12 col-lg-8 mb-4">

                    <!-- Toggle Registro / Búsqueda -->
                    <div class="d-flex justify-content-end align-items-center py-2">
                         <div class="btn-group btn-group-sm" role="group">
                              <button type="button"
                                        class="btn {{ $modo === 'registro' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        wire:click="cambiarModo('registro')"
                                        wire:loading.attr="disabled"
                                        wire:target="cambiarModo('registro')">
                                   <span wire:loading.remove wire:target="cambiarModo('registro')">
                                        <i class="fas fa-pen mr-1"></i> Registro
                                   </span>
                                   <span wire:loading wire:target="cambiarModo('registro')">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Cargando...
                                   </span>
                              </button>
                              <button type="button"
                                        class="btn {{ $modo === 'busqueda' ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        wire:click="cambiarModo('busqueda')"
                                        wire:loading.attr="disabled"
                                        wire:target="cambiarModo('busqueda')">
                                   <span wire:loading.remove wire:target="cambiarModo('busqueda')">
                                        <i class="fas fa-search mr-1"></i> Búsqueda
                                   </span>
                                   <span wire:loading wire:target="cambiarModo('busqueda')">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Cargando...
                                   </span>
                              </button>
                         </div>
                    </div>
                    @if($modo === 'busqueda')
                         @include('partials.filtro-programaciones')
                    @elseif($modo === 'registro')
                    <div class="card shadow-sm border-0 bg-white mb-2" style="border-radius: 8px;">
                         
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-clipboard-list mr-2"></i> {{ ($id_propuesta_editando ? 'Editar Pre-Programacion' : 'Nueva Pre-Programacion') }}
                              </h5>
                         </div>
                         <form wire:submit.prevent="guardarPropuesta" class="card-body">
                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">ÁREA DE CAPACITACIÓN</label>
                                        <select class="form-control" wire:model.live="id_area_seleccionada" style="height: 40px;">
                                             <option value="">Seleccione un Área</option>
                                             @foreach($this->areas as $area)
                                                  <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                             @endforeach
                                        </select>
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">ACTIVIDAD</label>
                                        <select class="form-control" wire:model.live="actividad_input" style="height: 40px;" {{ !$id_area_seleccionada ? 'disabled' : '' }}>
                                             <option value="">Seleccione una actividad</option>
                                             @foreach($this->actividades->where('area_id', $id_area_seleccionada) as $act)
                                                  <option value="{{ $act->nombre }}">{{ $act->nombre }}</option>
                                             @endforeach
                                        </select>
                                        @error('actividad_input') <span class="text-danger small">{{ $message }}</span> @enderror
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">SUBACTIVIDAD</label>
                                        @php
                                             $actividadSeleccionada = collect($this->actividades)->where('nombre', $actividad_input)->first();
                                             $idActividadSeleccionada = $actividadSeleccionada ? $actividadSeleccionada->id : null;
                                        @endphp
                                        <select class="form-control" wire:model="subactividad_input" style="height: 40px;" {{ !$actividad_input ? 'disabled' : '' }}>
                                             <option value="">Seleccione una subactividad</option>
                                             @foreach($this->subactividades->where('actividad_id', $idActividadSeleccionada) as $sub)
                                                  <option value="{{ $sub->nombre }}">{{ $sub->nombre }}</option>
                                             @endforeach
                                        </select>
                                        @error('subactividad_input') <span class="text-danger small">{{ $message }}</span> @enderror
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">FACILITADOR</label>
                                        <select class="form-control" wire:model="facilitador_input" style="height: 40px;">
                                             <option value="">Seleccione un facilitador</option>
                                             @foreach($this->facilitadores as $fac)
                                                  <option value="{{ $fac->nombre }}">{{ $fac->nombre }}</option>
                                             @endforeach
                                        </select>
                                        @error('facilitador_input') <span class="text-danger small">{{ $message }}</span> @enderror
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-8 form-group">
                                        <label class="font-weight-bold small">INSTITUCIÓN</label>
                                        <input type="text" class="form-control" wire:model="institucion_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-4 form-group">
                                        <label class="font-weight-bold small">FECHA PROPUESTA</label>
                                        <input type="date" class="form-control" wire:model="fecha_input" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">LUGAR </label>
                                        <input type="text" class="form-control" wire:model="lugar_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-3 form-group">
                                        <label class="font-weight-bold small">DESDE</label>
                                        <input type="time" class="form-control" wire:model="desde_input" style="height: 40px;">
                                   </div>

                                   <div class="col-md-3 form-group">
                                        <label class="font-weight-bold small">HASTA</label>
                                        <input type="time" class="form-control" wire:model="hasta_input" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="row align-items-center">
                                   <div class="col-md-6 form-group mt-3 mt-md-0">
                                        <div class="custom-control custom-switch">
                                             <input type="checkbox" class="custom-control-input" id="esEntradaExtra" wire:model="es_entrada_extra">
                                             <label class="custom-control-label text-muted font-weight-bold" for="esEntradaExtra" style="padding-top: 2px;">¿Es extra?</label>
                                        </div>
                                   </div>
                              </div>

                              <!-- Selección de Participantes -->
                              <hr class="my-4">
                              <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-users text-primary mr-2"></i> Seleccionar Empleados </h6>
                              
                              @include('partials.filtro-empleados')

                              <div class="table-responsive border rounded" style="max-height: 250px; overflow-y: auto;">
                                   <table class="table table-sm mb-0 table-hover">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th style="width: 50px;" class="p-2 text-center">
                                                       <input type="checkbox" wire:model.live="seleccionar_todos" style="transform: scale(1.15);">
                                                  </th>
                                                  <th class="p-2">NOMBRE</th>
                                                  <th class="p-2">FICHA</th>
                                                  <th class="p-2">CARGO</th>
                                                  <th class="p-2">GERENCIA</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @foreach($this->empleadosFiltrados as $e)
                                                  <tr class="hover-bg-light">
                                                       <td class="text-center p-2">
                                                            <input type="checkbox" class="pointer" value="{{ $e->ficha }}" wire:model.defer="participantes_seleccionados" style="transform: scale(1.15);">
                                                       </td>
                                                       <td class="p-2 font-weight-bold text-dark" style="font-size: 0.85rem;">{{ $e->nombre_empleado }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;"><span class="badge badge-light px-2 py-1">{{ $e->ficha }}</span></td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $e->texto_cargo }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem; color: #475569;">{{ $e->texto_gerencia }}</td>
                                                  </tr>
                                             @endforeach
                                        </tbody>
                                   </table>
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   @if($id_propuesta_editando)
                                   <button type="button" class="btn btn-secondary px-5 py-2 font-weight-bold" wire:click="cancelarEdicionPropuesta" ...>Cancelar</button>
                                        <button type="submit" class="btn btn-success px-5 py-2 font-weight-bold"
                                                  wire:loading.attr="disabled"
                                                  wire:target="guardarPropuesta"
                                                  style="border-radius: 6px;">
                                             <span wire:loading.remove wire:target="guardarPropuesta">
                                                  <i class="fas fa-save mr-1"></i> Actualizar
                                             </span>
                                             <span wire:loading wire:target="guardarPropuesta">
                                                  <i class="fas fa-spinner fa-spin mr-1"></i> Guardando...
                                             </span>
                                        </button>
                                   @else
                                   <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold"
                                             wire:loading.attr="disabled"
                                             wire:target="guardarPropuesta"
                                             style="border-radius: 6px;">
                                        <span wire:loading.remove wire:target="guardarPropuesta">
                                             <i class="fas fa-save mr-1"></i> Pre-programar
                                        </span>
                                        <span wire:loading wire:target="guardarPropuesta">
                                             <i class="fas fa-spinner fa-spin mr-1"></i> Guardando...
                                        </span>
                                   </button>
                                   @endif
                              </div>
                         </form>
                    </div>
                    @endif
               </div>

               <!-- Pre-Programaciones Registradas -->
               <div class="col-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-folder-open mr-2"></i> {{ $modo === 'busqueda' ? 'Resultados de Búsqueda' : 'Pre-Programaciones Registradas' }}
                              </h5>
                         </div>

                         <div class="card-body p-0">
                              <div style="max-height: 700px; overflow-y: auto;">
                                   @php
                                        $lista = ($modo === 'busqueda') ? collect($resultados_busqueda)->map(fn($item) => (object) $item) : $this->propuestas->whereNull('aprobado');
                                   @endphp     
                              
                                   @forelse($lista as $p)
                                        <div class="p-3 border-bottom hover-gradient-soft">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <strong class="text-dark" style="font-size: 0.95rem;">#{{ $p->id }} - {{ $p->nombre }}</strong>
                                                  <div class="d-flex align-items-center" style="gap: 12px;">
                                                       <button type="button" wire:click="cargarPropuestaParaEdicion({{ $p->id }})" class="btn btn-sm btn-link text-primary p-0 m-0"><i class="fas fa-edit" style="font-size: 1.1rem;"></i></button>
                                                       <button type="button" wire:confirm="¿Está seguro de que desea eliminar esta pre-programación?" wire:click="eliminarPropuesta({{ $p->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash" style="font-size: 1.1rem;"></i></button>
                                                  </div>
                                             </div>
                                             <span class="text-secondary small d-block my-1">
                                                  @php
                                                       $fac_name = \Illuminate\Support\Facades\DB::table('tbl_facilitadores')->where('id', $p->facilitador_id)->value('nombre');
                                                       $participantes_count = \Illuminate\Support\Facades\DB::table('pl_programaciones')->where('programacion_id', $p->id)->count();
                                                  @endphp
                                                  <i class="far fa-user mr-1"></i> Facilitador: {{ $fac_name }} <br>
                                                  <i class="far fa-calendar mr-1"></i> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}
                                             </span>
                                             <div class="d-flex justify-content-between align-items-center mt-2">
                                                  <span class="badge badge-info text-dark" style="background-color: #E0F2FE;">{{ $p->duracion }} Horas / Hombre</span>
                                                  <span class="text-muted small"><i class="fas fa-users"></i> {{ $participantes_count }} Empleados</span>
                                             </div>
                                        </div>
                                   @empty
                                        <div class="text-center py-5 text-muted">
                                             <i class="fas fa-inbox text-muted mb-2" style="font-size: 2.5rem;"></i>
                                             <p class="mb-0 font-weight-bold">
                                                  {{ $modo === 'busqueda' ? 'No se encontraron resultados' : 'No hay pre-programaciones pendientes' }}
                                             </p>
                                        </div>
                                   @endforelse
                              </div>
                         </div>
                    </div>
               </div>

          </div>
     @endif

     <!-- PROGRAMACIÓN -->
     @if($pestania_activa === 'final')
          <div class="row text-dark mx-5">
               <div class="col-12 col-lg-9 d-flex justify-content-end align-items-center py-2">
                    @include('partials.filtro-programaciones')
               </div>

               <!-- Estadisticas sobre cursos programados -->
               <div class="col-12 col-lg-3 mb-4">
                    <div class="d-flex flex-column" style="gap: 16px;">
                         
                         <!-- Pre-Programaciones Registradas -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #E0F2FE; color: #0369A1; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-folder" style="font-size: 0.9rem; color: #0369A1;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">PRE-PROGRAMACIONES TOTALES</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $this->propuestas->count() }} Curso(s) Planificado(s)</span>
                              </div>
                         </div>

                         <!-- Pre-Programaciones Aprobadas -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #DCFCE7; color: #15803D; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-check-circle" style="font-size: 0.9rem; color: #15803D;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">PROGRAMACIONES APROBADAS</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $this->propuestas->where('aprobado', true)->count() }} Curso(s) Listo(s)</span>
                              </div>
                         </div>

                         <!-- Pre-Programaciones Pendientes -->
                         <div class="p-3 bg-white border rounded shadow-sm d-flex align-items-center" style="gap: 12px; min-height: 80px;">
                              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: #FEF3C7; color: #B45309; display:flex; align-items:center; justify-content:center; flex-shrink: 0;">
                                   <i class="fas fa-hourglass-half" style="font-size: 0.9rem; color: #B45309;"></i>
                              </div>
                              <div>
                                   <span class="text-secondary small d-block uppercase font-weight-bold" style="font-size: 0.65rem;">PROGRAMACIONES PENDIENTES</span>
                                   <span class="font-weight-bold text-dark mb-0 d-block" style="font-size: 0.95rem;">{{ $this->propuestas->whereNull('aprobado')->count() }} Curso(s) Pendiente(s)</span>
                              </div>
                         </div>

                    </div>
               </div>

               <div class="col-12 col-lg-9 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1.05rem;">
                                   <i class="fas fa-shield-alt mr-2"></i> Programaciones y Estatus
                              </h5>
                         </div>

                         <div wire:loading wire:target="buscarPropuestas, limpiarFiltrosBusqueda" class="w-100 text-center py-5">
                              <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 2rem;"></i>
                              <h6 class="text-muted font-weight-bold">Cargando resultados...</h6>
                         </div>

                         <div class="table-responsive" wire:loading.class="d-none" wire:target="buscarPropuestas, limpiarFiltrosBusqueda">
                              <table class="table mb-0 align-middle">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3">CURSO</th>
                                             <th class="p-3">LUGAR</th>
                                             <th class="p-3 text-center">PARTICIPANTES</th>
                                             <th class="p-3 text-center">ESTATUS</th>
                                             <th class="p-3 text-right">ACCIONES</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @php
                                             $listaFinal = $this->busqueda_activa ? collect($resultados_busqueda)->map(fn($item) => (object) $item) : $this->propuestas;
                                        @endphp
                                        @forelse($listaFinal as $p)
                                             @php
                                                  $fac_name = \Illuminate\Support\Facades\DB::table('tbl_facilitadores')->where('id', $p->facilitador_id)->value('nombre');
                                                  $participantes_count = \Illuminate\Support\Facades\DB::table('pl_programaciones')->where('programacion_id', $p->id)->count();
                                             @endphp
                                             <tr>
                                                  <td class="p-3">
                                                       <strong class="text-dark d-block" style="font-size: 0.9rem;">{{ $p->nombre }}</strong>
                                                       <small class="text-muted">Facilitador: {{ $fac_name }}</span>
                                                  </td>
                                                  <td class="p-3">
                    
                                                       <span class="small d-block text-dark"><strong>Institución:</strong> {{ $p->institucion }}</span>
                                                       <span class="small text-secibdart">{{ $p->lugar }} | {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</small>
                                                  </td>
                                                  <td class="p-3 text-center align-middle">
                                                       <button wire:click="modalProgramacionEmpleados({{ $p->id }})" wire:loading.attr="disabled" wire:target="modalProgramacionEmpleados({{ $p->id }})" class="btn btn-sm btn-primary font-weight-bold" style="font-size: 0.8rem;">
                                                            <span wire:loading.remove wire:target="modalProgramacionEmpleados({{ $p->id }})">
                                                                 <i class="fas fa-solid fa-eye text-white mr-1"></i> {{ $participantes_count }} Trabajadores
                                                            </span>
                                                            <span wire:loading wire:target="modalProgramacionEmpleados({{ $p->id }})">
                                                                 <i class="fas fa-spinner fa-spin mr-1"></i> Cargando...
                                                            </span>
                                                       </button>
                                                  </td>
                                                  <td class="p-3 text-center align-middle">
                                                       @if($p->aprobado === true)
                                                            <span class="badge badge-success text-uppercase font-weight-bold p-2" style="font-size: 0.72rem; border-radius: 50px;">Aprobado</span>
                                                       @elseif($p->aprobado === false)
                                                            <span class="badge badge-danger text-uppercase font-weight-bold p-2" style="font-size: 0.72rem; border-radius: 50px;">Rechazado</span>
                                                       @else
                                                            <span class="badge badge-warning text-uppercase font-weight-bold p-2 animate-pulse" style="font-size: 0.72rem; border-radius: 50px;">Pendiente</span>
                                                       @endif
                                                  </td>
                                                  <td class="p-3 text-right align-middle">
                                                       <div class="d-flex justify-content-end" style="gap: 6px;">
                                                            @if($p->aprobado === null)
                                                                 <button wire:click="aprobarPropuesta({{ $p->id }})" class="btn btn-sm btn-outline-success border font-weight-bold">
                                                                      <i class="fas fa-check"></i> Aprobar
                                                                 </button>
                                                                 <button wire:click="rechazarPropuesta({{ $p->id }})" class="btn btn-sm btn-outline-danger border font-weight-bold">
                                                                      <i class="fas fa-times"></i> Rechazar
                                                                 </button>
                                                            @endif

                                                            @if($p->aprobado === false)
                                                                 <button wire:confirm="¿Está seguro de que desea cambiar el estatus de este curso?" wire:click="nulificarPropuesta({{ $p->id }})" class="btn btn-sm btn-secondary font-weight-bold">
                                                                      <i class="fas fa-redo"></i> Cambiar
                                                                 </button>
                                                            @endif
                                                            
                                                            @if($p->aprobado === true)
                                                                 <button class="btn btn-sm btn-pdf font-weight-bold" onclick="alert('Descargando planilla de asistencia para este curso')">
                                                                      <i class="fas fa-file-pdf mr-1"></i> Control de Asistencia
                                                                 </button>
                                                                 <button wire:confirm="¿Está seguro de que desea cambiar el estatus de este curso?" wire:click="nulificarPropuesta({{ $p->id }})" class="btn btn-sm btn-secondary font-weight-bold">
                                                                      <i class="fas fa-redo"></i> Cambiar
                                                                 </button>
                                                            @endif
                                                       </div>
                                                  </td>
                                             </tr>
                                        @empty
                                             <tr>
                                                  <td colspan="5" class="text-center py-5">
                                                       <i class="fas fa-folder text-muted mb-2" style="font-size: 2rem;"></i>
                                                       <p class="mb-0 text-secondary">No se encontraron programaciones</p>
                                                  </td>
                                             </tr>
                                        @endforelse
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>

          </div>
     @endif

     <!-- EJECUCIÓN -->
     @if($pestania_activa === 'ejecucion')
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
                                   @forelse($this->propuestas->where('aprobado', true) as $p)
                                        @php
                                             $fac_name = \Illuminate\Support\Facades\DB::table('tbl_facilitadores')->where('id', $p->facilitador_id)->value('nombre');
                                        @endphp
                                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                                             <div 
                                                  wire:click="iniciarEjecucion({{ $p->id }})"
                                                  class="p-3 border rounded shadow-sm h-100 cursor-pointer d-flex flex-column justify-content-between position-relative {{ $id_ejecucion_seleccionada === $p->id ? 'border-primary' : 'border-light' }} {{ $p->ejecutado ? 'bg-disabled opacity-60' : 'hover-gradient-soft bg-white' }}"
                                                  style="min-height: 130px; transition: all 0.2s; border-width: {{ $id_ejecucion_seleccionada === $p->id ? '2px' : '1px' }};"
                                             >
                                                  <div>
                                                       <div class="d-flex justify-content-between align-items-start">
                                                            <strong class="text-dark d-block text-truncate" style="max-width: 85%; font-size: 0.92rem;">#{{ $p->id }} - {{ $p->nombre }}</strong>
                                                            @if(!$p->ejecutado && $id_ejecucion_seleccionada === $p->id)
                                                                 <span class="text-primary font-weight-bold" style="font-size: 0.75rem;"><i class="fas fa-chevron-circle-down"></i> Activo</span>
                                                            @endif
                                                       </div>
                                                       <span class="text-secondary small d-block mb-1">Facilitador: {{ $fac_name }} <br> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</span>
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

               @if($id_ejecucion_seleccionada)
                    <div class="col-12 mb-4">
                         <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                              <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                                   <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                             <i class="fas fa-users-cog mr-2"></i> Pasar Lista de Firmas Físicas (Asistencia Real del Curso #{{ $id_ejecucion_seleccionada }})
                                        </h5>
                                        <button class="btn btn-sm btn-light font-weight-bold" wire:click="$set('id_ejecucion_seleccionada', null)">
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
                                                       $participants = $id_ejecucion_seleccionada ? \Illuminate\Support\Facades\DB::table('pl_programaciones')->where('programacion_id', $id_ejecucion_seleccionada)->pluck('ficha_empleado')->toArray() : [];
                                                  @endphp
                                                  @forelse($participants as $p_ficha)
                                                       @php
                                                            $colab = \App\Models\RrhhPersonal::where('ficha', $p_ficha)->first();
                                                       @endphp
                                                       <tr class="cursor-pointer" wire:click="alternarAsistencia('{{ $p_ficha }}')">
                                                            <td class="text-center p-3">
                                                                 <input type="checkbox" checked="{{ in_array($p_ficha, $asistentes_fichas) ? 'checked' : '' }}" style="transform: scale(1.35);">
                                                            </td>
                                                            <td class="p-3">
                                                                 <strong class="text-dark">{{ $colab ? $colab->nombre_empleado : 'Trabajador no especificado' }}</strong>
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
                                        <button wire:click="guardarEjecucion" class="btn btn-success px-5 py-2 font-weight-bold">
                                             <i class="fas fa-check-circle"></i> Confirmar y Registrar Asistencia Real
                                        </button>
                                   </div>
                              </div>
                         </div>
                    </div>
               @endif

          </div>
     @endif

     <!-- Modal: Trabajadores Matriculados en un Curso (Vista: Programación) -->
     @include('partials.modals.modal-programacion-trabajadores', ['nombre' => $programacion_modal_nombre, 'trabajadores' => $programacion_modal_trabajadores])
</div>
