<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard | @yield("title")</title>
    <link rel="icon" href="https://incrustwerush.org/img/site/icon.ico" />

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @if(isset($script_tambah_transaksi) || isset($script_tambah_kategori))
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    @endif
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include("Layout.sidebar")

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include("Layout.navbar")

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard | @yield("title")</h1>
                    </div>


                    @yield("content")


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; <?= date("Y") ?> In Crust We Rush. Created by Billy.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siap Untuk Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin untuk mengakhiri sesi?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <!-- <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-pie-demo.js') }}"></script> -->
    @include("sweetalert::alert")

    <!-- tambah transaksi -->
    @if(isset($script_tambah_transaksi))
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
    var no = 1
    var dataTable = $("#data").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_data_transaksi') }}",
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'time'
            },
            {
                data: 'amount',
                render: function(data) {
                    return formatRupiah(data, "Rp.")
                }
            },
            {
                data: 'note'
            },
            {
                data: 'type'
            }
        ]
    })

    function tabung() {
        var amount = $("#amount").val();
        var type = $("#type").val();
        var note = $("#note").val();
        var id_category = $("#id_category").val();

        $.ajax({
            url: "{{ route('tambah.transaksi') }}",
            type: "POST",
            data: {
                amount: amount,
                type: type,
                note: note,
                id_category: id_category,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === "success") {
                    dataTable.ajax.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil perbarui tabungan!"
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan Transaksi",
                        text: "Gagal melakukan transaksi!"
                    });
                }
            },
            error: function(xhr, status, error) {
                if(xhr.status === 500){
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan Transaksi (500)",
                        text: "Silahkan hubungi administrator!"
                    });  
                }
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.error_form;
                    var errorKeys = Object.keys(errors);
                    var errorMessage = errorKeys.map(key => errors[key]).join('<br>');
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan Input",
                        html: errorMessage
                    });
                } else if (xhr.status === 400) {
                    Swal.fire({
                        icon: "error",
                        title: "Kesalahan Transaksi",
                        text: "Gagal melakukan transaksi, karena saldo tidak mencukupi permintaan!"
                    });
                }
            }
        });
    }

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
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
    @endif

    <!-- tambah kategori -->
    @if(isset($script_tambah_kategori))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
    var dataTable = $("#table_category").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_category') }}",
        order: [
            [0, "desc"]
        ],
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: "category",
            },
            {
                data: "amount_target",
                render: function(data) {
                    return formatRupiah(data, "Rp.")
                }
            },
            {
                data: "amount_kini",
                render: function(data) {
                    return formatRupiah(data, "Rp.")
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }

        ]
    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
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

    function addCategory() {
        var category = $("#category").val()
        var amount_target = $("#amount_target").val()
        $.ajax({
            url: "{{ route('tambah_kategori') }}",
            type: "POST",
            data: {
                category: category,
                amount_target: amount_target,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.errors) {
                    console.log(response.errors)
                } else {
                    dataTable.ajax.reload()
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambah Kategori Tabungan!"
                    });
                }
            },
            error: function(xhr, status, error) {
                // console.log(xhr)
                if(xhr.status){
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: "Gagal menambah kategori, karena category yang dimasukan sudah ada!"
                    });
                }
            }
        })
    }

    function deleteCategory(num, title) {
        Swal.fire({
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Iya, Hapus",
            confirmButtonColor: "#e74a3b",
            title: "Peringatan Penghapus",
            text: "Apakah anda ingin menghapus kategori " + title
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('hapus_kategori') }}",
                    type: "POST",
                    data: {
                        id: num,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.error) {
                            console.log(response.error)
                        } else {
                            dataTable.ajax.reload()
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Berhasil Menghapus Category " + title
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr)
                    }

                })
            }
        })
    }
    </script>
    @endif

</body>

</html>