<?php

return [
    /* Días feriados fijos 
     *  Agregar aquí todos los necesarios
     */
    'fijos' => [
        '01-01', // Año nuevo
        '05-01', // Día del trabajador
        '07-05', // Independencia de Venezuela
        '12-24', // Nochebuena
        '12-25', // Navidad
        '12-31', // Fin de año

    ],

    /* Días feriados móviles 
     *  Para aquellos dependiendo según el año
     *  Ejemplo: Semana Santa
     */

    'moviles' => [
        '2026' => [
            '03-30',
            '03-31',
            '04-01',
            '04-02',
            '04-03'
        ],
    ]
];
