<?php

use App\Models\Alternatif;
use Illuminate\Support\Facades\DB;

function getKelas()
{
    $alternatifs = DB::table('alternatifs')
        ->select('alternatifs.kelas as kelas')
        ->distinct()
        ->get();
    $element = '';
    foreach ($alternatifs as $alternatif) {
        $element .= '<a class="collapse-item" href="/saw/' . $alternatif->kelas . '">Perhitungan Kelas ' . $alternatif->kelas . '</a>';
    }
    return $element;
}
