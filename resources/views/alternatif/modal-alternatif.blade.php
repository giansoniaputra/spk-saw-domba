<!-- Modal -->
<div class="modal fade" id="modal-alternatif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:;" id="form-alternatif">
                    @csrf
                    <input type="hidden" name="uuid" id="current_uuid">
                    <label for="alternatif">Alternatif</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">A</span>
                        </div>
                        <input type="number" id="alternatif" name="alternatif" class="form-control" placeholder="Masukan Hanya Angka Saja">
                    </div>
                    <div class="form-group mb-3">
                        <label for="no_tanding">No Tanding</label>
                        <input name="no_tanding" class="form-control" id="no_tanding" placeholder="Misal: 8A">
                    </div>
                    <div class="form-group mb-3">
                        <label for="keterangan">Nama Domba</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" placeholder="Masukan keterangan"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="pemilik">Pemilik</label>
                        <input name="pemilik" class="form-control" id="pemilik" placeholder="Masukan Nama Pemilik">
                    </div>
                    <div class="form-group mb-3">
                        <label for="daerah">Daerah</label>
                        <input name="daerah" class="form-control" id="daerah" placeholder="Masukan Nama Daerah">
                    </div>
                    <div class="form-group mb-3">
                        <label for="kelas">Kelas</label>
                        <input name="kelas" class="form-control" id="kelas" placeholder="Masukan Kelas">
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="btn-action">
            </div>
        </div>
    </div>
</div>
