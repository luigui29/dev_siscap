<x-layouts.app>

<div class="container-fluid py-4 mx-auto">

<!-- PRE-PROGRAMACIONES -->
@if ($pestania === 'pre')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Pre-Programación
        </h3>

        <div class="row">
            <div class="col-8">
                <livewire:filtro-programaciones />

                <div class="mt-2 d-flex flex-row-reverse">
                    <button class="btn btn-lg btn-primary" x-data @click="$dispatch('crear-pre-programacion')">
                        <i class="fas fa-save mr-2"></i>Crear Pre-Programación con Información Ingresada
                    </button>
                </div>
            </div>
            <div class="col-4">
                <livewire:data-preprogram />
            </div>
        </div>

        <!-- MODALES -->
        <livewire:modal-pre-program-curso />
        <livewire:modal-pre-program-empleados />
    </div>
@endif

<!-- PROGRAMACIONES FINALES -->
@if ($pestania === 'final')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Programación Final
        </h3>

        <div class="row">
            <div class="col-8">
                <livewire:filtro-programaciones />
                <livewire:data-program-final />
            </div>
        </div>
    </div>

    <!-- MODALES -->
    <livewire:modal-program-empleados />
@endif

<!-- EJECUCIONES -->

@if($pestania === 'ejecucion')

@endif

</div>

</x-layouts.app>