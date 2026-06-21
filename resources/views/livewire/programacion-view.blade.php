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
               <div class="col-12 col-lg-9 mb-4">

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
                    <div class="card shadow-sm border-0 bg-white mb-0" style="border-radius: 8px;">
                         
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
                                        <select class="form-control" wire:model="subactividad_input" style="height: 40px;" {{ !$actividad_input ? 'disabled' : '' }}>
                                             <option value="">Seleccione una subactividad</option>
                                             @foreach($this->subactividadesOpciones as $sub)
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
                                        <input type="date" class="form-control" wire:model.live="fecha_input" style="height: 40px;">
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

                              <div wire:loading wire:target="filtro_ficha, filtro_cedula, filtro_nombre, filtro_cargo, filtro_gerencia, filtro_unidad, limpiarFiltrosEmpleados" class="w-100 text-center py-4">
                                   <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 1.5rem;"></i>
                                   <h6 class="text-muted font-weight-bold">Buscando empleados...</h6>
                              </div>

                              <div class="table-responsive border rounded" style="max-height: 250px; overflow-y: auto;" wire:loading.class="d-none" wire:target="filtro_ficha, filtro_cedula, filtro_nombre, filtro_cargo, filtro_gerencia, filtro_unidad, limpiarFiltrosEmpleados">
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
                                                  <tr class="hover-bg-light" wire:key="empleado-{{ $e->ficha }}">
                                                       <td class="text-center p-2">
                                                            <input type="checkbox" class="pointer" value="{{ $e->ficha }}" wire:model.live="participantes_seleccionados" style="transform: scale(1.15);">
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
                                   <button type="button" class="btn btn-secondary px-5 py-2 font-weight-bold" wire:click="cancelarEdicionPropuesta">Cancelar</button>
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
               <div class="col-12 col-lg-3 mb-4 min-vh-100">
                    <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-folder-open mr-2"></i> {{ $modo === 'busqueda' ? 'Resultados de Búsqueda' : 'Pre-Programaciones Registradas' }}
                              </h5>
                         </div>

                         <div class="card-body p-0">
                              <div wire:loading wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda" class="w-100 text-center py-5">
                                   <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 1.5rem;"></i>
                                   <h6 class="text-muted font-weight-bold">Buscando pre-programaciones...</h6>
                              </div>
                              <div style="max-height: 700px; overflow-y: auto;" wire:loading.class="d-none" wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda">
                                   @forelse($this->listaPre as $p)
                                        <div class="p-3 border-bottom hover-gradient-soft">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <strong class="text-dark" style="font-size: 0.95rem;">{{ $p->nombre }}</strong>
                                                  <div class="d-flex align-items-center" style="gap: 12px;">
                                                       <button type="button" wire:click="cargarPropuestaParaEdicion({{ $p->id }})" class="btn btn-sm btn-link text-primary p-0 m-0"><i class="fas fa-edit" style="font-size: 1.1rem;"></i></button>
                                                       <button type="button" wire:confirm="¿Está seguro de que desea eliminar esta pre-programación?" wire:click="eliminarPropuesta({{ $p->id }})" class="btn btn-sm btn-link text-danger p-0 m-0"><i class="fas fa-trash" style="font-size: 1.1rem;"></i></button>
                                                  </div>
                                             </div>
                                             <span class="text-secondary small d-block my-1">
                                                  <i class="far fa-user mr-1"></i> Facilitador: {{ $p->facilitador->nombre ?? 'N/A' }} <br>
                                                  <i class="far fa-calendar mr-1"></i> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }} <br>
                                                  <i class="fas fa-regular fa-clock mr-1"></i>{{ $p->duracion }} Horas 
                                             </span>
                                             <div class="d-flex justify-content-end align-items-center mt-2">
                                                  <span class="text-muted small"><i class="fas fa-users mr-1"></i> {{ $p->participantes_count }} Empleado(s)</span>
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

                         <div wire:loading wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda" class="w-100 text-center py-5">
                              <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 2rem;"></i>
                              <h6 class="text-muted font-weight-bold">Cargando resultados...</h6>
                         </div>

                         <div class="table-responsive" wire:loading.class="d-none" wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda">
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
                                        @forelse($this->listaFinal as $p)
                                             <tr wire:key="final-{{ $p->id }}">
                                                  <td class="p-2">
                                                       <strong class="text-dark d-block" style="font-size: 0.9rem;">{{ $p->nombre }}</strong>
                                                       <span class="small d-block text-dark"><strong>Institución:</strong> {{ $p->institucion }}</span>
                                                  </td>
                                                  <td class="p-2">
                                                       <span class="small">{{ $p->lugar }} | {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }}</span>
                                                  </td>
                                                  <td class="p-2 text-center align-middle">
                                                       <button wire:click="modalProgramacionEmpleados({{ $p->id }})" wire:loading.attr="disabled" wire:target="modalProgramacionEmpleados({{ $p->id }})" class="btn btn-sm btn-primary font-weight-bold" style="font-size: 0.8rem;">
                                                            <span wire:loading.remove wire:target="modalProgramacionEmpleados({{ $p->id }})">
                                                                 <i class="fas fa-solid fa-eye text-white mr-1"></i> {{ $p->participantes_count }} Trabajadores
                                                            </span>
                                                            <span wire:loading wire:target="modalProgramacionEmpleados({{ $p->id }})">
                                                                 <i class="fas fa-spinner fa-spin mr-1"></i> Cargando...
                                                            </span>
                                                       </button>
                                                  </td>
                                                  <td class="p-2 text-center align-middle">
                                                       @if($p->aprobado === true)
                                                            <span class="badge badge-success text-uppercase font-weight-bold p-2" style="font-size: 0.72rem; border-radius: 50px;">Aprobado</span>
                                                       @elseif($p->aprobado === false)
                                                            <span class="badge badge-danger text-uppercase font-weight-bold p-2" style="font-size: 0.72rem; border-radius: 50px;">Rechazado</span>
                                                       @else
                                                            <span class="badge badge-warning text-uppercase font-weight-bold p-2 animate-pulse" style="font-size: 0.72rem; border-radius: 50px;">Pendiente</span>
                                                       @endif
                                                  </td>
                                                  <td class="p-2 text-right align-middle">
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
          <div class="row text-dark mx-5">
               <div class="col-12 col-lg-9">
                    @include('partials.filtro-programaciones')

                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <div class="d-flex justify-content-between align-items-center">
                                   <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                        <i class="fas fa-users-cog mr-2"></i> Asistencias 
                                   </h5>
                              </div>
                         </div>
                         <div wire:loading wire:target="iniciarEjecucion, filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda" class="w-100 text-center py-5">
                              <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 2rem;"></i>
                              <h6 class="text-muted font-weight-bold">Cargando datos...</h6>
                         </div>
                         
                         <div class="table-responsive border rounded" wire:loading.class="d-none" wire:target="iniciarEjecucion, filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda">
                              <table class="table table-hover mb-0">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3 text-center" style="width: 120px;">¿ASISTIÓ?</th>
                                             <th class="p-3">TRABAJADOR</th>
                                             <th class="p-3 text-center">FICHA</th>
                                             <th class="p-3 text-center" style="width: 250px;">CAUSA DE INASISTENCIA</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @forelse($this->participantesAsistencia as $participante)
                                             <tr class="cursor-pointer" wire:key="asistencia-{{ $participante->ficha }}">
                                                  <td class="text-center p-2">
                                                       <input type="checkbox" value="{{ $participante->ficha }}" wire:model.live="asistentes_fichas" wire:key="chk-{{ $id_ejecucion_seleccionada }}-{{ $participante->ficha }}" style="transform: scale(1.35);">
                                                  </td>
                                                  <td class="p-2">
                                                       <strong class="text-dark">{{ $participante->nombre_empleado ?? 'Trabajador no especificado' }}</strong>
                                                  </td>
                                                  <td class="p-2 text-center align-middle"><span class="badge badge-light border">{{ $participante->ficha }}</span></td>
                                                  <td class="p-2" wire:click.stop>
                                                       <input type="text" class="form-control form-control-sm text-center" wire:model.defer="causas_fichas.{{ $participante->ficha }}" style="border-radius: 4px;" {{ in_array($participante->ficha, $asistentes_fichas) ? 'disabled' : '' }}>
                                                  </td>
                                             </tr>
                                        @empty
                                             <tr>
                                                  <td colspan="4" class="text-center py-4 text-muted">Seleccione un curso de la columna derecha para mostrar los empleados matriculados.</td>
                                             </tr>
                                        @endforelse
                                   </tbody>
                              </table>
                                 @if($id_ejecucion_seleccionada)
                          <div class="d-flex justify-content-end my-3">
                               <button class="btn btn-sm btn-secondary px-3 py-2 mr-2 font-weight-bold" wire:click="cancelarEjecucion" wire:loading.attr="disabled" wire:target="cancelarEjecucion">
                                    <span wire:loading.remove wire:target="cancelarEjecucion">Cancelar</span>
                                    <span wire:loading wire:target="cancelarEjecucion"><i class="fas fa-spinner fa-spin"></i> Cancelando...</span>
                               </button>
                               @if ($this->propuestas->firstWhere('id', $id_ejecucion_seleccionada)?->ejecutado)
                               <button class="btn btn-sm btn-danger px-3 py-2 mr-2 font-weight-bold" wire:confirm="¿Está seguro de que desea cambiar el estatus de este curso?" wire:click="deshacerEjecucion({{$id_ejecucion_seleccionada}})" wire:loading.attr="disabled" wire:target="deshacerEjecucion">
                                    <span wire:loading.remove wire:target="deshacerEjecucion"><i class="fas fa-redo mr-1"></i> Deshacer Ejecución</span>
                                    <span wire:loading wire:target="deshacerEjecucion"><i class="fas fa-spinner fa-spin"></i> Deshaciendo...</span>
                               </button>
                               @endif
                               <button class="btn btn-sm btn-success px-3 py-2 mr-2 font-weight-bold" wire:click="guardarEjecucion" wire:loading.attr="disabled" wire:target="guardarEjecucion">
                                    <span wire:loading.remove wire:target="guardarEjecucion"><i class="fas fa-check-circle mr-1"></i> Registrar Asistencias</span>
                                    <span wire:loading wire:target="guardarEjecucion"><i class="fas fa-spinner fa-spin mr-1"></i> Guardando...</span>
                               </button>
                          </div>
                          @endif
                         </div>
                    </div>
               </div>

               <div class="col-12 col-lg-3 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-0" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-tasks text-white mr-2"></i> Cursos Aprobados
                              </h5>
                         </div>

                         <div class="card-body px-3 py-0">
                              <div wire:loading wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda" class="w-100 text-center py-4">
                                   <i class="fas fa-spinner fa-spin text-primary mb-2" style="font-size: 1.5rem;"></i>
                                   <h6 class="text-muted font-weight-bold">Buscando cursos...</h6>
                              </div>
                              <div class="row" style="max-height: 420px; overflow-y: auto;" wire:loading.class="d-none" wire:target="filtro_area, filtro_actividad, filtro_subactividad, filtro_facilitador, filtro_institucion, filtro_lugar, filtro_fecha_desde, filtro_fecha_hasta, filtro_desde, filtro_hasta, limpiarFiltrosBusqueda">
                                   @forelse($this->listaEjecucion as $p)
                                        <div class="col-12 py-2 border-bottom hover-gradient-soft" wire:key="ejec-{{ $p->id }}">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <strong class="text-dark" style="font-size: 0.95rem;">{{ $p->nombre }}</strong>
                                                  <div class="d-flex align-items-center" style="gap: 12px;">
                                                       <button type="button" wire:click="iniciarEjecucion({{ $p->id }})" class="btn btn-sm btn-link text-primary p-0 m-0"><i class="fas fa-edit" style="font-size: 1.1rem;"></i></button>
                                                  </div>
                                             </div>
                                             <span class="text-secondary small d-block my-1">
                                                  <i class="far fa-user mr-1"></i> Facilitador: {{ $p->facilitador->nombre ?? 'N/A' }} <br>
                                                  <i class="far fa-calendar mr-1"></i> Fecha: {{ \Carbon\Carbon::parse($p->fecha)->format('d/m/Y') }} <br>
                                                  <i class="fas fa-regular fa-clock mr-1"></i>{{ $p->duracion }} Horas <br>
                                                  @if($p->ejecutado)
                                                       <span style="color: #27ae60ff"><i class="fas fa-check-circle mr-1"></i>Ejecutado</span>
                                                  @else
                                                       <span style="color: #e67e22ff"><i class="far fa-clock mr-1"></i>Pendiente</span>
                                                  @endif
                                             </span>
                                             <div class="d-flex justify-content-end align-items-center mt-2">
                                                  <span class="text-muted small"><i class="fas fa-users mr-1"></i> {{ $p->participantes_count }} Empleado(s)</span>
                                             </div>
                                        </div>
                                   @empty
                                        <div class="col-12 text-center py-5 text-muted">No existen cursos aprobados.</div>
                                   @endforelse
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif

     <!-- Modal: Trabajadores Matriculados en un Curso (Vista: Programación) -->
     @include('partials.modals.modal-programacion-trabajadores', ['nombre' => $programacion_modal_nombre, 'trabajadores' => $programacion_modal_trabajadores])
</div>
