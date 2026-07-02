<?php

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\ExperienciaLaboral;
use App\Models\RrhhPersonal;

class ExperienciaEmpleados extends Component
{
    /* PROPIEDADES */
    public $experiencia_id = null;
    public $ficha = null;    

    // Formulario en modal
    public $cargo_desempenado;
    public $empresa;
    public $desde;
    public $hasta;
    public $observacion;

    /* EVENTOS */
    // Se abre el modal y se cargan los datos para editar o agregar
    #[On('abrir-modal-experiencia')]
    public function abrir($ficha = null, $id = null)
    {
        $this->limpiar();

        if($id) {
            $registro = ExperienciaLaboral::findOrFail($id);
            $this->ficha = $registro->ficha_empleado;
            $this->experiencia_id = $registro->id;
            $this->cargo_desempenado = $registro->cargo_desempeñado;
            $this->empresa = $registro->empresa;
            $this->desde = $registro->desde;
            $this->hasta = $registro->hasta;
            $this->observacion = $registro->observacion;
        } else {
            $this->ficha = $ficha;
        }

        $this->dispatch('listo-modal-experiencia');
    }

    /* PROPIEDADES COMPUTADAS */
    #[Computed]
    public function nombre_empleado()
    {
        return RrhhPersonal::find($this->ficha)?->nombre_empleado ?? null;
    }

    /* Reglas y mensajes de validación */
    public function rules()
    {
        return [
            'cargo_desempenado' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'empresa' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'desde' => ['required', 'date'],
            'hasta' => ['nullable', 'date', 'after:desde'],
            'observacion' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'El campo es obligatorio.',
            '*.max' => 'El campo es demasiado largo.',
            '*.regex'   => 'Solo se permiten letras y espacios.',
            'hasta.after' => 'La fecha de finalización debe ser posterior a la fecha de inicio.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        ExperienciaLaboral::updateOrCreate(
            ['id' => $this->experiencia_id],
            [
                'ficha_empleado' => $this->ficha,
                'cargo_desempeñado' => $this->cargo_desempenado,
                'empresa' => $this->empresa,
                'desde' => $this->desde,
                'hasta' => $this->hasta,
                'observacion' => $this->observacion
            ]
        );

        $this->dispatch('experiencia-actualizada');
        $this->dispatch('cerrar-modal-experiencia');
    }

    public function eliminar()
    {
        ExperienciaLaboral::findOrFail($this->experiencia_id)->delete();
        $this->limpiar();
        $this->dispatch('experiencia-actualizada');
        $this->dispatch('cerrar-modal-experiencia');
    }

    public function limpiar()
    {
        $this->reset(['experiencia_id', 'ficha', 'cargo_desempenado', 'empresa', 'desde', 'hasta', 'observacion']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('modals.modal-perfil-individual-experiencia');
    }
};