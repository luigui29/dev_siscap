<x-layouts.app>

<div class="container-fluid py-4 mx-auto">
    
<!-- PERFILES INDIVIDUALES-->    
    <div class="d-flex flex-column justify-content-start mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold">
            Gestión de Desarrollo Individual
        </h3>

        <livewire:filtro-empleados />

        <livewire:data-empleados />

        <livewire:educacion-empleados />
        <livewire:experiencia-empleados />
        <livewire:ingles-empleados />
    </div>

</div>

</x-layouts.app>