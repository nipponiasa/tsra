<?php

namespace App\Models;

use App\Models\User;
use App\Models\CaseStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechnicalCase extends Model
{
    use HasFactory;

    protected $table = 'technical_cases';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->hasOne(CaseStatus::class,'id','status_id');
    }


}
