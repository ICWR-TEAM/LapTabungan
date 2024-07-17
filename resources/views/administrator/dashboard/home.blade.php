@extends("Layout.root")
@section("title", "Home")

@section("content")
<?php
function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	return $hasil_rupiah;
 
}
?>
<div class="row">
    <!-- Jumlah Saldo Keseluruhan -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Tabungan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rupiah($result[0]->total_amount_kini) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah Transaksi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Transaksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $result[0]->total_transactions }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Target Sukses
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    {{ $result[0]->count_reminder }}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <?php 
                                    $countReminder = $result[0]->count_reminder;
                                    $countCategory = $result[0]->count_category;
                                    $percentage = $countCategory ? ($countReminder / $countCategory) * 100 : 0;
                                    ?>
                                    <div class="progress-bar bg-info" role="progressbar"
                                        style="width: {{ $percentage }}%" aria-valuenow="50" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bullseye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jumlah User -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah User</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $result[0]->total_users }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Pencapaian Tabungan ( category )</h6>
    </div>
    <div class="card-body">

        @foreach($result_all_categorys as $row)
        <?php 
        $amountKini = $row->amount_kini;
        $amountTarget = $row->amount_target;
        $percentage_target = $amountKini != 0 ? ($amountKini / $amountTarget) * 100 : 0;
        ?>
        <h4 class="small font-weight-bold">{{ $row->category }} <span class="float-right">{{$percentage_target}}%</span></h4>
        <div class="progress mb-4">
            <div class="progress-bar @if($percentage_target < 50) bg-danger @elseif($percentage_target > 50 && $percentage_target < 75) bg-primary @else bg-success @endif" role="progressbar" style="width: {{ $percentage_target }}%" aria-valuenow="20"
                aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        @endforeach
        {{ $result_all_categorys->links() }}
    </div>
</div>
@endsection