<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TechnicalReport extends Model
{
    use HasFactory;

    protected $table = 'support_cases';


    


    public static function list_tr_one($reportt)
    {
    
$technical_reports = DB::select('SELECT support_cases.subject AS subject,support_cases.status_id AS status_id,case_status.statusname AS statusname,
support_cases.summary AS summary,support_cases.claim_approved AS claim_approved,support_cases.issue1 AS issue1,
support_cases.issue2 AS issue2,support_cases.issue3 AS issue3,support_cases.id AS id,support_cases.po AS po,
support_cases.description AS description,support_cases.isaclaim AS isaclaim,support_cases.created_at AS created_at,
users_with_role.name AS name,users_with_role.mypic AS mypic,users_with_role.id AS nameid,users_with_role.rolename AS rolename,
users_with_role.roleid AS roleid,users_with_role.email AS email,support_cases.attached_files_folder_path AS attached_files_folder_path,
support_cases.nextorderreminder AS nextorderreminder,support_cases.nextorderremindert AS nextorderremindert,
group_concat(models.name separator \',\') AS models 
FROM support_cases JOIN users_with_role ON(support_cases.user_id = users_with_role.id)
LEFT JOIN relations on (support_cases.id = relations.destination)
LEFT JOIN models on (models.id = relations.source)
LEFT JOIN case_status ON (support_cases.status_id = case_status.id)
WHERE support_cases.id=?
GROUP BY support_cases.id;',[$reportt]);
       
//dd($technical_reports);


        return $technical_reports;
    }




    public static function list_tr_all()
    {
    
$technical_reports = DB::select('SELECT support_cases.subject AS subject,support_cases.status_id AS status_id,case_status.statusname AS statusname,
support_cases.summary AS summary,support_cases.claim_approved AS claim_approved,support_cases.issue1 AS issue1,
support_cases.issue2 AS issue2,support_cases.issue3 AS issue3,support_cases.id AS id,support_cases.po AS po,
support_cases.description AS description,support_cases.isaclaim AS isaclaim,support_cases.created_at AS created_at,
users_with_role.name AS name,users_with_role.mypic AS mypic,users_with_role.id AS nameid,users_with_role.rolename AS rolename,
users_with_role.roleid AS roleid,users_with_role.email AS email,support_cases.attached_files_folder_path AS attached_files_folder_path,
support_cases.nextorderreminder AS nextorderreminder,support_cases.nextorderremindert AS nextorderremindert,
group_concat(models.name separator \',\') AS models 
FROM support_cases JOIN users_with_role ON(support_cases.user_id = users_with_role.id)
LEFT JOIN relations on (support_cases.id = relations.destination)
LEFT JOIN models on (models.id = relations.source)
LEFT JOIN case_status ON (support_cases.status_id = case_status.id)
GROUP BY support_cases.id;');
       
//dd($technical_reports);


        return $technical_reports;
    }












}
