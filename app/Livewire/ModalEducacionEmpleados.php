<?php

use App\Models\NivelEducativo;
use App\Models\RrhhPersonal;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalEducacionEmpleados extends Component
{
    /* PROPIEDADES */
    public $educacion_id = null;

    public $ficha = null;

    // Formulario en modal
    public $nivel_educativo;

    public $titulo;

    public $especialidad;

    public $instituto;

    public $graduado = false;

    public $fecha_culminado;

    public $ultimo_nivel = false;

    /* EVENTOS */
    // Se abre el modal y se cargan los datos para editar o agregar
    #[On('abrir-modal-educacion')]
    public function abrir($ficha = null, $id = null)
    {
        $this->limpiar();

        if ($id) {
            $registro = NivelEducativo::findOrFail($id);
            $this->ficha = $registro->ficha_empleado;
            $this->educacion_id = $registro->id;
            $this->nivel_educativo = $registro->nivel_educativo;
            $this->titulo = $registro->titulo;
            $this->especialidad = $registro->especialidad;
            $this->instituto = $registro->instituto;
            $this->graduado = $registro->graduado;
            $this->fecha_culminado = $registro->fecha_culminado;
            $this->ultimo_nivel = $registro->ultimo_nivel;
        } else {
            $this->ficha = $ficha;
        }

        $this->dispatch('listo-modal-educacion');
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
            'nivel_educativo' => ['required', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'titulo' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'especialidad' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'instituto' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'fecha_culminado' => ['nullable', 'integer', 'digits:4'],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'El campo es obligatorio.',
            '*.integer' => 'El campo debe ser un número entero.',
            '*.regex' => 'Solo se permiten letras y espacios.',
            '*.max' => 'El campo es demasiado largo.',
            'fecha_culminado.digits' => 'El año debe ser de 4 dígitos.',
        ];
    }

    public function guardar()
    {
        $this->validate();

        NivelEducativo::updateOrCreate(
            ['id' => $this->educacion_id],
            [
                'ficha_empleado' => $this->ficha,
                'nivel_educativo' => $this->nivel_educativo,
                'titulo' => $this->titulo,
                'especialidad' => $this->especialidad,
                'instituto' => $this->instituto,
                'graduado' => $this->graduado,
                'fecha_culminado' => $this->fecha_culminado,
                'ultimo_nivel' => $this->ultimo_nivel,
            ]
        );

        $this->dispatch('educacion-actualizada');
        $this->dispatch('cerrar-modal-educacion');
    }

    public function eliminar()
    {
        NivelEducativo::findOrFail($this->educacion_id)->delete();
        $this->limpiar();
        $this->dispatch('educacion-actualizada');
        $this->dispatch('cerrar-modal-educacion');
    }

    public function limpiar()
    {
        $this->reset(['educacion_id', 'ficha', 'nivel_educativo', 'titulo', 'especialidad', 'instituto', 'graduado', 'fecha_culminado', 'ultimo_nivel']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('modals.modal-perfil-individual-educacion');
    }
}
