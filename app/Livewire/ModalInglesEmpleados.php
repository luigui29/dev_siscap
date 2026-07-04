<?php

use App\Models\NivelIngles;
use App\Models\RrhhPersonal;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalInglesEmpleados extends Component
{
    /* PROPIEDADES */
    public $ingles_id = null;

    public $ficha = null;

    // Formulario en modal
    public $i1;

    public $i2;

    public $bb;

    public $ba;

    public $ib;

    public $ia;

    public $ab;

    public $aa;

    protected $niveles = ['i1', 'i2', 'bb', 'ba', 'ib', 'ia', 'ab', 'aa'];

    /* EVENTOS */
    // Se abre el modal y se cargan los datos para editar o agregar
    #[On('abrir-modal-ingles')]
    public function abrir($ficha)
    {
        $this->limpiar();

        $registro = NivelIngles::where('ficha_empleado', $ficha)->first();

        $this->ficha = $ficha;

        if ($registro) {
            $this->ingles_id = $registro->id;
            $this->i1 = $registro->i1;
            $this->i2 = $registro->i2;
            $this->bb = $registro->bb;
            $this->ba = $registro->ba;
            $this->ib = $registro->ib;
            $this->ia = $registro->ia;
            $this->ab = $registro->ab;
            $this->aa = $registro->aa;
        }

        $this->dispatch('listo-modal-ingles');
    }

    /* PROPIEDADES COMPUTADAS */
    #[Computed]
    public function nombre_empleado()
    {
        return RrhhPersonal::find($this->ficha)?->nombre_empleado ?? null;
    }

    // Revisa por si hay mas de un nivel de ingles seleccionado
    public function updated($propertyName)
    {
        if (in_array($propertyName, $this->niveles)) {

            $valores = [];
            foreach ($this->niveles as $nivel) {
                $valores[$nivel] = $this->$nivel;
            }

            $activos = array_filter($valores); // Devuelve solo los niveles que están activos (true)

            if (count($activos) > 1) {
                $this->$propertyName = false;
                $this->addError('nivel_ingles_unico', 'Solo se puede seleccionar un nivel de inglés a la vez.');

                return;
            }

            $this->resetValidation('nivel_ingles_unico');
            $this->guardar();
        }
    }

    public function guardar()
    {
        NivelIngles::updateOrCreate(
            ['id' => $this->ingles_id],
            [
                'ficha_empleado' => $this->ficha,
                'i1' => $this->i1 ?? false,
                'i2' => $this->i2 ?? false,
                'bb' => $this->bb ?? false,
                'ba' => $this->ba ?? false,
                'ib' => $this->ib ?? false,
                'ia' => $this->ia ?? false,
                'ab' => $this->ab ?? false,
                'aa' => $this->aa ?? false,
            ]
        );

        $this->dispatch('ingles-actualizado');
    }

    public function limpiar()
    {
        $this->reset(['ingles_id', 'ficha', 'i1', 'i2', 'bb', 'ba', 'ib', 'ia', 'ab', 'aa']);
    }

    public function render()
    {
        return view('modals.modal-perfil-individual-ingles');
    }
}
