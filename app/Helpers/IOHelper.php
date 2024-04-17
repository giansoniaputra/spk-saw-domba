<?php

use App\Models\Alternatif;
use App\Models\Perhitungan;
use Illuminate\Support\Facades\DB;

function getKelas()
{
    $alternatifs = DB::table('alternatifs')
        ->select('alternatifs.kelas as kelas')
        ->distinct()
        ->get();
    $perhitungan = Perhitungan::all();
    if (count($perhitungan) < 1) {
        $element = '<a class="collapse-item" href="/saw">Tambah Perhitungan</a>';
        return $element;
    } else {
        $element = '';
        foreach ($alternatifs as $alternatif) {
            $element .= '<a class="collapse-item" href="/saw/' . $alternatif->kelas . '">Perhitungan Kelas ' . $alternatif->kelas . '</a>';
            $element .= '<a class="collapse-item" href="/saw/favorit?kelas=' . $alternatif->kelas . '">Perhitungan Kelas Favorit ' . $alternatif->kelas . '</a>';
        }
        return $element;
    }
}
