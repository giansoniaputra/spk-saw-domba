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
        $.ajax({
            url: "/saw-normalisasi/" + $("#kelas").val(),
            type: "GET",
            dataType: 'json',
            success: function (response) {
                let data = response.data
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
                                                <td>Alternatif</td>
                                                <td>Keterangan</td>
                                                <td>Bobot</td>
                                                <td>Ranking</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    `;
                data.ranking.forEach((a, b) => {
                    ranking += `
                                        <tr>
                                            <td>A${a[2]}</td>
                                            <td>${a[0]}</td>
                                            <td>${a[1]}</td>
                                            <td>${b + 1}</td>
                                        </tr>
                                        `
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
                                                <td>Alternatif</td>
                                                <td>Keterangan</td>
                                                <td>Bobot</td>
                                                <td>Ranking</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    `;
                if (data.ranking.length < 6) {
                    data.ranking.forEach((a, b) => {
                        juara += `
                                        <tr>
                                            <td>A${a[2]}</td>
                                            <td>${a[0]}</td>
                                            <td>${a[1]}</td>
                                            <td>${b + 1}</td>
                                        </tr>
                                        `
                    })
                } else {
                    let b = 1;
                    for (let i = 0; i < 6; i++) {
                        juara += `
                                        <tr>
                                            <td>A${data.ranking[i][2]}</td>
                                            <td>${data.ranking[i][0]}</td>
                                            <td>${data.ranking[i][1]}</td>
                                            <td>${b++}</td>
                                        </tr>
                                        `
                    }
                }

                juara += `</tbody></table>`
                juaraElement.innerHTML = juara
                $("#spinner").html("")
            }
        });
    })
    // Fungsi untuk mentranspose matriks
    function transpose(matrix) {
        return matrix[0].map((col, i) => matrix.map(row => row[i]));
    }
})
