<!-- SCRIPTS NUCLEOS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
     // SCRIPTS A EJECUTAR TRAS CARGAR ALPINE (ANTES DE SER INICIALIZADO EN LA PÁGINA)
     document.addEventListener('alpine:init', () => {
          /*
          * Alpine.store: se guarda una variable reactivas de Alpine que
          * puede ser compartidas entre componentes y vistas.
          */

          // Estado de carga tras usar filtro de empleados
          Alpine.store('empleados', {
               cargando: false
          });

          // Estado de carga tras abrir modal de educacion
          Alpine.store('educaciones', {
               cargando: false
          });

          // Estado de carga tras abrir modal de experiencias laborales
          Alpine.store('experiencias', {
               cargando: false
          });

          // Estado de carga tras abrir modal de nivel de inglés
          Alpine.store('ingles', {
               cargando: false
          });
          
          // Estado de carga tras usar filtro de gerencias
          Alpine.store('gerencias', {
               cargando: false
          });

          // Estado de carga tras usar filtro de programaciones
          Alpine.store('programaciones', {
               cargando: false
          });
     });

     // SCRIPTS A EJECUTAR TRAS CARGAR LIVEWIRE (ANTES DE SER INICIALIZADO EN LA PÁGINA)
     document.addEventListener('livewire:init', () => {
          /* 
          * Este hook se ejecuta cada vez que un componente Livewire 
          * realiza un "commit" (actualización de datos).
          */
          Livewire.hook('commit', ({ component, succeed, fail }) => {

               /* Verificar el uso de un filtro de búsqueda de empleados y activar
               estado de carga de componentes correspondientes */
               if (component.name === 'filtro-empleados' || component.name === 'data-empleados') {
                    
                    Alpine.store('empleados').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('empleados').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('empleados').cargando = false;
                    });
               }

               /* Activar estado de carga para el modal de educación */
               if (component.name === 'educacion-empleados') {
                    
                    Alpine.store('educaciones').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('educaciones').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('educaciones').cargando = false;
                    });
               }

               /* Activar estado de carga para el modal de experiencias laborales */
               if (component.name === 'experiencia-empleados') {
                    
                    Alpine.store('experiencias').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('experiencias').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('experiencias').cargando = false;
                    });
               }

               /* Activar estado de carga para el modal de nivel de inglés */
               if (component.name === 'ingles-empleados') {
                    
                    Alpine.store('ingles').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('ingles').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('ingles').cargando = false;
                    });
               }

               /* Verificar el uso de un filtro de búsqueda de gerencias y activar
               estado de carga de componentes correspondientes */
               if (component.name === 'filtro-gerencias' || component.name === 'data-gerencias') {
                    
                    Alpine.store('gerencias').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('gerencias').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('gerencias').cargando = false;
                    });
               }

                /* Verificar el uso de un filtro de búsqueda de programaciones y activar
               estado de carga de componentes correspondientes */
               if (component.name === 'filtro-programaciones' || component.name === 'data-preprogram') {
                    
                    Alpine.store('programaciones').cargando = true;

                    succeed(() => {
                         setTimeout(() => {
                              Alpine.store('programaciones').cargando = false;
                         }, 50);
                    });

                    fail(() => {
                         Alpine.store('programaciones').cargando = false;
                    });
               }
          });
     });

     // SCRIPTS Y EVENTOS PARA MODALES BOOTSTRAP
     /* [VISTA: PERFIL INDIVIDUAL] NIVEL EDUCATIVO DEL EMPLEADO*/
     window.addEventListener('listo-modal-educacion', event => {
          $('#modal_educacion').modal('show');
     });

     window.addEventListener('cerrar-modal-educacion', event => {
          $('#modal_educacion').modal('hide');
     });
     /* [VISTA: PERFIL INDIVIDUAL] EXPERIENCIAS LABORALES DEL EMPLEADO*/
     window.addEventListener('listo-modal-experiencia', event => {
          $('#modal_experiencia').modal('show');
     });

     window.addEventListener('cerrar-modal-experiencia', event => {
          $('#modal_experiencia').modal('hide');
     });
     /* [VISTA: PERFIL INDIVIDUAL] NIVEL DE INGLÉS DEL EMPLEADO*/
     window.addEventListener('listo-modal-ingles', event => {
          $('#modal_ingles').modal('show');
     });

     window.addEventListener('cerrar-modal-ingles', event => {
          $('#modal_ingles').modal('hide');
     });
     /* [VISTA: PRE-PROGRAMACIÓN] EDICIÓN DE CURSOS PRE-PROGRAMADOS */
     window.addEventListener('listo-modal-pre-program-curso', event => {
          $('#modal_pre_program_curso').modal('show');
     });

     window.addEventListener('cerrar-modal-pre-program-curso', event => {
          $('#modal_pre_program_curso').modal('hide');
     });
     /* [VISTA: PRE-PROGRAMACIÓN] EDICIÓN DE EMPLEADOS MATRICULADOS */
     window.addEventListener('listo-modal-pre-program-empleados', event => {
          $('#modal_pre_program_empleados').modal('show');
     });

     window.addEventListener('cerrar-modal-pre-program-empleados', event => {
          $('#modal_pre_program_empleados').modal('hide');
     });
     /* [VISTA: PROGRAMACIÓN FINAL] TRABAJADORES MATRICULADOS EN UN CURSO */
     window.addEventListener('abrir-modal-programacion-trabajadores', event => {
          $('#modalProgramacionTrabajadores').modal('show');
     });
</script>
