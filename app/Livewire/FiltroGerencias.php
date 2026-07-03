<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class FiltroGerencias extends Component
{   
    public $filtro_gerencia;
    public $filtro_unidad;

    /* Reglas y mensaajes de validación */
    public function rules()
    {
        return [
            'filtro_gerencia' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_unidad'   => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
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
            'texto_gerencia' => $this->filtro_gerencia,
            'texto_unidad' => $this->filtro_unidad
        ]);
    }

    public function limpiar()
    {
        $this->reset(['filtro_gerencia', 'filtro_unidad']);
        $this->emitirFiltros();
    }

    public function render()
    {
        return view('livewire.filtro-gerencias');
    }
}
