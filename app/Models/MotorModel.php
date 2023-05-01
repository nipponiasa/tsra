<?php

namespace App\Models;

use App\Models\TechnicalDirective;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MotorModel extends Model
{
    use HasFactory;

    protected $table = 'models';



    public function technicalDirectives()
    {
        return $this->belongsToMany(TechnicalDirective::class, 'directive_model', 'model_id', 'directive_id');
        // by default, Laravel would look for technical_directive_id and motor_model_id, not directive_id and model_id
        // so, we have to write them explicitly
    }


}
