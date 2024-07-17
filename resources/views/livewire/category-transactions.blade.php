<div>
    @section("title", "Tambah Kategori Tabungan")
    @section("content")
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kategori Tabungan </h6>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="save_catdegory">
                <label for="category"> <strong>Kategori Tabungan:</strong> </label>
                <input type="text" wire:model="category" class="form-control" id="category" placeholder="Kategori Tabungan...">
                <label for="amount_target" class="mt-3"> <strong>Kategori Tabungan:</strong> </label>
                <input type="text" wire:model="amount_target" class="form-control" id="amount_target" placeholder="Target Tabungan..." oninput="this.value = formatRupiah(this.value, 'Rp.')">
                <button type="submit" class="btn btn-primary col-md-12 mt-3">Tambah Kategori</button>
            </form>
        </div>
    </div>
    <script>
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    </script>
    @endsection
</div>