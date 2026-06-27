<div class="container-fluid py-4 mx-auto">
    
<!-- PERFILES INDIVIDUALES-->
    @if(menu_activo === 'individual')
    
    <div class="d-flex flex-row justify-content-start align-items-center mb-4 mx-5 text-dark">
        <h3 class="font-weight-bold">
            Gestión de Desarrollo Individual
        </h3>
    </div>

    @endif

<!-- PERFILES GERENCIALES-->
    @if(menu_activo === 'gerencial')

    <div class="d-flex flex-row justify-content-start align-items-center mb-4 mx-5 text-dark">
          <h3 class="font-weight-bold">
               Gestión de Desarrollo Gerencial
          </h3>
    </div>
    
    @endif
</div>