<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kriteria;
use App\Models\Alternatif;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Febrian Zidni',
            'username' => 'febrian',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Kriteria::create([
            'uuid' => Str::orderedUuid(),
            'kode' => 1,
            'kriteria' => 'Kesehatan',
            'atribut' => 'BENEFIT',
            'bobot' => 10,
        ]);

        Kriteria::create([
            'uuid' => Str::orderedUuid(),
            'kode' => 2,
            'kriteria' => 'Adeg-adeg',
            'atribut' => 'BENEFIT',
            'bobot' => 25,
        ]);

        Kriteria::create([
            'uuid' => Str::orderedUuid(),
            'kode' => 3,
            'kriteria' => 'Bertanding',
            'atribut' => 'BENEFIT',
            'bobot' => 30,
        ]);

        Kriteria::create([
            'uuid' => Str::orderedUuid(),
            'kode' => 4,
            'kriteria' => 'Pukulan',
            'atribut' => 'BENEFIT',
            'bobot' => 25,
        ]);

        Kriteria::create([
            'uuid' => Str::orderedUuid(),
            'kode' => 5,
            'kriteria' => 'Keberania',
            'atribut' => 'BENEFIT',
            'bobot' => 10,
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 1,
            'no_tanding' => '8A',
            'keterangan' => 'BALAK',
            'pemilik' => 'BOS ACEP',
            'daerah' => 'PUSAKA NAZWA',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 2,
            'no_tanding' => '8B',
            'keterangan' => 'ZANET',
            'pemilik' => 'BOS TEGUH',
            'daerah' => 'GALUNGGUNG',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 3,
            'no_tanding' => '22A',
            'keterangan' => 'CANGEHGAR',
            'pemilik' => 'ROPIK',
            'daerah' => 'PSJK GARUT',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 4,
            'no_tanding' => '22B',
            'keterangan' => 'JERNIH',
            'pemilik' => 'H LUTPI',
            'daerah' => 'PRESIDEN',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 5,
            'no_tanding' => '2A',
            'keterangan' => 'VERON',
            'pemilik' => 'BOS ADEN',
            'daerah' => 'KENZI PUTRA',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 6,
            'no_tanding' => '29B',
            'keterangan' => 'MIMIS',
            'pemilik' => 'BOS UHI',
            'daerah' => 'MADANGKARA',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 7,
            'no_tanding' => '32A',
            'keterangan' => 'DIRGA',
            'pemilik' => 'BOS AZAT',
            'daerah' => 'TJG GARUT',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 8,
            'no_tanding' => '32B',
            'keterangan' => 'ABIMANYU',
            'pemilik' => 'CEP APRIL',
            'daerah' => 'PUTRA CIALIWUNG',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 9,
            'no_tanding' => '35A',
            'keterangan' => 'PERMATA',
            'pemilik' => 'BOS ECONG',
            'daerah' => 'ABIYASA',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 10,
            'no_tanding' => '35B',
            'keterangan' => 'BULE',
            'pemilik' => 'H BONAR',
            'daerah' => 'PDP PUTRI KEMBAR',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 11,
            'no_tanding' => '37A',
            'keterangan' => 'MESI',
            'pemilik' => 'ASAM',
            'daerah' => 'MUSTIKA RATU',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 12,
            'no_tanding' => '37B',
            'keterangan' => 'TAWES',
            'pemilik' => 'PA ANYU',
            'daerah' => 'PDP 2 PUTRA',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 13,
            'no_tanding' => '39A',
            'keterangan' => 'MESI',
            'pemilik' => 'BOS DIKI',
            'daerah' => 'HASIL TANI',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 14,
            'no_tanding' => '39B',
            'keterangan' => 'BARAK',
            'pemilik' => 'PA EUNYANG',
            'daerah' => 'KEBON EURIH',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 15,
            'no_tanding' => '42A',
            'keterangan' => 'GELAR',
            'pemilik' => 'CEP MANSUR',
            'daerah' => 'PUTRA LESTARI GARUT',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 16,
            'no_tanding' => '42B',
            'keterangan' => 'CIKAL',
            'pemilik' => 'PAK TATA',
            'daerah' => 'KUSOY GROUP',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 17,
            'no_tanding' => '48A',
            'keterangan' => 'BARGOLA',
            'pemilik' => 'CEP GIBRAN',
            'daerah' => 'PUTRA CIALIWUNG',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 18,
            'no_tanding' => '48B',
            'keterangan' => 'GALAKSIGAR',
            'pemilik' => 'PAK OPIK',
            'daerah' => 'PSJK GARUT',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 19,
            'no_tanding' => '52A',
            'keterangan' => 'GALAKSI',
            'pemilik' => 'KANG CEPI',
            'daerah' => 'GUNUNG CIKURAY',
            'kelas' => 'C',
        ]);

        Alternatif::create([
            'uuid' => Str::orderedUuid(),
            'alternatif' => 20,
            'no_tanding' => '52B',
            'keterangan' => 'SADEWA',
            'pemilik' => 'PAK AYI',
            'daerah' => 'ADEM AYEM',
            'kelas' => 'C',
        ]);
    }
}
