<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';


    public function technicalDirectives()
    {
        return $this->belongsToMany(TechnicalDirective::class, 'directive_country', 'country_id', 'directive_id');
        // by default, Laravel would look for technical_directive_id and country_id, not directive_id and country_id
        // so, we have to write them explicitly
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
