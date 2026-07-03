<x-layouts.app>

<div class="container-fluid py-4 mx-auto">

<!-- PERFILES INDIVIDUALES-->
@if ($pestania === 'individual')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Gestión de Desarrollo Individual
        </h3>

        <livewire:filtro-empleados />
        <livewire:data-empleados />

        <!-- MODALES -->
        <livewire:educacion-empleados />
        <livewire:experiencia-empleados />
        <livewire:ingles-empleados />
    </div>

</div>
@endif

<!-- PERFILES GERENCIALES -->
@if ($pestania === 'gerencia')
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold my-3">
            Gestión de Desarrollo Gerencial
        </h3>

        <livewire:filtro-gerencias />
        <livewire:data-gerencias />
    </div>
@endif

</x-layouts.app>