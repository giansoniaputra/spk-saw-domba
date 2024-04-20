$(document).ready(function () {
    $("#btn-add-perhitungan").on("click", function () {
        Swal.fire({
            title: "Yakin ingin menambah data baru?",
            text: "Anda akan mereset data sebelumnya",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Buat!",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#spinner").html(loader)
                $.ajax({
                    url: "/perhitungan-create/?kelas=" + $('#kelas').val(),
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        $("#spinner").html("")
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: response.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(() => {
                            document.location.reload();
                        }, 2000)
                    },
                });
            }
        });
    });
    $("#table-perhitungan").on("click", "#nilai-bobot", function () {
        let data = $(this)
        let current_input = document.querySelectorAll(".input-bobot")
        current_input.forEach((a) => {
            a.classList.add('d-none')
            a.parentElement.previousElementSibling.classList.remove('d-none')
        })
        $(this).children().eq(0).addClass("d-none")
        $(this).children().eq(1).children().eq(0).removeClass("d-none")
        $(this).children().eq(1).children().eq(0).focus()

    })
    $("#table-perhitungan").on("change", ".input-bobot", function () {
        let thiss = $(this)
        let p = $(this).parent().prev()
        let uuid = thiss.data("uuid")
        $.ajax({
            data: { bobot: thiss.val() },
            url: "/perhitungan-update/" + uuid,
            type: "get",
            dataType: 'json',
            success: function (response) {
                p.html(response.success)
                thiss.val(response.success)
            }
        });
    })

    // KEPUTUSAN
    $("#btn-normalisasi").on("click", function () {
        $("#spinner").html(loader)
        let kelas = $("#kelas").val();
        if (kelas == 'favorit') {
            var url = "/saw-normalisasi/" + kelas + "?kelas=" + $("#rKelas").val()
        } else {
            var url = "/saw-normalisasi/" + kelas
        }
        $.ajax({
            url: url,
            type: "GET",
            dataType: 'json',
            success: function (response) {
                let data = response.data
                console.log(response.hasil_kali);
                let rankingElement = document.querySelector('#ranking')
                let juaraElement = document.querySelector('#juara')
                let normalisasiElement = document.querySelector('#normalisasi');
                let keys = Object.keys(data.perhitungan)
                // Menampilkan data normalisasi untuk di load ke halaman
                let normalisasi = `
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                            <h3>Tabel Normalisasi</h3>
                            </div>
                            <div class="card-body">
                                <table id="table-normalisasi" class="table table-bordered table-hover dtr-inline" style="overflow:scroll ">
                                    <thead>
                                        <tr>
                                            <th class="text-center" rowspan="2">Alternatif</th>
                                            <th class="text-center" rowspan="2">Keterangan</th>
                                            <th class="text-center" colspan="${data.sum_kriteria}">Kriteria</th>
                                        </tr>
                                        <tr>`;
                data.kriterias.forEach((kriteria) => {
                    normalisasi += `<th class="tetx-center">C${kriteria.kode}</th>`
                })
                normalisasi += `
                </tr>
                </thead>
                <tbody>
                `;
                if (keys.length == 0) {
                    normalisasi += `<tr><td class="text-center" colspan="${2 + data.sum_kriteria}">Belum Ada Perhitungan</td></tr>`
                } else {
                    normalisasi += data.elements
                }
                normalisasiElement.innerHTML = normalisasi

                // PERANGKINGAN
                // let hasil_ranking = ranking2(data.ranking)
                // console.log(hasil_ranking);

                // let rankTable = [];
                // for (let i = 0; i < data.ranking.length; i++) {
                //     rankTable.push([`A+${i + 1}`,])
                // }

                let ranking = `
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                <h3>Tabel Perankingan</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table-perankingan" class="table table-bordered table-hover dtr-inline" style="overflow:scroll ">
                                        <thead>
                                            <tr>
                                                <td>No Tanding</td>
                                                <td>Alternatif</td>
                                                <td>Pemilik</td>
                                                <td>Daerah</td>
                                                <td>Kelas</td>
                                                <td>Hasil</td>
                                                <td>Ranking</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    `;
                let bobot = 0;
                let rankPosition = 0;
                data.ranking.forEach((a, b) => {
                    if (a[1] == bobot) {
                        var rank = rankPosition;
                        rankPosition *= 0;
                        rankPosition += rank;
                    } else {
                        var rank = rankPosition + 1;
                        rankPosition *= 0;
                        rankPosition += rank;
                    }
                    ranking += `
                                        <tr>
                                            <td>${a[3]}</td>
                                            <td>${a[0]}</td>
                                            <td>${a[4]}</td>
                                            <td>${a[5]}</td>
                                            <td>${a[6]}</td>
                                            <td>${a[1]}</td>
                                            <td>${rank}</td>
                                        </tr>
                                        `
                    bobot *= 0;
                    bobot += a[1];
                })

                ranking += `</tbody></table>`
                rankingElement.innerHTML = ranking
                // JUARA
                let juara = `
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                <h3>Tabel Juara</h3>
                                </div>
                                <div class="card-body">
                                    <table id="table-perankingan" class="table table-bordered table-hover dtr-inline" style="overflow:scroll ">
                                        <thead>
                                            <tr>
                                            <td>No Tanding</td>
                                            <td>Alternatif</td>
                                            <td>Pemilik</td>
                                            <td>Daerah</td>
                                            <td>Kelas</td>
                                            <td>Hasil</td>
                                            <td>Ranking</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    `;
                let bobot2 = 0;
                let rankPosition2 = 0;
                if (data.ranking.length < 6) {
                    if (a[1] == bobot2) {
                        var rank2 = rankPosition2;
                        rankPosition2 *= 0;
                        rankPosition2 += rank2;
                    } else {
                        var rank2 = rankPosition2 + 1;
                        rankPosition2 *= 0;
                        rankPosition2 += rank2;
                    }
                    data.ranking.forEach((a, b) => {
                        juara += `
                        <tr>
                        <td>${a[3]}</td>
                        <td>${a[0]}</td>
                        <td>${a[4]}</td>
                        <td>${a[5]}</td>
                        <td>${a[6]}</td>
                        <td>${a[1]}</td>
                        <td>${rank2}</td>
                    </tr>
                                        `
                        bobot2 *= 0;
                        bobot2 += a[1];
                    })
                } else {
                    let bobot2 = 0;
                    let rankPosition2 = 0;
                    let b = 1;
                    for (let i = 0; i < 6; i++) {
                        if (data.ranking[i][1] == bobot2) {
                            var rank2 = rankPosition2;
                            rankPosition2 *= 0;
                            rankPosition2 += rank2;
                        } else {
                            var rank2 = rankPosition2 + 1;
                            rankPosition2 *= 0;
                            rankPosition2 += rank2;
                        }
                        juara += `
                                        <tr>
                                            <td>${data.ranking[i][3]}</td>
                                            <td>${data.ranking[i][0]}</td>
                                            <td>${data.ranking[i][4]}</td>
                                            <td>${data.ranking[i][5]}</td>
                                            <td>${data.ranking[i][6]}</td>
                                            <td>${data.ranking[i][1]}</td>
                                            <td>${rank2}</td>
                                        </tr>
                                        `
                        bobot2 *= 0;
                        bobot2 += data.ranking[i][1];
                    }
                }

                juara += `</tbody></table><div class='card-footer'><button onclick=\"window.print()\" class=\"btn btn-primary no-print\">Cetak Laporan</button></div>`
                juaraElement.innerHTML = juara
                $("#spinner").html("")
            }
        });
    })
    // Fungsi untuk mentranspose matriks
    function transpose(matrix) {
        return matrix[0].map((col, i) => matrix.map(row => row[i]));
    }

    function ranking2(arrayAwal) {
        // Buat salinan array awal untuk diurutkan
        const sortedArray = [...arrayAwal].sort((a, b) => b - a);

        // Buat objek untuk menetapkan peringkat ke setiap elemen dalam array
        const peringkat = {};
        let rank = 1;
        sortedArray.forEach((value, index) => {
            if (!(value in peringkat)) {
                peringkat[value] = rank++;
            }
        });

        // Buat array baru yang berisi peringkat dari setiap elemen dalam array awal
        const arrayBaru = arrayAwal.map(value => peringkat[value]);

        return arrayBaru;
    }

})
