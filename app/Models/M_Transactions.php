<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Transactions extends Model
{
    use HasFactory;
    protected $table = "transactions";
    protected $fillable = [
        "id",
        "amount",
        "type",
        "note",
        "time",
        "id_category"
    ];
    protected $casts = [
        'note' => 'string', // Casting 'note' sebagai string
    ];
}
