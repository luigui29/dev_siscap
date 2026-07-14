<div class="container-fluid py-4 mx-auto">
     <!-- Encabezado de página -->
     <div class="d-flex justify-content-between align-items-center mb-4 mx-5">
          <div>
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
                    Dashboard
               </h3>
          </div>
     </div>

     <!-- Tarjetas de Estadísticas -->
     <div class="row mx-5 mb-4">
          
          
          <!-- Cursos Totales en este Año -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="card stat-card total-2 p-3 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                              <div class="text-muted font-weight-bold text-uppercase mb-1" style="font-size: 0.75rem;">Cursos Impartidos este Año</div>
                              <h3 class="mb-0 font-weight-bold text-dark">{{ $totales_anio }}</h3>
                         </div>
                         <div class="stat-icon total-2">
                              <i class="fas fa-users"></i>
                         </div>
                    </div>
               </div>
          </div>

          <!-- Ejecutados este Mes -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="card stat-card total-1 p-3 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                              <div class="text-muted font-weight-bold text-uppercase mb-1" style="font-size: 0.75rem;">Cursos Impartidos este Mes</div>
                              <h3 class="mb-0 font-weight-bold text-dark">{{ $ejecutados_mes }}</h3>
                         </div>
                         <div class="stat-icon total-1">
                              <i class="fas fa-tachometer-alt"></i>
                         </div>
                    </div>
               </div>
          </div>

          <!-- Programaciones Finales este Mes -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="card stat-card total-3 p-3 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                              <div class="text-muted font-weight-bold text-uppercase mb-1" style="font-size: 0.75rem;">Cursos por Ejecutar</div>
                              <h3 class="mb-0 font-weight-bold text-dark">{{ $finales_mes }}</h3>
                         </div>
                         <div class="stat-icon total-3">
                              <i class="fas fa-hourglass-start"></i>
                         </div>
                    </div>
               </div>
          </div>

          <!-- Pre-Programaciones este Mes -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="card stat-card total-4 p-3 shadow-sm h-100">
                    <div class="d-flex justify-content-between align-items-center">
                         <div>
                              <div class="text-muted font-weight-bold text-uppercase mb-1" style="font-size: 0.75rem;">Cursos por Aprobar</div>
                              <h3 class="mb-0 font-weight-bold text-dark">{{ $pre_mes }}</h3>
                         </div>
                         <div class="stat-icon total-4">
                              <i class="fas fa-check-double"></i>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <!-- Calendario de Programaciones -->
     <livewire:dashboard-calendario />

     <!-- Tabla de Cursos Recientes -->
     <div class="col-12 py-2 px-5">
          @include('partials.filtro-programaciones')
     </div>
     
     <div class="card-corporate shadow-sm border-0 mx-5 position-relative">
          <!-- Indicador de Carga para Tabla de Cursos Recientes -->
          <div wire:loading class="position-absolute w-100 h-100" style="background-color: rgba(255, 255, 255, 0.7); z-index: 10; top: 0; left: 0; border-radius: 8px;">
               <div class="d-flex flex-column justify-content-center align-items-center h-100">
                    <div class="spinner-border text-primary mb-2" role="status">
                         <span class="sr-only">Cargando...</span>
                    </div>
                    <span class="text-primary font-weight-bold">Actualizando resultados...</span>
               </div>
          </div>

          <div class="card-header d-flex justify-content-between align-items-center py-3" style="background-color: #64748B; border-bottom: none;">
               <div class="d-flex align-items-center">
                    <i class="fas fa-chart-line mr-2" style="font-size: 1.25rem; color: #FFFFFF;"></i>
                    <h5 class="mb-0 font-weight-bold text-white">
                         Cursos Recientes
                    </h5>
               </div>
          </div>

          <div class="card-body p-0">
               <div class="table-responsive">
                    <table class="table table-hover mb-0" style="min-width: 850px;">
                         <thead>
                              <tr>
                                   <th class="px-3 py-2">ACTIVIDAD</th>
                                   <th class="p-2">SUBACTIVIDAD</th>
                                   <th class="p-2">FACILITADOR</th>
                                   <th class="p-2">FECHA</th>
                                   <th class="p-2">LUGAR</th>
                                   <th class="p-2">APROBADO</th>
                                   <th class="p-2">EJECUTADO</th>
                              </tr>
                         </thead>
                         <tbody>
                              @forelse($cursos as $curso)
                                   <tr>
                                        <td class="px-3 py-2 align-middle">
                                             <strong class="text-dark d-block" style="font-size: 0.9rem;">{{ $curso->actividad->nombre }}</strong>
                                             <span class="small d-block text-secondary"><strong>Área:</strong> {{ $curso->actividad->area->nombre }}</span>                                             
                                        </td>
                                        <td class="p-2 align-middle">
                                             <span class="text-dark" style="font-size: 0.9rem;">{{ $curso->subactividad?->nombre ?? '---' }}</span>
                                        </td>
                                        <td class="p-2 align-middle">
                                             <span class="text-secondary" style="font-size: 0.9rem;">{{ $curso->facilitador->nombre }}</span>
                                        </td>
                                        <td class="p-2 align-middle">
                                             <span class="text-secondary" style="font-size: 0.9rem;">{{ $curso->fecha->format('d/m/Y') }}</span>
                                        </td>
                                        <td class="p-2 align-middle">
                                             <span class="text-muted" style="font-size: 0.9rem;">{{ $curso->lugar }}</span>
                                        </td>
                                        <td class="p-2 align-middle">
                                             @if($curso->aprobado)
                                                  <span class="d-inline-flex align-items-center text-success font-weight-bold" style="font-size: 0.85rem; gap: 4px;">
                                                       <i class="fas fa-check-circle"></i> Aprobado
                                                  </span>
                                             @else
                                                  <span class="d-inline-flex align-items-center text-warning font-weight-bold" style="font-size: 0.85rem; gap: 4px;">
                                                       <i class="fas fa-clock"></i> Pendiente
                                                  </span>
                                             @endif
                                        </td>
                                        <td class="align-middle">
                                             @if($curso->ejecutado)
                                                  <span class="d-inline-flex align-items-center text-success font-weight-bold" style="font-size: 0.85rem; gap: 4px;">
                                                       <i class="fas fa-check-circle"></i> Ejecutado
                                                  </span>
                                             @else
                                                  <span class="d-inline-flex align-items-center text-warning font-weight-bold" style="font-size: 0.85rem; gap: 4px;">
                                                       <i class="fas fa-clock"></i> Pendiente
                                                  </span>
                                             @endif
                                        </td>
                                   </tr>
                              @empty
                                   <tr>
                                        <td colspan="7" class="text-center py-4">
                                             <div class="empty-state py-4 text-center">
                                                  <i class="fas fa-search text-muted" style="font-size: 2rem;"></i>
                                                  <p class="mb-0 mt-2 font-weight-bold text-secondary">No se encontraron cursos recientes</p>
                                             </div>
                                        </td>
                                   </tr>
                              @endforelse
                         </tbody>
                    </table>
               </div>
          </div>
     </div>
</div>
