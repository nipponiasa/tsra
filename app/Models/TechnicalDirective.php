<?php

namespace App\Models;

use App\Models\MotorModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TechnicalDirective extends Model
{
    use HasFactory;

    protected $table = 'technical_directives';



    public function motorModels()
    {
        return $this->belongsToMany(MotorModel::class, 'directive_model', 'directive_id', 'model_id');
        // by default, Laravel would look for technical_directive_id and motor_model_id, not directive_id and model_id
        // so, we have to write them explicitly
    }


    public function motorCountries()
    {
        return $this->belongsToMany(MotorModel::class, 'directive_country', 'directive_id', 'country_id');
        // by default, Laravel would look for technical_directive_id and motor_model_id, not directive_id and model_id
        // so, we have to write them explicitly
    }


   // public static function get_directives_list_user2($user_id)
   // {


      
    //    $directives = DB::table('read_state')
    //    ->select('*')
     //   ->Join('technical_directives', 'read_state.item_id', '=', 'technical_directives.id') 
     //   ->where('read_state.item_type', '=', 'DIRECTIVE')
    //    ->where('read_state.user_id', '=', $user_id)
     //   ->orderBy('technical_directives.id', 'desc')
    //    ->get();



//        return $directives;
//}


    
        



public static function get_directives_list_user($user_id)
{

    $directives = DB::select('SELECT read_state.user_id as logged_user,read_state.read as isread, technical_directives.id as directive_id,a.models_name as models, technical_directives.created_at as directive_created_at, technical_directives.updated_at as directive_updated_at, technical_directives.subject as subject, technical_directives.directive as directive, technical_directives.publish_state as publish_state
        FROM read_state JOIN technical_directives
        ON ( read_state.item_id= technical_directives.id)
        LEFT JOIN (SELECT relations.source as directive_id, relations.destination as model_id, GROUP_CONCAT(models.name) as models_name FROM relations join models  ON (relations.destination=models.id)
        WHERE relation_type='."'directives_for_model'".' group by relations.source) as a
        ON ( technical_directives.id= a.directive_id) WHERE read_state.user_id=? ORDER BY technical_directives.id ASC;',[$user_id]);
   
    return $directives;
}


public static function get_directive_user($user_id,$derivative_id)
{

    $directive = DB::select('SELECT read_state.user_id as logged_user,read_state.read as isread, technical_directives.id as directive_id,a.models_name as models, technical_directives.created_at as directive_created_at, technical_directives.updated_at as directive_updated_at, technical_directives.subject as subject, technical_directives.directive as directive, technical_directives.publish_state as publish_state
        FROM read_state JOIN technical_directives
        ON ( read_state.item_id= technical_directives.id)
        LEFT JOIN (SELECT relations.source as directive_id, relations.destination as model_id, GROUP_CONCAT(models.name) as models_name FROM relations join models  ON (relations.destination=models.id)
        WHERE relation_type='."'directives_for_model'".' group by relations.source) as a
        ON ( technical_directives.id= a.directive_id) WHERE read_state.user_id=? and technical_directives.id=? ORDER BY technical_directives.id ASC;',[$user_id,$derivative_id]);
   //dd($directive);
    return $directive;
}










}
