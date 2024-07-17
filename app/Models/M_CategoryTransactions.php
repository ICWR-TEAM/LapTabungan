<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_CategoryTransactions extends Model
{
    use HasFactory;
    protected $table = "category_transactions";
    protected $fillable = [
        "id", "category", "amount_target", "amount_kini"
    ];
}
