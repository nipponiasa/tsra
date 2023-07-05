<?php

namespace App\Models;

use App\Models\TechnicalCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vin extends Model
{
    use HasFactory;

    protected $table = 'vins';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vin', 
        'distance',
        'case_id',
    ];



    public function case()
    {
        return $this->belongsTo(TechnicalCase::class,'case_id','id');          // (model, foreign_key, other_key), maybe not needed here
    }


    public function as_array(){
        return [$this->vin,$this->distance];
    }


}

