<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class FiltroEmpleados extends Component
{   
    public $filtro_ficha;
    public $filtro_cedula;
    public $filtro_nombre;
    public $filtro_gerencia;
    public $filtro_cargo;
    public $filtro_unidad;

    /* Reglas y mensaajes de validación */
    public function rules()
    {
        return [
            'filtro_ficha'    => 'nullable|integer',
            'filtro_cedula'   => 'nullable|integer',
            'filtro_nombre'   => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_gerencia' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_cargo'    => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_unidad'   => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            '*.integer' => 'El campo debe ser un número entero.',
            '*.regex'   => 'Solo se permiten letras y espacios.',
            '*.max'     => 'El campo es demasiado largo.',
        ];
    }

    public function updated($property)
    {
        $this->validateOnly($property);
        $this->emitirFiltros();
    }

    private function emitirFiltros()
    {
        $this->dispatch('busqueda-filtrada', filtros: [
            'ficha' => $this->filtro_ficha,
            'cedula' => $this->filtro_cedula,
            'nombre' => $this->filtro_nombre,
            'gerencia' => $this->filtro_gerencia,
            'cargo' => $this->filtro_cargo,
            'unidad' => $this->filtro_unidad
        ]);
    }

    public function limpiar()
    {
        $this->reset(['filtro_ficha', 'filtro_cedula', 'filtro_nombre', 'filtro_gerencia', 'filtro_cargo', 'filtro_unidad']);
        $this->emitirFiltros();
    }

    public function render()
    {
        return view('livewire.filtro-empleados');
    }
}
