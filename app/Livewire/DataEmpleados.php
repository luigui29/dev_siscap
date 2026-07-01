<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

use App\Models\RrhhPersonal;
use App\Models\NivelEducativo;

class DataEmpleados extends Component
{
    /* PROPIEDADES */
    public $data_filtrada = [
        'ficha' => null,
        'cedula' => null,
        'nombre' => null,
        'gerencia' => null,
        'cargo' => null,
        'unidad' => null
    ];

    public $ficha_seleccionada = null;

    /* EVENTOS */
    /*
    * Al recibir la busqueda del filtro, se guarda en la propiedad
    * y se reinicia la ficha del empleado seleccionado (si se había seleccionado uno previamente)  
    */ 
    #[On('busqueda-filtrada')]
    public function obtenerDataFiltrada($filtros)
    {
        $this->data_filtrada = $filtros;
        $this->reset('ficha_seleccionada');
    }

    /*
    * Tras actualizar los registros se re-renderiza el componente
    * para mostrarlos en la página sin recargar
    */ 
    #[On('educacion-actualizada')]
    public function actualizar()
    {
        
    }

    /* PROPIEDADES COMPUTADAS */
    // Todos los empleados según filtros (limitado a 50 resultados)
    #[Computed]
    public function empleados()
    {
        return $this->filtrar(RrhhPersonal::query())
                    ->orderBy('nombre_empleado', 'asc')
                    ->limit(50)
                    ->get();
    }

    // Retornar el empleado seleccionado si el usuario selecciona de la lista
    #[Computed]
    public function empleado_seleccionado()
    {
        if (!$this->ficha_seleccionada) {
            return null;
        }

        return RrhhPersonal::find($this->ficha_seleccionada);
    } 

    // Retornar las educaciones del empleado si el usuario selecciona de la lista
    #[Computed]
    public function educaciones()
    {
        if (!$this->ficha_seleccionada) {
            return null;
        }

        return NivelEducativo::where('ficha_empleado', $this->ficha_seleccionada)->get();
    }

    public function filtrar($query)
    {
        $campos = [
            'ficha' => $this->data_filtrada['ficha'],
            'cedula' => $this->data_filtrada['cedula'],
            'nombre_empleado' => $this->data_filtrada['nombre'],
            'texto_gerencia' => $this->data_filtrada['gerencia'],
            'texto_cargo' => $this->data_filtrada['cargo'],
            'texto_unidad' => $this->data_filtrada['unidad']
        ];

        foreach ($campos as $campo => $valor) {
            if (!empty($valor)) {
                $query->where($campo, 'ilike', '%' . $valor . '%');
            }
        }

        return $query;
    }

    public function render()
    {
        return view('livewire.data-empleados');
    }
};