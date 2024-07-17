<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\C_Login;
use \App\Http\Controllers\C_Dashboard;

use \App\Livewire\CategoryTransactions;
// Route::get('/', function () {
    
// });
Route::get("/", [C_Login::class, "index"])->name("login");
Route::post("/", [C_Login::class, "action_login"])->name("action_login");

Route::middleware(["auth"])->group(function (){
    Route::get("/dashboard", [C_Dashboard::class, "index"])->name("home");
    Route::get("/dashboard/transaksi", [C_Dashboard::class, "transaksi"])->name("riwayat_transaksi");
    Route::post("/dashboard/transaksi", [C_Dashboard::class, "tambah_transaksi"])->name("tambah.transaksi");
    Route::get("/dashboard/get_transaksi", [C_Dashboard::class, "getDataTransaksi"])->name("get_data_transaksi");
    Route::get("/dashboard/aksi_target", [C_Dashboard::class, "targetAction"])->name("aksi_target");
    Route::get("/dashboard/get_category", [C_Dashboard::class, "getCategoryTransactions"])->name("get_category");
    Route::post("/dashboard/tambah_kategori", [C_Dashboard::class, "addCategory"])->name("tambah_kategori");
    Route::post("/dashboard/hapus_kategori", [C_Dashboard::class, "deleteCategory"])->name("hapus_kategori");
    Route::get("/dashboard/users", [C_Dashboard::class, "users"])->name("users");
    Route::get("/dashboard/hapus_user/{id}", [C_Dashboard::class, "hapus_user"])->name("hapus_user");
    Route::post("/dashboard/users", [C_Dashboard::class, "tambah_user"])->name("tambah_user");
    Route::get("/dashboard/logout", [C_Dashboard::class, "logout"])->name("logout");
});