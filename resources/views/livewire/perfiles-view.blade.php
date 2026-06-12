<div class="container-fluid py-4" style="background-color: #F2F2F2; max-width: 1440px; margin: 0 auto;">
     <!-- Toast Notification -->
     @if($notificacion)
          <div class="alert alert-{{ $notificacion['tipo'] === 'success' ? 'success' : ($notificacion['tipo'] === 'danger' ? 'danger' : 'info') }} alert-dismissible fade show shadow border-0 position-fixed d-flex align-items-center" role="alert" style="right: 20px; top: 80px; z-index: 1060; gap: 10px; border-radius: 8px; min-width: 320px;">
               <i class="fas fa-info-circle" style="font-size: 1.25rem;"></i>
               <div>{{ $notificacion['mensaje'] }}</div>
               <button type="button" class="close ml-auto" wire:click="limpiarNotificacion" style="outline: none;">
                    <span>&times;</span>
               </button>
          </div>
     @endif

     <!-- Pantalla con Cabecera -->
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 text-dark">
          <div>
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
                    Gestión de Perfiles y Hoja de Vida
               </h3>
               <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Control de expedientes de adiestramiento, educación, currículo técnico y matriz del plan de Horas-Hombre del personal.
               </p>
          </div>
     </div>

     <!-- Navigation Sub-Menu Tab List -->
     <div class="card shadow-sm border-0 bg-white mb-4" style="border-radius: 8px;">
          <div class="card-body p-2 d-flex flex-wrap" style="gap: 8px;">
               <button 
                    wire:click="$set('pestania_activa', 'individual')" 
                    class="btn d-flex align-items-center {{ $pestania_activa === 'individual' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-id-badge"></i> Perfil Individual
               </button>

               <button 
                    wire:click="$set('pestania_activa', 'gerencia')" 
                    class="btn d-flex align-items-center {{ $pestania_activa === 'gerencia' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-th-list"></i> Matriz Horas Gerencias
               </button>

               <button 
                    wire:click="$set('pestania_activa', 'siscap')" 
                    class="btn d-flex align-items-center {{ $pestania_activa === 'siscap' ? 'btn-primary' : 'btn-light text-secondary' }}" 
                    style="gap: 8px; font-weight: 600; font-size: 0.85rem; border-radius: 6px; padding: 0.5rem 1rem;"
               >
                    <i class="fas fa-user-shield"></i> Colaboradores SISCAP
               </button>
          </div>
     </div>

     <!-- TAB 1: PERFIL INDIVIDUAL -->
     @if($pestania_activa === 'individual')
          <div class="row text-dark">
               <div class="col-12 col-lg-4 mb-4">
                    <div class="card shadow-sm border-0 bg-white h-100" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-search mr-2"></i> Consultar Empleado
                              </h5>
                         </div>

                         <div class="card-body">
                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small text-muted">SELECCIONAR COLABORADOR</label>
                                   <select class="form-control" wire:model.live="ficha_usuario_seleccionado" style="height: 44px; font-weight: 600;">
                                        @foreach($colaboradores as $c)
                                             <option value="{{ $c->ficha }}">[{{ $c->ficha }}] - {{ $c->name }}</option>
                                        @endforeach
                                   </select>
                              </div>

                              @php
                                   $active_employee = $colaboradores->firstWhere('ficha', $ficha_usuario_seleccionado);
                              @endphp

                              @if($active_employee)
                                   <div class="p-3 bg-light rounded text-center border mt-4">
                                        <div class="avatar-text m-auto d-flex align-items-center justify-content-center text-white font-weight-bold" style="background-color: #5DADE2; width: 64px; height: 64px; border-radius: 50%; font-size: 1.5rem; border: 2px solid #FFF; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                             {{ substr($active_employee->name, 0, 2) }}
                                        </div>
                                        <h5 class="font-weight-bold text-dark mt-3 mb-1" style="font-size: 1.1rem;">
                                             {{ $active_employee->name }}
                                        </h5>
                                        <span class="badge badge-success px-2 py-1 mb-2 text-uppercase font-weight-bold" style="font-size: 0.7rem; border-radius: 50px;">
                                             FICHA: {{ $active_employee->ficha }}
                                        </span>

                                        <div class="text-left mt-3 pt-3 border-top" style="font-size: 0.85rem;">
                                             <p class="mb-2 text-dark"><strong>Cédula:</strong> V-15.392.091</p>
                                             <p class="mb-2 text-dark"><strong>Cargo:</strong> {{ $active_employee->role }}</p>
                                             <p class="mb-2 text-dark"><strong>Gerencia:</strong> {{ $active_employee->texto_gerencia ?? 'GERENCIA DE ADIESTRAMIENTO' }}</p>
                                             <p class="mb-0 text-dark"><strong>Fecha Ingreso:</strong> 2021-02-15</p>
                                        </div>
                                   </div>
                              @endif
                         </div>
                    </div>
               </div>

               <div class="col-12 col-lg-8 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-file-invoice mr-2 text-white"></i> Desarrollo Académico & Técnico del Colaborador
                              </h5>
                              <button class="btn btn-sm btn-light font-weight-bold" onclick="alert('Exportando curriculum estructurado...')">
                                   <i class="fas fa-file-excel mr-1"></i> Resumen Excel
                              </button>
                         </div>

                         <div class="p-4">
                              
                              <!-- Section 1: Education -->
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                   <h6 class="font-weight-bold text-dark mb-0">
                                        <i class="fas fa-graduation-cap text-primary mr-2"></i> 1. Formación Educativa / Títulos Obtenidos
                                   </h6>
                              </div>

                              <div class="table-responsive mb-4 border rounded">
                                   <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2" style="font-size: 0.75rem;">NIVEL</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">TÍTULO O CARRERA</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">INSTITUCIÓN</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">AÑO</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @php
                                                  $active_edu = array_filter($educaciones, function($edu) {
                                                       return $edu['ficha'] === $this->ficha_usuario_seleccionado;
                                                  });
                                             @endphp
                                             @forelse($active_edu as $edu)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">{{ $edu['nivel_educativo'] }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;">
                                                            {{ $edu['titulo'] }} <br>
                                                            <small class="text-muted">{{ $edu['especialidad'] }}</small>
                                                       </td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $edu['instituto'] }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ substr($edu['fecha_culminado'], 0, 4) }}</td>
                                                  </tr>
                                             @empty
                                                  <tr>
                                                       <td colspan="4" class="text-center py-3 text-muted small">No hay formación previa cargada.</td>
                                                  </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>

                              <!-- Add Education Mini Form -->
                              <div class="p-3 border rounded bg-light mb-4">
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-plus-circle text-primary"></i> Ingresar Registro de Educación</strong>
                                   <div class="row">
                                        <div class="col-md-3 form-group mb-2">
                                             <select class="form-control form-control-sm" wire:model="edu_nivel_educativo">
                                                  <option value="Técnico Medio">Técnico Medio</option>
                                                  <option value="T.S.U.">T.S.U.</option>
                                                  <option value="Universitario">Universitario</option>
                                                  <option value="Postgrado">Postgrado</option>
                                             </select>
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_titulo" placeholder="Título Obtenido">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="edu_instituto" placeholder="Instituto/Universidad">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                             <button wire:click="agregarEducacion" class="btn btn-sm btn-primary w-full">Cargar</button>
                                        </div>
                                   </div>
                              </div>

                              <!-- Section 2: Laboral Academic Experience -->
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                   <h6 class="font-weight-bold text-dark mb-0">
                                        <i class="fas fa-briefcase text-primary mr-2"></i> 2. Experiencia Laboral e Industrial
                                   </h6>
                              </div>

                              <div class="table-responsive mb-4 border rounded">
                                   <table class="table table-sm mb-0">
                                        <thead class="bg-light">
                                             <tr>
                                                  <th class="p-2" style="font-size: 0.75rem;">CARGO DESEMPEÑADO</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">EMPRESA EXECUTORA</th>
                                                  <th class="p-2 text-center" style="font-size: 0.75rem;">DESDE/HASTA</th>
                                                  <th class="p-2" style="font-size: 0.75rem;">OBSERVACIONES</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             @php
                                                  $active_exp = array_filter($experiencias, function($exp) {
                                                       return $exp['ficha'] === $this->ficha_usuario_seleccionado;
                                                  });
                                             @endphp
                                             @forelse($active_exp as $exp)
                                                  <tr>
                                                       <td class="p-2 font-weight-bold" style="font-size: 0.85rem;">{{ $exp['cargo_desempeniado'] }}</td>
                                                       <td class="p-2" style="font-size: 0.85rem;">{{ $exp['empresa'] }}</td>
                                                       <td class="p-2 text-center" style="font-size: 0.85rem;">{{ $exp['desde'] }} / {{ $exp['hasta'] }}</td>
                                                       <td class="p-2 text-muted small" style="font-size: 0.85rem;">{{ $exp['observacion'] }}</td>
                                                  </tr>
                                             @empty
                                                  <tr>
                                                       <td colspan="4" class="text-center py-3 text-muted small">No hay experiencia cargada.</td>
                                                  </tr>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>

                              <!-- Add Experience Mini Form -->
                              <div class="p-3 border rounded bg-light mb-4">
                                   <strong class="d-block text-dark small mb-2"><i class="fas fa-plus-circle text-primary"></i> Ingresar Experiencia Laboral</strong>
                                   <div class="row">
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_cargo" placeholder="Cargo Desempeñado">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_empresa" placeholder="Empresa Matriz">
                                        </div>
                                        <div class="col-md-3 form-group mb-2">
                                             <input type="text" class="form-control form-control-sm" wire:model="exp_observacion" placeholder="Detalle Omitido">
                                        </div>
                                        <div class="col-md-3 mb-2">
                                             <button wire:click="agregarExperiencia" class="btn btn-sm btn-primary w-full">Cargar</button>
                                        </div>
                                   </div>
                              </div>

                              <!-- Section 3: English Skills -->
                              <hr class="my-4">
                              <h6 class="font-weight-bold text-dark mb-2">
                                   <i class="fas fa-language text-primary mr-2"></i> 3. Nivel de Competencia en Inglés Técnico
                              </h6>
                              <p class="text-secondary small mb-3">Marque los niveles correspondientes aprobados validamente según directrices de RRHH:</p>

                              <div class="p-3 border rounded bg-light d-flex flex-wrap justify-content-between" style="gap: 16px;">
                                   <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="ing_i1" wire:click="alternarIngles('i1')" @if($ing_i1) checked @endif>
                                        <label class="custom-control-label font-weight-bold" for="ing_i1">Inglés Instrumental Básico (I1)</label>
                                   </div>
                                   <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="ing_i2" wire:click="alternarIngles('i2')" @if($ing_i2) checked @endif>
                                        <label class="custom-control-label font-weight-bold" for="ing_i2">Inglés Técnico Operativo (I2)</label>
                                   </div>
                                   <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="ing_i3" wire:click="alternarIngles('i3')" @if($ing_i3) checked @endif>
                                        <label class="custom-control-label font-weight-bold" for="ing_i3">Traducción de Manuales SHA (I3)</label>
                                   </div>
                                   <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="ing_i4" wire:click="alternarIngles('i4')" @if($ing_i4) checked @endif>
                                        <label class="custom-control-label font-weight-bold" for="ing_i4">Conversacional Fluido (I4)</label>
                                   </div>
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

     <!-- TAB 3: COLABORADORES SISCAP -->
     @if($pestania_activa === 'siscap')
          <div class="row text-dark">
               <div class="col-12 col-md-4 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-user-plus mr-2"></i> Registrar Colaborador Habilitado
                              </h5>
                         </div>

                         <form wire:submit.prevent="crearColaborador" class="card-body">
                              <p class="text-secondary small mb-3">Defina los datos de la ficha para autorizar su participación en la plataforma adiestradora:</p>

                              <div class="form-group mb-2">
                                   <label class="font-weight-bold small text-muted">AÑO / FICHA CORPORATIVA</label>
                                   <input type="text" class="form-control form-control-sm" wire:model="nueva_ficha" placeholder="Ej: F-12209" style="height: 38px;">
                              </div>

                              <div class="form-group mb-2">
                                   <label class="font-weight-bold small text-muted">NOMBRE Y APELLIDO</label>
                                   <input type="text" class="form-control form-control-sm" wire:model="nuevo_nombre" placeholder="Carlos Mendoza" style="height: 38px;">
                              </div>

                              <div class="form-group mb-2">
                                   <label class="font-weight-bold small text-muted">CORREO CORPORATIVO</label>
                                   <input type="email" class="form-control form-control-sm" wire:model="nuevo_correo" placeholder="carlos.mendoza@venprecar.com.ve" style="height: 38px;">
                              </div>

                              <div class="form-group mb-3">
                                   <label class="font-weight-bold small text-muted">CARGO DE REFERENCIA</label>
                                   <select class="form-control form-control-sm" wire:model="nuevo_rol" style="height: 38px;">
                                        <option value="Instructor Adjunto">Instructor Adjunto</option>
                                        <option value="Técnico NDT">Técnico NDT</option>
                                        <option value="Súper-Especialista Progresivo">Súper-Especialista Progresivo</option>
                                   </select>
                              </div>

                              <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold">
                                   <i class="fas fa-save mr-1"></i> Confirmar y Guardar Perfil
                              </button>
                         </form>
                    </div>
               </div>

               <div class="col-12 col-md-8 mb-4">
                    <div class="card shadow-sm border-0 bg-white" style="border-radius: 8px;">
                         <div class="border-bottom p-3 d-flex justify-content-between align-items-center" style="background-color: #64748B; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                              <h5 class="font-weight-bold mb-0 text-white" style="font-size: 1rem;">
                                   <i class="fas fa-user-shield mr-2"></i> Colección de Colaboradores e Inspectores Autorizados
                              </h5>
                              <div class="search-box position-relative">
                                   <input 
                                        type="text" 
                                        class="form-control text-dark @error('termino_busqueda') is-invalid @enderror" 
                                        placeholder="Buscar..." 
                                        wire:model.live="termino_busqueda"
                                        style="width: 200px; border-radius: 50px; font-size: 0.8rem; height: 32px; padding-left: 28px;"
                                   />
                                   <i class="fas fa-search position-absolute text-muted" style="left: 10px; top: 10px; font-size: 0.78rem;"></i>
                              </div>
                         </div>

                         <div class="table-responsive">
                              <table class="table table-hover mb-0">
                                   <thead class="bg-light">
                                        <tr>
                                             <th class="p-3">FICHA</th>
                                             <th class="p-3">EMPLEADO TRABAJADOR</th>
                                             <th class="p-3">PERMISO / CONTROL</th>
                                             <th class="p-3 text-center">ESTADO</th>
                                             <th class="p-3 text-right">ACCIONES</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        @forelse($colaboradores as $c)
                                             <tr>
                                                  <td class="p-3">
                                                       <span class="badge badge-light px-3 py-2 text-primary font-weight-bold border" style="font-size: 0.82rem; border-radius: 6px;">
                                                            <i class="far fa-id-card mr-1"></i> {{ $c->ficha }}
                                                       </span>
                                                  </td>
                                                  <td class="p-3">
                                                       <div class="d-flex align-items-center" style="gap: 10px;">
                                                            <div class="avatar-text text-white d-flex align-items-center justify-content-center text-uppercase font-weight-bold" style="width: 34px; height: 34px; border-radius: 50%; background-color:#5DADE2; font-size: 0.8rem;">
                                                                 {{ substr($c->name, 0, 2) }}
                                                            </div>
                                                            <div>
                                                                 <span class="font-weight-bold text-dark d-block" style="font-size: 0.88rem;">{{ $c->name }}</span>
                                                                 <span class="text-muted d-block" style="font-size: 0.78rem;">{{ $c->email }}</span>
                                                            </div>
                                                       </div>
                                                  </td>
                                                  <td class="p-3">
                                                       <span class="font-weight-bold text-secondary text-capitalize d-block mb-1" style="font-size: 0.82rem;">{{ $c->role }}</span>
                                                       <div class="d-flex flex-wrap" style="gap: 3px;">
                                                            @foreach(($c->roles ?? []) as $role)
                                                                 <span class="badge bg-light text-secondary border font-weight-bold" style="font-size: 0.65rem;">{{ $role }}</span>
                                                            @endforeach
                                                       </div>
                                                  </td>
                                                  <td class="p-3 text-center">
                                                       <span class="badge text-uppercase font-weight-bold py-1 px-3 {{ $c->status === 'ACTIVO' ? 'badge-success' : 'badge-danger' }}" style="font-size: 0.7rem; border-radius: 50px;">
                                                            {{ $c->status }}
                                                       </span>
                                                  </td>
                                                  <td class="p-3 text-right">
                                                       <div class="d-flex justify-content-end" style="gap: 6px;">
                                                            <button class="btn btn-sm btn-light border" wire:click="alternarEstado('{{ $c->ficha }}')">
                                                                 <i class="fas fa-power-off text-warning"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-light border" wire:click="eliminarColaborador('{{ $c->ficha }}')">
                                                                 <i class="fas fa-trash-alt text-danger"></i>
                                                            </button>
                                                       </div>
                                                  </td>
                                             </tr>
                                        @empty
                                             <tr>
                                                  <td colspan="5" class="text-center py-5 text-muted">
                                                       Ningún colaborador registrado en la base de datos de SISCAP.
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

</div>
