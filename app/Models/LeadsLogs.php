<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadsLogs extends Model
{
    use HasFactory;
    protected $table = 'leads_logs';
    public $timestamps = false;
}
