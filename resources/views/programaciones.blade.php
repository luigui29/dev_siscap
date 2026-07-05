<x-layouts.app>

<div class="container-fluid py-4 mx-auto">

<!-- PRE-PROGRAMACIONES -->
@if ($pestania === 'pre')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Pre-Programación
        </h3>

        <div class="row">
            <div class="col-4">
                <div class="sticky-top" style="top: 20px">
                    <livewire:filtro-programaciones />
                </div>
            </div>
            <div class="col-8">
                <livewire:data-preprogram />
            </div>
        </div>

        <!-- MODALES -->
        <livewire:modal-pre-program-curso />
        
    </div>

</div>
@endif

<!-- PROGRAMACIONES FINALES -->
@if ($pestania === 'final')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Gestión de Desarrollo Gerencial
        </h3>

        <livewire:filtro-gerencias />
        <livewire:data-gerencias />
    </div>
@endif

<!-- EJECUCIONES -->

@if($pestania === 'ejecucion')

@endif

</x-layouts.app>