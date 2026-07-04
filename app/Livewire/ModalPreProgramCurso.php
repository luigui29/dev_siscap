<?php

namespace App\Livewire;

use App\Models\Actividad;
use App\Models\Area;
use App\Models\Facilitador;
use App\Models\Programacion;
use App\Models\Subactividad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalPreProgramCurso extends Component
{
    /* PROPIEDADES */
    public $programacion_id = null;

    public $area_seleccionada;

    public $actividad_seleccionada;

    public $subactividad_seleccionada;

    public $facilitador_seleccionado;

    public $institucion;

    public $fecha;

    public $lugar;

    public $desde;

    public $hasta;

    public $duracion;

    public $extra = false;

    /* EVENTOS */
    // Se abre el modal y se cargan los datos desde la vista materializada
    #[On('abrir-modal-pre-program-curso')]
    public function abrir($id = null)
    {
        $this->limpiar();

        if ($id) {
            $registro = DB::table('mvw_pre_programaciones')
                ->where('programacion_id', $id)
                ->first();

            if ($registro) {
                $this->programacion_id = $registro->programacion_id;

                // Buscar IDs de los registros relacionados por nombre (no se consulta tbl_programaciones)
                $area = Area::where('nombre', $registro->nombre_area)->first();
                if ($area) {
                    $this->area_seleccionada = $area->id;

                    $actividad = Actividad::where('nombre', $registro->nombre_actividad)
                        ->where('area_id', $area->id)
                        ->first();
                    if ($actividad) {
                        $this->actividad_seleccionada = $actividad->id;

                        $subactividad = Subactividad::where('nombre', $registro->nombre_subactividad)
                            ->where('actividad_id', $actividad->id)
                            ->first();
                        if ($subactividad) {
                            $this->subactividad_seleccionada = $subactividad->id;
                        }
                    }
                }

                $facilitador = Facilitador::where('nombre', $registro->nombre_facilitador)->first();
                if ($facilitador) {
                    $this->facilitador_seleccionado = $facilitador->id;
                }

                $this->institucion = $registro->institucion;
                $this->fecha = Carbon::parse($registro->fecha)->format('Y-m-d');
                $this->lugar = $registro->lugar;
                $this->desde = substr($registro->desde, 0, 5);
                $this->hasta = substr($registro->hasta, 0, 5);
                $this->duracion = $registro->duracion;
            }
        }

        $this->dispatch('listo-modal-pre-program-curso');
    }

    /* PROPIEDADES COMPUTADAS */
    // Todas las áreas de capacitación ordenadas alfabéticamente
    #[Computed]
    public function areas()
    {
        return Area::orderBy('nombre', 'asc')->get();
    }

    // Actividades filtradas por el área seleccionada
    #[Computed]
    public function actividades()
    {
        if (! $this->area_seleccionada) {
            return collect();
        }

        return Actividad::where('area_id', $this->area_seleccionada)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    // Sub-actividades filtradas por la actividad seleccionada
    #[Computed]
    public function subactividades()
    {
        if (! $this->actividad_seleccionada) {
            return collect();
        }

        return Subactividad::where('actividad_id', $this->actividad_seleccionada)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    // Todos los facilitadores ordenados alfabéticamente
    #[Computed]
    public function facilitadores()
    {
        return Facilitador::orderBy('nombre', 'asc')->get();
    }

    /* Reglas y mensajes de validación */
    public function rules()
    {
        return [
            'actividad_seleccionada' => 'required|integer|exists:tbl_actividades,id',
            'subactividad_seleccionada' => 'nullable|integer|exists:tbl_subactividades,id',
            'facilitador_seleccionado' => 'required|integer|exists:tbl_facilitadores,id',
            'institucion' => ['nullable', 'max:255'],
            'fecha' => 'required|date',
            'lugar' => ['required', 'max:255'],
            'desde' => 'required|date_format:H:i',
            'hasta' => ['required', 'date_format:H:i', 'after:desde'],
            'duracion' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'El campo es obligatorio.',
            '*.integer' => 'El campo debe ser un número entero.',
            '*.exists' => 'El registro seleccionado no existe.',
            '*.max' => 'El campo es demasiado largo.',
            'hasta.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
            'duracion.min' => 'La duración debe ser mayor o igual a 0.',
        ];
    }

    public function updated($property)
    {
        // Al cambiar el área, reiniciar actividad y sub-actividad
        if ($property === 'area_seleccionada') {
            $this->reset(['actividad_seleccionada', 'subactividad_seleccionada']);
        }

        // Al cambiar la actividad, reiniciar sub-actividad
        if ($property === 'actividad_seleccionada') {
            $this->reset('subactividad_seleccionada');
        }
    }

    // Se guarda directamente en tbl_programaciones a través del modelo
    public function guardar()
    {
        $this->validate();

        Programacion::updateOrCreate(
            ['id' => $this->programacion_id],
            [
                'actividad_id' => $this->actividad_seleccionada,
                'subactividad_id' => $this->subactividad_seleccionada,
                'facilitador_id' => $this->facilitador_seleccionado,
            'institucion' => $this->institucion,
            'fecha' => $this->fecha,
            'lugar' => $this->lugar,
            'desde' => $this->desde,
            'hasta' => $this->hasta,
            'duracion' => $this->duracion,
            'extra' => $this->extra,
            ]
        );

        $this->dispatch('pre-program-actualizada');
        $this->dispatch('cerrar-modal-pre-program-curso');
    }

    // Se elimina directamente en tbl_programaciones a través del modelo
    public function eliminar()
    {
        Programacion::findOrFail($this->programacion_id)->delete();
        $this->limpiar();
        $this->dispatch('pre-program-actualizada');
        $this->dispatch('cerrar-modal-pre-program-curso');
    }

    public function limpiar()
    {
        $this->reset([
            'programacion_id', 'area_seleccionada', 'actividad_seleccionada',
            'subactividad_seleccionada', 'facilitador_seleccionado',
            'institucion', 'fecha', 'lugar',
            'desde', 'hasta', 'duracion', 'extra',
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('modals.modal-program-pre-curso');
    }
}
