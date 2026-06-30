<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

use App\Models\RrhhPersonal;

class DataEmpleados extends Component
{
    public $data_filtrada = [
        'ficha' => null,
        'cedula' => null,
        'nombre' => null,
        'gerencia' => null,
        'cargo' => null,
        'unidad' => null
    ];

    public $ficha_seleccionada = null;

    #[On('busqueda-filtrada')]
    public function obtenerDataFiltrada($filtros)
    {
        $this->data_filtrada = $filtros;
        $this->reset('ficha_seleccionada');
    }

    #[Computed]
    public function empleados()
    {
        return $this->filtrar(RrhhPersonal::query())
                    ->orderBy('nombre_empleado', 'asc')
                    ->limit(50)
                    ->get();
    }

    #[Computed]
    public function empleado_seleccionado()
    {
        if (!$this->ficha_seleccionada) {
            return null;
        }

        return RrhhPersonal::find($this->ficha_seleccionada);
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