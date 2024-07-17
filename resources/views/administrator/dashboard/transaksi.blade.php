@extends('Layout.root')
@section('title', 'Transaksi')
@section('content')

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Transaksi </h6>
    </div>
    <div class="card-body">
        <label for="note"><strong>Keterangan</strong></label>
        <input type="text" name="note" id="note" class="form-control @error('note') is-invalid @enderror"
            placeholder="Keterangan..." value="{{ old('note') }}">
        <label for="amount" class="mt-3"><strong>Jumlah</strong></label>
        <input type="text" id="amount" class="form-control" name="amount"
            placeholder="Jumlah..." value="{{ old('amount') }}">
        <label for="type" class="mt-3"> <strong>Tipe</strong> </label>
        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
            <option value="">Tipe tabungan...</option>
            <option value="deposit">Deposit</option>
            <option value="withdrawal">Withdrawal</option>
        </select>
        <label for="id_category" class="mt-3"> <strong>Tipe</strong> </label>
        <select name="id_category" id="id_category" class="form-control">
            <option value="">Kategori</option>
            @foreach($category_id as $value=>$key)
            <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <button id="submit" class="btn btn-primary col-md-12 mt-3" onclick="tabung()">
            Tabung
        </button>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Transaksi </h6>
    </div>
    <div class="card-body">
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th width="20px">No</th>
                    <th>Tanggal Tabung</th>
                    <th>Jumlah</th>
                    <th>Catatan</th>
                    <th>Tipe</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


<script type="text/javascript">
    var rupiah = document.getElementById('amount');
    rupiah.addEventListener('keyup', function(e) {
        rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

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
// $(document).ready(function() {


    //added transaction

// })
</script>
@endsection