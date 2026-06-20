<div class="container-fluid py-4 mx-auto">
     <!-- Toast Notification -->
     @if($notificacion)
          <div class="alert alert-{{ $notificacion['tipo'] === 'success' ? 'success' : ($notificacion['tipo'] === 'danger' ? 'danger' : 'info') }} alert-dismissible fade show shadow border-0 position-fixed d-flex align-items-center" role="alert" style="right: 20px; top: 80px; z-index: 1060; gap: 10px; border-radius: 8px; min-width: 320px;">
               <i class="fas fa-sliders-h" style="font-size: 1.25rem;"></i>
               <div>{{ $notificacion['mensaje'] }}</div>
               <button type="button" class="close ml-auto" wire:click="limpiarNotificacion" style="outline: none;">
                    <span>&times;</span>
               </button>
          </div>
     @endif

     <!-- Cabecera -->
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mx-5 text-dark">
          <div>
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
                    Configuración del Sistema
               </h3>
          </div>
     </div>

     <!-- ROLES -->
     @if($pestania_activa === 'roles')
          <div class="row text-dark">
               <div class="col-12 col-lg-5 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-0" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-key mr-2 text-white"></i> Otorgar Nivel de Autorización
                              </h5>
                         </div>

                         <form wire:submit.prevent="asignarRol" class="card-body">
                              <p class="text-secondary small mb-4">
                                   Asigne o cambie los roles de usuario autorizados. Las jerarquías van en escala ascendente: <strong>Analista &lt; Coordinador &lt; Gerente</strong>.
                              </p>

                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">BUSCAR COLABORADOR</label>
                                   <div class="search-box position-relative">
                                        <input 
                                             type="text" 
                                             class="form-control pl-4 text-sm" 
                                             placeholder="Filtrar por ficha o nombre..." 
                                             wire:model.live="termino_busqueda"
                                             style="border-radius: 6px; font-size: 0.88rem; height: 40px;"
                                        />
                                   </div>
                              </div>

                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small text-dark">1. SELECCIONAR PARTICIPANTE</label>
                                   <select class="form-control" wire:model="ficha_usuario_seleccionado" style="height: 44px; font-weight: 600;">
                                        <option value="">Seleccione un colaborador...</option>
                                        @foreach($usuarios as $usr)
                                             <option value="{{ $usr->ficha }}">[{{ $usr->ficha }}] - {{ $usr->name }}</option>
                                        @endforeach
                                   </select>
                              </div>

                              <div class="form-group mb-4">
                                   <label class="font-weight-bold small text-muted">2. ASIGNAR ROL DE OPERACIÓN</label>
                                   <select class="form-control" wire:model="rol_objetivo" style="height: 44px; font-weight: 600;">
                                        <option value="Analista">Analista</option>
                                        <option value="Coordinador">Coordinador</option>
                                        <option value="Gerente">Gerente</option>
                                   </select>
                                   <span class="text-muted d-block mt-2 small">
                                        * El nivel seleccionado se sincronizará de forma inmediata con los controles de permisos de SISCAP.
                                   </span>
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Guardar Niveles de Rol
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>

               <div class="col-12 col-lg-7 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-shield-alt mr-2 text-white"></i> Usuarios y Roles Registrados
                              </h5>
                         </div>

                         <div class="table-responsive">
                              <table class="table table-hover mb-0">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3">TRABAJADOR</th>
                                             <th class="p-3 text-center">NIVEL ROL</th>
                                             <th class="p-3 text-right">PRIVILEGIOS</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach($usuarios as $usr)
                                             @php
                                                  $roles_list = $usr->roles ?? [];
                                                  $is_gerente = in_array('ADMIN_ROLE', $roles_list);
                                                  $is_coordinador = in_array('COORDINADOR_ROLE', $roles_list) && !$is_gerente;
                                                  $is_analista = !$is_gerente && !$is_coordinador;
                                             @endphp
                                             <tr>
                                                  <td class="p-3">
                                                       <strong class="text-dark d-block" style="font-size: 0.9rem;">{{ $usr->name }}</strong>
                                                       <small class="text-muted">Ficha: {{ $usr->ficha }} | {{ $usr->email }}</small>
                                                  </td>
                                                  <td class="p-3 text-center">
                                                       @if($is_gerente)
                                                            <span class="badge badge-info text-uppercase font-weight-bold py-1 px-2" style="font-size: 0.7rem;">Gerente</span>
                                                       @elseif($is_coordinador)
                                                            <span class="badge badge-success text-uppercase font-weight-bold py-1 px-2" style="font-size: 0.7rem;">Coordinador</span>
                                                       @else
                                                            <span class="badge badge-light border text-uppercase font-weight-bold py-1 px-2" style="font-size: 0.7rem; color: #475569;">Analista</span>
                                                       @endif
                                                  </td>
                                                  <td class="p-3 text-right">
                                                       <div class="d-flex justify-content-end flex-wrap" style="gap: 3px;">
                                                            <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.65rem;">CONSULTAR</span>
                                                            @if($is_coordinador || $is_gerente)
                                                                 <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.65rem;">PROPUESTAS</span>
                                                            @endif
                                                            @if($is_gerente)
                                                                 <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.65rem;">CONFIGURACIÓN</span>
                                                                 <span class="badge bg-light text-secondary border px-2 py-1" style="font-size: 0.65rem;">APROBACIÓN</span>
                                                            @endif
                                                       </div>
                                                  </td>
                                             </tr>
                                        @endforeach
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>
          </div>
     @endif

     <!-- SUBVIEW 2: AREAS DE CAPACITACION -->
     @if($pestania_activa === 'areas')
          <div class="row text-dark">
               <div class="col-12 col-lg-5 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-cubes mr-2 text-white"></i> 
                                   {{ $id_area_editando ? 'Editar Área Existente' : 'Ingresar Nueva Área Temática' }}
                              </h5>
                         </div>

                         <form wire:submit.prevent="agregarOEditarArea" class="card-body">
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">NOMBRE DE ÁREA</label>
                                   <input type="text" class="form-control" wire:model="area_nombre" placeholder="Ej: Electromecánica Industrial" style="height: 40px;">
                              </div>

                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">DESCRIPCIÓN DEL ÁREA</label>
                                   <textarea class="form-control" wire:model="area_descripcion" rows="3" placeholder="Defectografía, alineación de ejes..."></textarea>
                              </div>

                              <div class="form-group mb-4">
                                   <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="areaEstatus" wire:model="area_estatus">
                                        <label class="custom-control-label text-muted font-weight-bold" for="areaEstatus">¿Área activa para capacitación?</label>
                                   </div>
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   @if($id_area_editando)
                                        <button type="button" class="btn btn-light mr-2 font-weight-bold" wire:click="$set('id_area_editando', null)">
                                             Cancelar
                                        </button>
                                   @endif
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Guardar Área
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>

               <div class="col-12 col-lg-7 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-building mr-2 text-white"></i> Áreas de Capacitaciones Activas / Pasivas
                              </h5>
                         </div>

                         <div class="card-body p-0">
                              <div class="list-group list-group-flush">
                                   @foreach($areas as $area)
                                        <div class="list-group-item p-3">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <div>
                                                       <h6 class="font-weight-bold text-dark mb-1">{{ $area['nombre'] }}</h6>
                                                       <p class="text-secondary small mb-2" style="font-size: 0.8rem;">{{ $area['descripcion'] }}</p>
                                                       <span class="badge border {{ $area['estatus'] ? 'badge-success text-white' : 'badge-light text-muted' }}" style="font-size: 0.65rem;">
                                                            {{ $area['estatus'] ? 'HAIBILITADO' : 'INACTIVO' }}
                                                       </span>
                                                  </div>
                                                  <div class="d-flex" style="gap: 4px;">
                                                       <button class="btn btn-sm btn-light border" wire:click="iniciarEdicionArea({{ $area['id'] }})">
                                                            <i class="fas fa-edit text-primary"></i>
                                                       </button>
                                                       <button class="btn btn-sm btn-light border" wire:click="alternarEstatusArea({{ $area['id'] }})">
                                                            <i class="fas fa-power-off text-warning"></i>
                                                       </button>
                                                       <button class="btn btn-sm btn-light border" wire:confirm="¿Está seguro de eliminar esta área? Se eliminarán también las actividades asociadas." wire:click="eliminarArea({{ $area['id'] }})">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                       </button>
                                                  </div>
                                             </div>
                                        </div>
                                   @endforeach
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif

     <!-- SUBVIEW 3: GLOBAL PARAMETERS -->
     @if($pestania_activa === 'ajustes')
          <div class="row text-dark">
               <div class="col-12 col-md-8 mx-auto mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-cog mr-2 text-white"></i> Variables Globales de SISCAP
                              </h5>
                         </div>

                         <form wire:submit.prevent="guardarAjustesGlobales" class="card-body">
                              <p class="text-secondary small mb-4">
                                   * Administre y altere el comportamiento paramétrico del sistema de planificación industrial.
                              </p>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">MIN_DURACIÓN_CURSO (HORAS ACADÉMICAS)</label>
                                        <input type="number" class="form-control" value="8" style="height: 40px;">
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">RERERENCIA_GERENCIA (VENTAS/OPERACIONES)</label>
                                        <input type="text" class="form-control" value="GERENCIA TÉCNICA DE PROCESOS" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="row">
                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">VALIDEZ CERTIFICADOS DIGITALES (AÑOS)</label>
                                        <select class="form-control" style="height: 40px;">
                                             <option>1 Año</option>
                                             <option selected>2 Años</option>
                                             <option>3 Años</option>
                                             <option>Validez Permanente</option>
                                        </select>
                                   </div>

                                   <div class="col-md-6 form-group">
                                        <label class="font-weight-bold small">CÓDIGO DE EMPRESA MATRIZ</label>
                                        <input type="text" class="form-control" value="VENPRECAR-C.A.-12209" style="height: 40px;">
                                   </div>
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   <button type="submit" class="btn btn-primary px-5 py-2 font-weight-bold">
                                        <i class="fas fa-check-double mr-1"></i> Confirmar Parámetros de Sistema
                                   </button>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     @endif

     <!-- SUBVIEW 4: ACTIVIDADES Y SUBACTIVIDADES -->
     @if($pestania_activa === 'actividades')
          <div class="row text-dark">
               <!-- ACTIVIDADES -->
               <div class="col-12 col-lg-6 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-4" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-list-alt mr-2 text-white"></i> 
                                   {{ $id_actividad_editando ? 'Editar Actividad' : 'Nueva Actividad' }}
                              </h5>
                         </div>
                         <form wire:submit.prevent="agregarOEditarActividad" class="card-body">
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">ÁREA DE CAPACITACIÓN</label>
                                   <select class="form-control" wire:model="actividad_area_id" style="height: 40px;">
                                        <option value="">Seleccione un Área</option>
                                        @foreach($areas as $area)
                                             <option value="{{ $area['id'] }}">{{ $area['nombre'] }}</option>
                                        @endforeach
                                   </select>
                                   @error('actividad_area_id') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">NOMBRE DE LA ACTIVIDAD</label>
                                   <input type="text" class="form-control" wire:model="actividad_nombre" placeholder="Ej. Curso de Excel" style="height: 40px;">
                                   @error('actividad_nombre') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">OBJETIVO (Opcional)</label>
                                   <textarea class="form-control" wire:model="actividad_objetivo" rows="2" placeholder="Objetivo de la actividad..."></textarea>
                              </div>
                              <div class="mt-3 pt-3 border-top text-right">
                                   @if($id_actividad_editando)
                                        <button type="button" class="btn btn-light mr-2 font-weight-bold" wire:click="$set('id_actividad_editando', null)">Cancelar</button>
                                   @endif
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Guardar
                                   </button>
                              </div>
                         </form>
                    </div>

                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;"><i class="fas fa-list mr-2 text-white"></i> Actividades Registradas</h5>
                              <input type="text" wire:model="filtro_actividad" wire:keydown.enter="buscar" class="form-control form-control-sm" placeholder="Buscar (Enter)..." style="width: 150px;">
                         </div>
                         <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                              <div wire:loading wire:target="buscar" class="p-4 text-center text-primary w-100">
                                   <i class="fas fa-spinner fa-spin mr-2"></i> Buscando...
                              </div>
                              <div class="list-group list-group-flush" wire:loading.remove wire:target="buscar">
                                   @foreach(collect($actividades)->filter(fn($a) => empty($filtro_actividad) || str_contains(strtolower($a['nombre']), strtolower($filtro_actividad))) as $act)
                                        <div class="list-group-item p-3">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <div>
                                                       <h6 class="font-weight-bold text-dark mb-1">{{ $act['nombre'] }}</h6>
                                                       <p class="text-secondary small mb-1" style="font-size: 0.8rem;">Área: {{ $act['area']['nombre'] ?? 'N/A' }}</p>
                                                       @if($act['objetivo'])
                                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">{{ $act['objetivo'] }}</p>
                                                       @endif
                                                  </div>
                                                  <div class="d-flex" style="gap: 4px;">
                                                       <button class="btn btn-sm btn-light border" wire:click="iniciarEdicionActividad({{ $act['id'] }})">
                                                            <i class="fas fa-edit text-primary"></i>
                                                       </button>
                                                       <button class="btn btn-sm btn-light border" wire:confirm="¿Está seguro de eliminar esta actividad? Se eliminarán también las subactividades asociadas." wire:click="eliminarActividad({{ $act['id'] }})">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                       </button>
                                                  </div>
                                             </div>
                                        </div>
                                   @endforeach
                              </div>
                         </div>
                    </div>
               </div>

               <!-- SUBACTIVIDADES -->
               <div class="col-12 col-lg-6 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-4" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-sitemap mr-2 text-white"></i> 
                                   {{ $id_subactividad_editando ? 'Editar Subactividad' : 'Nueva Subactividad' }}
                              </h5>
                         </div>
                         <form wire:submit.prevent="agregarOEditarSubactividad" class="card-body">
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">ACTIVIDAD PADRE</label>
                                   <select class="form-control" wire:model="subactividad_actividad_id" style="height: 40px;">
                                        <option value="">Seleccione una Actividad</option>
                                        @foreach($actividades as $act)
                                             <option value="{{ $act['id'] }}">{{ $act['nombre'] }}</option>
                                        @endforeach
                                   </select>
                                   @error('subactividad_actividad_id') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">NOMBRE DE LA SUBACTIVIDAD</label>
                                   <input type="text" class="form-control" wire:model="subactividad_nombre" placeholder="Ej. Tablas Dinámicas" style="height: 40px;">
                                   @error('subactividad_nombre') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">OBJETIVO (Opcional)</label>
                                   <textarea class="form-control" wire:model="subactividad_objetivo" rows="2" placeholder="Objetivo de la subactividad..."></textarea>
                              </div>
                              <div class="mt-3 pt-3 border-top text-right">
                                   @if($id_subactividad_editando)
                                        <button type="button" class="btn btn-light mr-2 font-weight-bold" wire:click="$set('id_subactividad_editando', null)">Cancelar</button>
                                   @endif
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Guardar
                                   </button>
                              </div>
                         </form>
                    </div>

                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;"><i class="fas fa-stream mr-2 text-white"></i> Subactividades Registradas</h5>
                              <input type="text" wire:model="filtro_subactividad" wire:keydown.enter="buscar" class="form-control form-control-sm" placeholder="Buscar (Enter)..." style="width: 150px;">
                         </div>
                         <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                              <div wire:loading wire:target="buscar" class="p-4 text-center text-primary w-100">
                                   <i class="fas fa-spinner fa-spin mr-2"></i> Buscando...
                              </div>
                              <div class="list-group list-group-flush" wire:loading.remove wire:target="buscar">
                                   @foreach(collect($subactividades)->filter(fn($s) => empty($filtro_subactividad) || str_contains(strtolower($s['nombre']), strtolower($filtro_subactividad))) as $sub)
                                        <div class="list-group-item p-3">
                                             <div class="d-flex justify-content-between align-items-start">
                                                  <div>
                                                       <h6 class="font-weight-bold text-dark mb-1">{{ $sub['nombre'] }}</h6>
                                                       <p class="text-secondary small mb-1" style="font-size: 0.8rem;">Actividad: {{ $sub['actividad']['nombre'] ?? 'N/A' }}</p>
                                                       @if($sub['objetivo'])
                                                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">{{ $sub['objetivo'] }}</p>
                                                       @endif
                                                  </div>
                                                  <div class="d-flex" style="gap: 4px;">
                                                       <button class="btn btn-sm btn-light border" wire:click="iniciarEdicionSubactividad({{ $sub['id'] }})">
                                                            <i class="fas fa-edit text-primary"></i>
                                                       </button>
                                                       <button class="btn btn-sm btn-light border" wire:confirm="¿Está seguro de eliminar esta subactividad?" wire:click="eliminarSubactividad({{ $sub['id'] }})">
                                                            <i class="fas fa-trash-alt text-danger"></i>
                                                       </button>
                                                  </div>
                                             </div>
                                        </div>
                                   @endforeach
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     @endif

     <!-- SUBVIEW 5: FACILITADORES -->
     @if($pestania_activa === 'facilitadores')
          <div class="row text-dark mx-5">
               <div class="col-12 col-lg-5 mb-4">
                    <div class="card shadow-sm border-0 bg-white mb-4" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-chalkboard-teacher mr-2 text-white"></i> 
                                   {{ $id_facilitador_editando ? 'Editar Facilitador' : 'Ingresar Nuevo Facilitador' }}
                              </h5>
                         </div>

                         <form wire:submit.prevent="agregarOEditarFacilitador" class="card-body">
                              <p class="text-muted small mb-3">Si el facilitador es empleado de la empresa, puede buscarlo utilizando el panel de la derecha y seleccionarlo.</p>
                              
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">NOMBRE DEL FACILITADOR</label>
                                   <input type="text" class="form-control" wire:model="facilitador_nombre" placeholder="Ej. Dr. Juan Pérez" style="height: 40px;">
                                   @error('facilitador_nombre') <span class="text-danger small">{{ $message }}</span> @enderror
                              </div>

                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small">FICHA DE EMPLEADO (Dejar en blanco si es externo)</label>
                                   <input type="number" class="form-control" wire:model="facilitador_ficha_empleado" placeholder="Ej. 12345" style="height: 40px;" {{ $facilitador_ficha_empleado ? 'readonly' : '' }}>
                                   @if($facilitador_ficha_empleado)
                                        <button type="button" class="btn btn-link btn-sm p-0 mt-1" wire:click="$set('facilitador_ficha_empleado', '')">Limpiar Ficha</button>
                                   @endif
                                   @error('facilitador_ficha_empleado') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                              </div>

                              <div class="mt-4 pt-3 border-top text-right">
                                   @if($id_facilitador_editando)
                                        <button type="button" class="btn btn-light mr-2 font-weight-bold" wire:click="$set('id_facilitador_editando', null)">Cancelar</button>
                                   @endif
                                   <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 6px;">
                                        <i class="fas fa-save mr-1"></i> Guardar Facilitador
                                   </button>
                              </div>
                         </form>
                    </div>

                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;"><i class="fas fa-users mr-2 text-white"></i> Facilitadores Registrados</h5>
                              <input type="text" wire:model="filtro_facilitador" wire:keydown.enter="buscar" class="form-control form-control-sm" placeholder="Buscar (Enter)..." style="width: 150px;">
                         </div>
                         <div class="table-responsive" style="max-height: 400px;">
                              <div wire:loading wire:target="buscar" class="p-4 text-center text-primary w-100">
                                   <i class="fas fa-spinner fa-spin mr-2"></i> Buscando...
                              </div>
                              <table class="table table-hover mb-0" wire:loading.remove wire:target="buscar">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3">NOMBRE</th>
                                             <th class="p-3">FICHA DE EMPLEADO</th>
                                             <th class="p-3 text-right">ACCIONES</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @foreach(collect($facilitadores)->filter(fn($f) => empty($filtro_facilitador) || str_contains(strtolower($f['nombre']), strtolower($filtro_facilitador))) as $fac)
                                             <tr>
                                                  <td class="p-3"><strong class="text-dark">{{ $fac['nombre'] }}</strong></td>
                                                  <td class="p-3">
                                                       @if($fac['ficha_empleado'])
                                                            <span class="badge badge-info">{{ $fac['ficha_empleado'] }}</span>
                                                       @else
                                                            <span class="text-muted small">Externo</span>
                                                       @endif
                                                  </td>
                                                  <td class="p-3 text-right">
                                                       <button class="btn btn-sm btn-light border" wire:click="iniciarEdicionFacilitador({{ $fac['id'] }})"><i class="fas fa-edit text-primary"></i></button>
                                                       <button class="btn btn-sm btn-light border" wire:confirm="¿Está seguro de eliminar este facilitador?" wire:click="eliminarFacilitador({{ $fac['id'] }})"><i class="fas fa-trash-alt text-danger"></i></button>
                                                  </td>
                                             </tr>
                                        @endforeach
                                   </tbody>
                              </table>
                         </div>
                    </div>
               </div>

               <div class="col-12 col-lg-7 mb-4">
                    <!-- Integración Filtro Empleados para Facilitadores -->
                    @include('partials.filtro-empleados')

                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="card-body p-0">
                              <div class="table-responsive border rounded" style="max-height: 500px; overflow-y: auto;">
                                   <table class="table table-sm mb-0 table-hover">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="px-3 py-2">EMPLEADO</th>
                                                  <th class="px-3 py-2 text-right">ACCIÓN</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @forelse($this->empleadosFiltrados as $e)
                                                  <tr class="hover-bg-light">
                                                       <td class="px-3 py-2">
                                                            <strong class="text-dark d-block" style="font-size: 0.85rem;">{{ $e->nombre_empleado }}</strong>
                                                            <small class="text-muted">Ficha: {{ $e->ficha }}</small>
                                                       </td>
                                                       <td class="text-right px-3 py-2">
                                                            <button type="button" class="btn btn-sm btn-outline-primary" wire:click="seleccionarEmpleadoComoFacilitador('{{ $e->ficha }}', '{{ addslashes($e->nombre_empleado) }}')">
                                                                 <i class="fas fa-check"></i> Seleccionar
                                                            </button>
                                                       </td>
                                                  </tr>
                                             @empty
                                                  <tr><td colspan="2" class="text-center py-3 text-muted">No se encontraron empleados.</td></tr>
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
