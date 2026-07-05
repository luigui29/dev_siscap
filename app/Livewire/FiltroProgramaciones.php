<?php

namespace App\Livewire;

use App\Models\Actividad;
use App\Models\Area;
use App\Models\Facilitador;
use App\Models\Subactividad;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FiltroProgramaciones extends Component
{
    /* PROPIEDADES */
    public $area_seleccionada;
    public $actividad_seleccionada;
    public $subactividad_seleccionada;
    public $facilitador_seleccionado;

    public $filtro_actividad;
    public $filtro_subactividad;
    public $filtro_facilitador;
    public $filtro_institucion;
    public $filtro_lugar;
    public $filtro_fecha_desde;
    public $filtro_fecha_hasta;
    public $filtro_tiempo_desde;
    public $filtro_tiempo_hasta;
    public $filtro_duracion_desde;
    public $filtro_duracion_hasta;

    /* Reglas y mensajes de validación */
    public function rules()
    {
        return [
            'area_seleccionada' => 'nullable|integer',
            'actividad_seleccionada' => 'nullable|integer',
            'subactividad_seleccionada' => 'nullable|integer',
            'facilitador_seleccionado' => 'nullable|integer',
            'area_seleccionada' => 'nullable|integer',
            'filtro_actividad' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_subactividad' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_facilitador' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_institucion' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_lugar' => ['nullable', 'regex:/^[\pL\s]+$/u', 'max:255'],
            'filtro_fecha_desde' => 'nullable|date',
            'filtro_fecha_hasta' => ['nullable', 'date', 'after_or_equal:filtro_fecha_desde'],
            'filtro_tiempo_desde' => 'nullable|date_format:H:i',
            'filtro_tiempo_hasta' => ['nullable', 'date_format:H:i', 'after:filtro_tiempo_desde'],
            'filtro_duracion_desde' => ['nullable', 'integer', 'min:0'],
            'filtro_duracion_hasta' => ['nullable', 'integer', 'gte:filtro_duracion_desde'],
        ];
    }

    public function messages()
    {
        return [
            '*.regex' => 'Solo se permiten letras y espacios.',
            '*.max' => 'El campo es demasiado largo',
            'filtro_fecha_hasta.after_or_equal' => 'El campo debe ser posterior o igual a la fecha anteriormente ingresada',
            'filtro_tiempo_hasta.after' => 'El campo debe ser posterior a la hora anteriormente ingresada',
            'filtro_duracion_desde' => 'El campo debe ser mayor o igual a 0',
            'filtro_duracion_hasta.gte' => 'El campo debe ser mayor o igual a la duracion anteriormente ingresada',
        ];
    }

    /* PROPIEDADES COMPUTADAS */
    // Todas las áreas de capacitación ordenadas alfabéticamente
    #[Computed]
    public function areas()
    {
        return Area::orderBy('nombre', 'asc')->get();
    }

    // Actividades filtradas por el área seleccionada y si se escribe en el campo de búsqueda
    #[Computed]
    public function actividades()
    {
        if (!$this->area_seleccionada) {
            return collect();
        }

        $query = Actividad::where('area_id', $this->area_seleccionada);

        if (!empty($this->filtro_actividad)) {
            $query->where('nombre', 'ilike', '%'.$this->filtro_actividad.'%');
        }

        return $query->orderBy('nombre', 'asc')->get();
    }

    // Sub-actividades filtradas por la actividad seleccionada
    #[Computed]
    public function subactividades()
    {
        if (!$this->actividad_seleccionada) {
            return collect();
        }

        $query = Subactividad::where('actividad_id', $this->actividad_seleccionada);

        if(!empty($this->filtro_subactividad)) {
            $query->where('nombre', 'ilike', '%'.$this->filtro_subactividad.'%');
        }

        return $query->orderBy('nombre', 'asc')->get();
    }

    // Todos los facilitadores ordenados alfabéticamente
    #[Computed]
    public function facilitadores()
    {
        $query = Facilitador::orderBy('nombre', 'asc');

        if(!empty($this->filtro_facilitador)){
            $query->where('nombre', 'ilike', '%'.$this->filtro_facilitador.'%');
        }

        return $query->get();
    }

    public function updated($property)
    {
        $this->validateOnly($property);

        // Al cambiar el área, reiniciar la actividad y sub-actividad seleccionadas
        if ($property === 'area_seleccionada') {
            $this->reset(['actividad_seleccionada', 'subactividad_seleccionada', 'filtro_actividad', 'filtro_subactividad']);
            unset($this->actividades);
        }

        // Al cambiar la actividad seleccionada, reiniciar la subactividad seleccionada previamente
        if ($property === 'actividad_seleccionada') {
            $this->reset(['subactividad_seleccionada', 'filtro_subactividad']);
            unset($this->actividades);
        }

        $this->emitirFiltros();
    }

    private function emitirFiltros()
    {
        // Resolver el nombre del área a partir del ID seleccionado
        $nombre_area = $this->area_seleccionada
            ? Area::where('id', $this->area_seleccionada)->value('nombre')
            : null;

        // Resolver el nombre de la actividad a partir del ID seleccionado
        $nombre_actividad = $this->actividad_seleccionada
            ? Actividad::where('id', $this->actividad_seleccionada)->value('nombre')
            : $this->filtro_actividad;

        // Resolver el nombre de la subactividad a partir del ID seleccionado
        $nombre_subactividad = $this->subactividad_seleccionada
            ? Subactividad::where('id', $this->subactividad_seleccionada)->value('nombre')
            : $this->filtro_subactividad;

        // Resolver el nombre del facilitador a partir del ID seleccionado
        $nombre_facilitador = $this->facilitador_seleccionado
            ? Facilitador::where('id', $this->facilitador_seleccionado)->value('nombre')
            : $this->filtro_facilitador;

        $this->dispatch('busqueda-filtrada-program', filtros: [
            'area' => $nombre_area,
            'actividad' => $nombre_actividad,
            'subactividad' => $nombre_subactividad,
            'facilitador' => $nombre_facilitador,
            'institucion' => $this->filtro_institucion,
            'lugar' => $this->filtro_lugar,
            'fecha_desde' => $this->filtro_fecha_desde,
            'fecha_hasta' => $this->filtro_fecha_hasta,
            'tiempo_desde' => $this->filtro_tiempo_desde,
            'tiempo_hasta' => $this->filtro_tiempo_hasta,
            'filtro_duracion_desde' => $this->filtro_duracion_desde,
            'filtro_duracion_hasta' => $this->filtro_duracion_hasta,
        ]);
    }

    public function limpiar()
    {
        $this->reset([
            'area_seleccionada', 'actividad_seleccionada', 'subactividad_seleccionada', 'facilitador_seleccionado',
            'filtro_actividad', 'filtro_subactividad', 'filtro_facilitador', 'filtro_institucion', 'filtro_lugar',
            'filtro_fecha_desde', 'filtro_fecha_hasta', 'filtro_tiempo_desde', 'filtro_tiempo_hasta', 'filtro_duracion_desde', 'filtro_duracion_hasta',
        ]);

        $this->emitirFiltros();
    }

    public function render()
    {
        return view('livewire.filtro-programaciones');
    }
}
