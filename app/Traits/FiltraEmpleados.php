<?php

namespace App\Traits;

trait FiltraEmpleados
{
    public $filtro_ficha = '';
    public $filtro_cedula = '';
    public $filtro_nombre = '';
    public $filtro_gerencia = '';
    public $filtro_cargo = '';
    public $filtro_unidad = '';

    /**
     * Aplica los filtros de empleados al query proporcionado.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function aplicarFiltrosEmpleados($query)
    {
        if (!empty($this->filtro_ficha)) {
            $query->where('ficha', 'like', '%' . $this->filtro_ficha . '%');
        }

        if (!empty($this->filtro_cedula)) {
            // Asumiendo que la columna se llama cedula en tbl_rrhh_personal
            $query->where('cedula', 'like', '%' . $this->filtro_cedula . '%');
        }

        if (!empty($this->filtro_nombre)) {
            $query->where('nombre_empleado', 'ilike', '%' . $this->filtro_nombre . '%');
        }

        if (!empty($this->filtro_gerencia)) {
            $query->where('texto_gerencia', 'ilike', '%' . $this->filtro_gerencia . '%');
        }

        if (!empty($this->filtro_cargo)) {
            $query->where('texto_cargo', 'ilike', '%' . $this->filtro_cargo . '%');
        }

        if (!empty($this->filtro_unidad)) {
            $query->where('texto_unidad', 'ilike', '%' . $this->filtro_unidad . '%');
        }

        return $query;
    }

    /**
     * Limpia los valores de los filtros.
     */
    public function limpiarFiltrosEmpleados()
    {
        $this->filtro_ficha = '';
        $this->filtro_cedula = '';
        $this->filtro_nombre = '';
        $this->filtro_gerencia = '';
        $this->filtro_cargo = '';
        $this->filtro_unidad = '';
    }
}
