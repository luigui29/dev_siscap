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
     });

     // SCRIPTS A EJECUTAR TRAS CARGAR LIVEWIRE (ANTES DE SER INICIALIZADO EN LA PÁGINA)
     document.addEventListener('livewire:init', () => {
          /* 
          * Este hook se ejecuta cada vez que un componente Livewire 
          * realiza un "commit" (actualización de datos).
          */
          Livewire.hook('commit', ({ component, succeed, fail }) => {

               /* Verificar el uso de un filtro de búsqueda y activar
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
          });
     });

     // MODAL: TRABAJADORES MATRICULADOS EN UN CURSO --- VISTA: PROGRAMACIÓN
     window.addEventListener('abrir-modal-programacion-trabajadores', event => {
          $('#modalProgramacionTrabajadores').modal('show');
     });
</script>
