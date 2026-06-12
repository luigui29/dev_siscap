<?php

namespace App\Livewire;

use App\Models\Programacion;
use App\Traits\GestionaFeriados;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Url;
use Livewire\Component;

class DashboardCalendario extends Component
{
    use GestionaFeriados;

    #[Url]
    public $year;

    #[Url]
    public $month;

    public function mount($year = null, $month = null)
    {
        $this->year = $year ?? now()->year;
        $this->month = $month ?? now()->month;
    }

    public function cambiarMes($delta)
    {
        $this->month += $delta;
        
        if ($this->month > 12) {
            $this->month = 1;
            $this->year++;
        } elseif ($this->month < 1) {
            $this->month = 12;
            $this->year--;
        }
        
        $this->validarLimites();
    }

    public function cambiarAnio($delta)
    {
        $this->year += $delta;
        $this->validarLimites();
    }

    protected function validarLimites()
    {
        if ($this->year < 2000) {
            $this->year = 2000;
        }
        if ($this->year > 2050) {
            $this->year = 2050;
        }
    }

    public function crearCalendarioMensual()
    {
        $date = Carbon::create($this->year, $this->month, 1);
        
        $start = $date->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $end = $date->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        
        $period = CarbonPeriod::create($start, $end);
        $days = [];
        
        foreach ($period as $day) {
            // Solo días laborales (lunes a viernes)
            if ($day->dayOfWeekIso >= 1 && $day->dayOfWeekIso <= 5) {
                $days[] = [
                    'date' => $day->copy(),
                    'is_current_month' => $day->month == $this->month,
                    'is_feriado' => $this->esFeriado($day),
                ];
            }
        }
        
        return [
            'nombre_mes' => ucfirst($date->locale(config('app.locale', 'es'))->translatedFormat('F')),
            'semanas' => array_chunk($days, 5)
        ];
    }

    protected function obtenerCursos()
    {
        $startOfYear = Carbon::create($this->year, 1, 1)->startOfDay();
        $endOfYear = Carbon::create($this->year, 12, 31)->endOfDay();
        
        $cursos = Programacion::whereBetween('fecha', [$startOfYear, $endOfYear])->get();
        
        $eventos_por_fecha = [];
        
        foreach ($cursos as $curso) {
            if ($curso->fecha) {
                $fecha_cadena = $curso->fecha->format('Y-m-d');
                $eventos_por_fecha[$fecha_cadena][] = $curso;
            }
        }
        
        return $eventos_por_fecha;
    }

    public function render()
    {
        $calendario = $this->crearCalendarioMensual();
        $eventos = $this->obtenerCursos();

        return view('livewire.dashboard-calendario', compact('calendario', 'eventos'));
    }
}
