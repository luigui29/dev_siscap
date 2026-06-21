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

     <!-- Calendario Anual de Programaciones -->
     <livewire:dashboard-calendario />

     <!-- Tabla de Cursos Recientes -->
     <div class="card-corporate shadow-sm border-0 mx-5">
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
                                   <th>ACTIVIDAD</th>
                                   <th>SUBACTIVIDAD</th>
                                   <th>FACILITADOR</th>
                                   <th>FECHA</th>
                                   <th>LUGAR</th>
                                   <th>APROBADO</th>
                                   <th>EJECUTADO</th>
                              </tr>
                         </thead>
                         <tbody>
                              @forelse($cursos as $curso)
                                   <tr>
                                        <td class="align-middle">
                                             <span class="status-badge-corp badge-corporate-blue">
                                                  {{ $curso->actividad }}
                                             </span>
                                        </td>
                                        <td class="align-middle text-dark font-weight-bold" style="font-size: 0.9rem;">
                                             {{ $curso->subactividad }}
                                        </td>
                                        <td class="align-middle text-secondary" style="font-size: 0.9rem;">
                                             {{ $curso->facilitador }}
                                        </td>
                                        <td class="align-middle text-secondary" style="font-size: 0.9rem;">
                                             {{ $curso->fecha->format('d/m/Y') }}
                                        </td>
                                        <td class="align-middle text-muted" style="font-size: 0.9rem;">
                                             {{ $curso->lugar }}
                                        </td>
                                        <td class="align-middle">
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
                                                  <span class="d-inline-flex align-items-center text-info font-weight-bold" style="font-size: 0.85rem; gap: 4px;">
                                                       <i class="fas fa-play-circle"></i> Ejecutado
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
