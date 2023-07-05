<?php

namespace App\Models;

use App\Models\TechnicalCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vin extends Model
{
    use HasFactory;

    protected $table = 'vins';


    public function case()
    {
        return $this->belongsTo(TechnicalCase::class,'case_id','id');
    }

    public function as_array(){
        return [$this->vin,$this->distance];
    }


}

