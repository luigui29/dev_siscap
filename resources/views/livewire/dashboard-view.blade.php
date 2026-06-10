<div class="container-fluid py-4">
     <!-- Encabezado de página -->
     <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
               <h3 style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #334155; margin: 0;">
                    Dashboard
               </h3>
               <p class="text-muted mb-0" style="font-size: 0.9rem;">
                    Resumen general del estado de capacitación de colaboradores y cursos registrados.
               </p>
          </div>
     </div>

     <!-- Fila de Tarjetas Estadísticas -->
     <div class="row mb-4">
          
          <!-- Cursos Impartidos este Mes -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="statistics-card statistics-card1">
                    <div class="statistics-inner">
                         <div class="statistics-title">Cursos Impartidos este Mes</div>
                         <div class="statistics-value">42</div>
                    </div>
                    <i class="fas fa-tachometer-alt icon-overlay"></i>
               </div>
          </div>

          <!-- Cursos Impartidos este Año -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="statistics-card statistics-card2">
                    <div class="statistics-inner">
                         <div class="statistics-title">Cursos Impartidos este Año</div>
                         <div class="statistics-value">356</div>
                    </div>
                    <i class="fas fa-users icon-overlay"></i>
               </div>
          </div>

          <!-- Cursos por Ejecutar -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="statistics-card statistics-card3">
                    <div class="statistics-inner">
                         <div class="statistics-title">Cursos por Ejecutar</div>
                         <div class="statistics-value">18</div>
                    </div>
                    <i class="fas fa-hourglass-start icon-overlay"></i>
               </div>
          </div>

          <!-- Cursos por Aprobar -->
          <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
               <div class="statistics-card statistics-card4">
                    <div class="statistics-inner">
                         <div class="statistics-title">Cursos por Aprobar</div>
                         <div class="statistics-value">7</div>
                    </div>
                    <i class="fas fa-check-double icon-overlay"></i>
               </div>
          </div>

     </div>

     <!-- Tabla de Cursos Recientes -->
     <div class="card-corporate shadow-sm border-0">
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
