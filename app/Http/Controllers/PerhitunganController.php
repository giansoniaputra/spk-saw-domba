<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Alternatif;
use App\Models\Perhitungan;
use App\Models\SubKriteria;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerhitunganController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Perhitungan Moora',
            'perhitungan' => DB::table('perhitungans as a')
                ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                ->select('a.*', 'b.alternatif', 'b.keterangan')
                ->orderBy('b.alternatif', 'asc'),
            'kriterias' => Kriteria::orderBy('kode', 'asc')->get(),
            'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->get(),
            'sum_kriteria' => Kriteria::count('id'),
        ];
        return view('moora.index', $data);
    }

    public function index_saw(Request $request, $kelas)
    {
        if ($kelas == 'favorit') {
            $data = [
                'title' => "Perhitungan Kelas $kelas",
                'perhitungan' => DB::table('perhitungans as a')
                    ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                    ->select('a.*', 'b.alternatif', 'b.keterangan')
                    ->where('b.kelas', $request->kelas)
                    ->where('a.is_favorit', 1)
                    ->orderBy('b.alternatif', 'asc'),
                'kriterias' => Kriteria::orderBy('kode', 'asc')->where('is_favorit', 1)->get(),
                'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->where('kelas', $request->kelas)->get(),
                'sum_kriteria' => Kriteria::where('is_favorit', 1)->count('id'),
                'kelas' => $kelas,
            ];
        } else {
            $data = [
                'title' => "Perhitungan Kelas $kelas",
                'perhitungan' => DB::table('perhitungans as a')
                    ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                    ->select('a.*', 'b.alternatif', 'b.keterangan')
                    ->where('b.kelas', $kelas)
                    ->where('a.is_favorit', 0)
                    ->orderBy('b.alternatif', 'asc'),
                'kriterias' => Kriteria::orderBy('kode', 'asc')->get(),
                'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->where('kelas', $kelas)->get(),
                'sum_kriteria' => Kriteria::count('id'),
                'kelas' => $kelas,
            ];
        }
        return view('saw.index', $data);
    }
    public function index_waspas()
    {
        $data = [
            'title' => 'Perhitungan WASPAS',
            'perhitungan' => DB::table('perhitungans as a')
                ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                ->select('a.*', 'b.alternatif', 'b.keterangan')
                ->orderBy('b.alternatif', 'asc'),
            'kriterias' => Kriteria::orderBy('kode', 'asc')->get(),
            'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->get(),
            'sum_kriteria' => Kriteria::count('id'),
        ];
        return view('waspas.index', $data);
    }

    public function create(Request $request)
    {
        $cek = Perhitungan::first();
        if (!$cek) {
            $kriterias = Kriteria::orderBy('kode', 'asc')->get();
            $alternatifs = Alternatif::orderBy('alternatif', 'asc')->get();
            foreach ($alternatifs as $alternatif) {
                foreach ($kriterias as $kriteria) {
                    $data = [
                        'uuid' => Str::orderedUuid(),
                        'alternatif_uuid' => $alternatif->uuid,
                        'kriteria_uuid' => $kriteria->uuid,
                        'bobot' => 0,
                        'is_favorit' => 0
                    ];
                    if ($kriteria->is_favorit == 1) {
                        $data2 = [
                            'uuid' => Str::orderedUuid(),
                            'alternatif_uuid' => $alternatif->uuid,
                            'kriteria_uuid' => $kriteria->uuid,
                            'bobot' => 0,
                            'is_favorit' => 1
                        ];
                        Perhitungan::create($data2);
                    }
                    Perhitungan::create($data);
                }
            }
            if ($request->kelas) {
                return response()->json(['success' => 'Perhitungan Baru Berhasil Ditambahkan! Silahkan Masukan Nilainya']);
            } else {
                return redirect('/');
            }
        } else {
            $kriterias = Kriteria::orderBy('kode', 'asc')->get();
            $alternatifs = Alternatif::orderBy('alternatif', 'asc')->where('kelas', $request->kelas)->get();
            foreach ($alternatifs as $alternatif) {
                $query = Perhitungan::where('alternatif_uuid', $alternatif->uuid)->first();
                if (!$query) {
                    foreach ($kriterias as $kriteria) {
                        $data = [
                            'uuid' => Str::orderedUuid(),
                            'alternatif_uuid' => $alternatif->uuid,
                            'kriteria_uuid' => $kriteria->uuid,
                            'bobot' => 0
                        ];
                        Perhitungan::create($data);
                    }
                }
            }
            foreach ($kriterias as $kriteria) {
                $query = Perhitungan::where('kriteria_uuid', $kriteria->uuid)->first();
                if (!$query) {
                    foreach ($alternatifs as $alternatif) {
                        $data = [
                            'uuid' => Str::orderedUuid(),
                            'alternatif_uuid' => $alternatif->uuid,
                            'kriteria_uuid' => $kriteria->uuid,
                            'bobot' => 0
                        ];
                        Perhitungan::create($data);
                    }
                }
            }
            if ($request->kelas) {
                return response()->json(['success' => 'Perhitungan Baru Berhasil Ditambahkan! Silahkan Masukan Nilainya']);
            } else {
                return redirect('/');
            }
        }
    }

    public function update(Perhitungan $perhitungan, Request $request)
    {
        Perhitungan::where('uuid', $perhitungan->uuid)->update(['bobot' => $request->bobot]);
        return response()->json(['success' => $request->bobot]);
    }

    public function normalisasi(Request $request, $kelas)
    {
        //Inisialisasi Normalisasi
        if ($kelas == 'favorit') {
            $data = [
                'title' => 'Normalisasi',
                'perhitungan' => DB::table('perhitungans as a')
                    ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                    ->select('a.*', 'b.alternatif', 'b.keterangan')
                    ->where('a.is_favorit', 1)
                    ->orderBy('b.alternatif', 'asc'),
                'kriterias' => Kriteria::orderBy('kode', 'asc')->where('is_favorit', 1)->get(),
                'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->where('kelas', $request->kelas)->get(),
                'sum_kriteria' => Kriteria::count('id'),
            ];
        } else {
            $data = [
                'title' => 'Normalisasi',
                'perhitungan' => DB::table('perhitungans as a')
                    ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                    ->where('a.is_favorit', 0)
                    ->select('a.*', 'b.alternatif', 'b.keterangan')
                    ->orderBy('b.alternatif', 'asc'),
                'kriterias' => Kriteria::orderBy('kode', 'asc')->get(),
                'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->where('kelas', $kelas)->get(),
                'sum_kriteria' => Kriteria::count('id'),
            ];
        }
        $elements = '';
        $array_bobot = [];
        foreach ($data['alternatifs'] as $alternatif) {
            $elements .= "<tr><td>A$alternatif->alternatif</td>
            <td>$alternatif->keterangan</td>";
            foreach ($data['kriterias'] as $kriteria) {
                if ($kelas == 'favorit') {
                    $bobots = DB::table('perhitungans')
                        ->where('kriteria_uuid', $kriteria->uuid)
                        ->where('alternatif_uuid', $alternatif->uuid)
                        ->where('is_favorit', 1)
                        ->get();
                } else {
                    $bobots = DB::table('perhitungans')
                        ->where('kriteria_uuid', $kriteria->uuid)
                        ->where('alternatif_uuid', $alternatif->uuid)
                        ->where('is_favorit', 0)
                        ->get();
                }
                if ($kriteria->atribut == "BENEFIT") {
                    $sum_kriteria = DB::table('perhitungans')
                        ->where('kriteria_uuid', $kriteria->uuid)
                        ->max('bobot');
                    foreach ($bobots as $bobot) {
                        // $max = SubKriteria::where('kriteria_uuid', $kriteria->uuid)->orderBy('bobot', 'desc')->first();
                        // $bobot_kriteria = round($bobot->bobot / $max->bobot, 3);
                        $bobot_kriteria = round($bobot->bobot / $sum_kriteria, 3);
                        $elements .= "<td class=\"text-center\" id=\"nilai-bobot\">
                        <p class=\"p-bobot\">" . $bobot_kriteria . "</p>
                        <form action=\"javascript:;\" id=\"form-update-bobot\">
                        <input type=\"number\" class=\"d-none input-bobot\" data-uuid=" . $bobot_kriteria . " value=\"" . $bobot_kriteria . "\" style=\"width:6vh\">
                        </form>
                        </td>";
                        $array_bobot[] = $bobot_kriteria;
                    }
                } else {
                    foreach ($bobots as $bobot) {
                        $sum_kriteria = DB::table('perhitungans')
                            ->where('kriteria_uuid', $kriteria->uuid)
                            ->min('bobot');
                        $bobot_kriteria = round($bobot->bobot / $sum_kriteria, 3);
                        $elements .= "<td class=\"text-center\" id=\"nilai-bobot\">
                        <p class=\"p-bobot\">" . $bobot_kriteria . "</p>
                        <form action=\"javascript:;\" id=\"form-update-bobot\">
                        <input type=\"number\" class=\"d-none input-bobot\" data-uuid=" . $bobot_kriteria . " value=\"" . $bobot_kriteria . "\" style=\"width:6vh\">
                        </form>
                        </td>";
                        $array_bobot[] = $bobot_kriteria;
                    }
                }
            }
            $elements .= "</tr>";
        }
        $data['elements'] = $elements;
        //MENGHITUNG RANKING-----------------------------------------------
        $bobot_kriteria = array_chunk($array_bobot, $data['sum_kriteria']);

        //Mengambil Bobot Kriteria
        $bobot = [];
        foreach ($data['kriterias'] as $kriteria) {
            $bobot[] = $kriteria->bobot;
        }
        //Meng kalikan bobot dengan normalisasi
        $hasil_kali = [];
        for ($i = 0; $i < count($bobot_kriteria); $i++) {
            for ($j = 0; $j < count($bobot); $j++) {
                $hasil_kali[] = floatval(number_format($bobot_kriteria[$i][$j] * $bobot[$j], 3));
            }
        }

        //hasil perkalian di pecah menjadi array muti dimensi
        $pecah_hasil = array_chunk($hasil_kali, $data['sum_kriteria']);

        // Perkalian Semua Array
        $ranking = [];
        for ($u = 0; $u < count($pecah_hasil); $u++) {
            $ranking[] = round(array_sum($pecah_hasil[$u]), 3);
        }

        //Merangking
        // if ($kelas == 'favorit') {
        // $nama = Alternatif::orderBy('alternatif', 'asc')->where('kelas', $kelas)->get();
        $nama = Alternatif::orderBy('alternatif', 'asc')->where('kelas', $kelas)->get();
        // }
        $rangking_assoc = [];
        foreach ($ranking as $index => $nilai) {
            $rangking_assoc[] = [$nama[$index]->keterangan, $nilai, $nama[$index]->alternatif];
        }

        $names = array_column($rangking_assoc, 0);
        $scores = array_column($rangking_assoc, 1);
        $alternatifss = array_column($rangking_assoc, 2);

        // Menggunakan array_multisort untuk mengurutkan scores secara menurun
        array_multisort($scores, SORT_DESC, $names, $alternatifss);

        // Menggabungkan kembali array setelah diurutkan
        $final_ranking = array_map(function ($name, $score, $alternatifss) {
            return [$name, $score, $alternatifss];
        }, $names, $scores, $alternatifss);

        $data['ranking'] = $final_ranking;

        return response()->json(['data' => $data]);
    }
    public function normalisasi_waspas()
    {
        //Inisialisasi Normalisasi
        $data = [
            'title' => 'Normalisasi',
            'perhitungan' => DB::table('perhitungans as a')
                ->join('alternatifs as b', 'a.alternatif_uuid', '=', 'b.uuid')
                ->select('a.*', 'b.alternatif', 'b.keterangan')
                ->orderBy('b.alternatif', 'asc'),
            'kriterias' => Kriteria::orderBy('kode', 'asc')->get(),
            'alternatifs' => Alternatif::orderBy('alternatif', 'asc')->get(),
            'sum_kriteria' => Kriteria::count('id'),
        ];
        $elements = '';
        $array_bobot = [];
        foreach ($data['alternatifs'] as $alternatif) {
            $elements .= "<tr><td>A$alternatif->alternatif</td>
            <td>$alternatif->keterangan</td>";
            foreach ($data['kriterias'] as $kriteria) {
                $bobots = DB::table('perhitungans')
                    ->where('kriteria_uuid', $kriteria->uuid)
                    ->where('alternatif_uuid', $alternatif->uuid)
                    ->get();
                foreach ($bobots as $bobot) {
                    if ($kriteria->atribut == 'BENEFIT') {
                        $max = SubKriteria::where('kriteria_uuid', $kriteria->uuid)->orderBy('bobot', 'desc')->first();
                        $bobot_kriteria = round($bobot->bobot / $max->bobot, 3);
                    } else {
                        $min = SubKriteria::where('kriteria_uuid', $kriteria->uuid)->orderBy('bobot', 'asc')->first();
                        $bobot_kriteria = round($min->bobot / $bobot->bobot, 3);
                    }
                    $elements .= "<td class=\"text-center\" id=\"nilai-bobot\">
                                        <p class=\"p-bobot\">" . $bobot_kriteria . "</p>
                                        <form action=\"javascript:;\" id=\"form-update-bobot\">
                                            <input type=\"number\" class=\"d-none input-bobot\" data-uuid=" . $bobot_kriteria . " value=\"" . $bobot_kriteria . "\" style=\"width:6vh\">
                                        </form>
                                    </td>";
                    $array_bobot[] = $bobot_kriteria;
                }
            }
            $elements .= "</tr>";
        }
        $data['elements'] = $elements;
        //MENGHITUNG RANKING-----------------------------------------------
        $bobot_kriteria = array_chunk($array_bobot, $data['sum_kriteria']);

        //Mengambil Bobot Kriteria
        $bobot = [];
        foreach ($data['kriterias'] as $kriteria) {
            $bobot[] = $kriteria->bobot / 100;
        }
        //Meng kalikan bobot dengan normalisasi
        $hasil_kali = [];
        $hasil_pangkat = [];
        for ($i = 0; $i < count($bobot_kriteria); $i++) {
            for ($j = 0; $j < count($bobot); $j++) {
                $hasil_kali[] = floatval(number_format($bobot_kriteria[$i][$j] * $bobot[$j], 3));
                $hasil_pangkat[] = floatval(number_format(pow($bobot_kriteria[$i][$j], $bobot[$j]), 3));
            }
        }




        //hasil perkalian di pecah menjadi array muti dimensi
        $pecah_kali = array_chunk($hasil_kali, $data['sum_kriteria']);
        $pecah_pangkat = array_chunk($hasil_pangkat, $data['sum_kriteria']);


        // Perkalian Semua Array
        $sigma1 = [];
        for ($u = 0; $u < count($pecah_kali); $u++) {
            $sigma1[] = round(0.5 * round(array_sum($pecah_kali[$u]), 3), 3);
        }
        $sigma2 = [];
        for ($u = 0; $u < count($pecah_pangkat); $u++) {
            $sigma2[] = round(0.5 * round(array_reduce($pecah_pangkat[$u], function ($carry, $item) {
                return $carry * $item;
            }, 1), 3), 3);
        }

        $ranking = array_map(function ($x, $y) {
            return round($x + $y, 3);
        }, $sigma1, $sigma2);


        //Merangking
        $nama = Alternatif::orderBy('alternatif', 'asc')->get();
        $rangking_assoc = [];
        foreach ($ranking as $index => $nilai) {
            $rangking_assoc[] = [$nama[$index]->keterangan, $nilai];
        }

        $names = array_column($rangking_assoc, 0);
        $scores = array_column($rangking_assoc, 1);

        // Menggunakan array_multisort untuk mengurutkan scores secara menurun
        array_multisort($scores, SORT_DESC, $names);

        // Menggabungkan kembali array setelah diurutkan
        $final_ranking = array_map(function ($name, $score) {
            return [$name, $score];
        }, $names, $scores);

        $data['ranking'] = $final_ranking;

        return response()->json(['data' => $data]);
    }
}
