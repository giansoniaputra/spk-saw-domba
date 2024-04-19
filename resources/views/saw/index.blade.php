@extends('layouts.main')
@section('container')
<style>
    .page-title {
        display: none;
    }

    #matrix-normalisasi {
        display: none;
    }

    /* Tambahkan gaya khusus untuk pencetakan jika diperlukan */
    @media print {
        body {
            padding: 40px;
        }

        /* Atur gaya untuk elemen-elemen yang ingin dicetak */
        .no-print {
            display: none;
            /* Sembunyikan elemen-elemen yang tidak ingin dicetak */
        }

        /* Tampilkan judul pada saat mencetak */
        .page-title {
            display: block;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            /* Atur jarak dari konten halaman */
        }

        #matrix-normalisasi {
            display: block;
        }
    }

</style>
<div class="row">
    <div class="col-sm-12">
        <h2 class="page-title">Laporan Hasil Perhitungan Kelas {{ $kelas }}</h2>
    </div>
</div>
<div class="row mb-2">
    <div class="col">
        <button type="button" class="btn btn-primary no-print" id="btn-add-perhitungan">Tambah Perhitungan SAW</button>
    </div>
</div>
<input type="hidden" id="kelas" value="{{ $kelas }}">
@if(isset($rKelas))
<input type="hidden" id="rKelas" value="{{ $rKelas }}">
@endif
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <table id="table-perhitungan" class="table table-bordered table-hover dtr-inline" style="overflow:scroll ">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">Alternatif</th>
                            <th class="text-center" rowspan="2">Keterangan</th>
                            <th class="text-center" colspan="{{ $sum_kriteria }}">Kriteria</th>
                        </tr>
                        <tr>
                            @foreach ($kriterias as $row)
                            <th class="tetx-center">{{ "C".$row->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @if($perhitungan->count('a.id') == 0)
                        <tr>
                            <td class="text-center" colspan="{{ 2 + $sum_kriteria }}">Belum Ada Perhitungan</td>
                        </tr>
                        @else
                        @foreach ($alternatifs as $alternatif)
                        <tr>
                            <td>A{{ $alternatif->alternatif }}</td>
                            <td>{{ $alternatif->keterangan }}</td>
                            @foreach($kriterias as $kriteria)
                            @php
                            if($kelas == 'favorit'){
                            $bobots = DB::table('perhitungans')
                            ->where('kriteria_uuid', $kriteria->uuid)
                            ->where('alternatif_uuid', $alternatif->uuid)
                            ->get();
                            } else {
                            $bobots = DB::table('perhitungans')
                            ->where('kriteria_uuid', $kriteria->uuid)
                            ->where('alternatif_uuid', $alternatif->uuid)
                            ->get();
                            }
                            @endphp
                            @foreach($bobots as $bobot)
                            <td class="text-center" id="nilai-bobot">
                                <p class="p-bobot">{{ $bobot->bobot }}</p>
                                <form action="javascript:;" id="form-update-bobot">
                                    <input type="number" class="d-none input-bobot" data-uuid={{ $bobot->uuid }} value="{{ $bobot->bobot }}" style="width:6vh">
                                </form>
                            </td>
                            @endforeach
                            @endforeach
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-center">Nilai Bobot(Wj)</th>
                            @foreach ($kriterias as $kriteria)
                            <th>{{ $kriteria->bobot }}</th>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer">
                @if($perhitungan->count('a.id') > 0)
                <button class="btn btn-primary float-right no-print" id="btn-normalisasi">Cari Keputusan</button>
                @endif
            </div>
        </div>
    </div>
</div>
<div id="normalisasi"></div>
<div id="ranking"></div>
<div id="juara"></div>
<script src="/ex-script/saw.js"></script>
@endsection
