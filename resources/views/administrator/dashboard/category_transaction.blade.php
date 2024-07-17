@extends("Layout.root")
@section("title", "Tambah Kategori Tabungan")
@section("content")
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Kategori Tabungan </h6>
    </div>
    <div class="card-body">
        <label for="category"><strong>Kategori Tabungan</strong></label>
        <input type="text" name="category" id="category" class="form-control" placeholder="Kategori Tabungan..."
            value="">
        <label for="amount_target" class="mt-3"><strong>Target Tabungan</strong></label>
        <input type="text" id="amount_target" class="form-control" name="amount_target" placeholder="Jumlah..." value=""
            oninput="this.value = formatRupiah(this.value, 'Rp.')">
        <button id="submit" class="btn btn-primary col-md-12 mt-3" onclick="addCategory()">
            Tabung
        </button>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi </h6>
    </div>
    <div class="card-body">
        <table id="table_category" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Kategori</th>
                    <th>Jumlah Target</th>
                    <th>Jumlah Kini</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection