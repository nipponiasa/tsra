<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use DataTables;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailOut;
use App\Models\User;
use File;
use App\Models\Message;
use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Dcblogdev\MsGraph\Facades\MsGraph;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;
use Dcblogdev\MsGraph\Models\MsGraphToken;

use Vtzimpl\MsgraphMailHandler\MsgraphMailHandler;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use App\Models\TechnicalReport;


class TechnicalReportController extends Controller
{



/////////////////////////////// not used ////////////////////////////////////////////

public function sendEmail()
{
    if (session_status() == PHP_SESSION_NONE)
        session_start();
    $graph = new Graph();
    $graph->setAccessToken($_SESSION['access_token']);
    $me = $this->getMe();

    //Create a new sender object
    $sender = new Model\Recipient();
    $sEmail = new Model\EmailAddress();
    $sEmail->setName($me->getGivenName());
    $sEmail->setAddress($me->getMail());
    $sender->setEmailAddress($sEmail);
    
    //Create a new recipient object
    $recipient = new Model\Recipient();
    $rEmail = new Model\EmailAddress();
    $rEmail->setAddress($_POST['input_email']);
    $recipient->setEmailAddress($rEmail);

    //Set the body of the message
    $body = new Model\ItemBody();
    $body->setContent(Constants::HTML_EMAIL);
    $body->setContentType(Model\BodyType::HTML);

    //Create a new message
    $mail = new Model\Message();
    $mail->setSubject(Constants::EMAIL_SUBJECT)
         ->setBody($body)
         ->setSender($sender)
         ->setFrom($sender)
         ->setToRecipients(array($recipient));

    //Send the mail through Graph
    $request = $graph->createRequest("POST", "/me/sendMail")
                     ->attachBody(array("message" => $mail));
    $request->execute();

    //Return to the email view
    return view('email', array('name' => $me->getGivenName(), 'email' => $me->getMail(), 'status' => 'success'));
}








public function mail_handler($subject,$type)
{
    $userId=env("EMAIL_USERID", "");

    $accessToken=$this->gettoken();
    $graph = new Graph();
    $graph->setAccessToken($accessToken);


//dd( $accessToken);
    //$emails = MsGraphAdmin::get('users/'.$userId.'/messages?select=subject&$filter=subject eq \''.$subject.'\''); //sosto
   // $emails = MsGraphAdmin::delete('users/'.$userId.'/messages?select=subject&$filter=contains(subject, \''.$subject.'\')'); //sosto

   $mailid='AAMkADdkNGQ1YjBhLTUwMjYtNDRmNS1iMjY5LTczNTA4ODcwMzY4OQBGAAAAAADI0mtx64SsR5nEA2SqXWvvBwCwi2yxLzSXSLpiqM7jYfQTAAAAAAEJAACwi2yxLzSXSLpiqM7jYfQTAABJYvjJAAA=';
   $parentfolderid='AAMkADdkNGQ1YjBhLTUwMjYtNDRmNS1iMjY5LTczNTA4ODcwMzY4OQAuAAAAAADI0mtx64SsR5nEA2SqXWvvAQCwi2yxLzSXSLpiqM7jYfQTAAAAAAEJAAA=';
  $a=json_encode(["destinationId"=> $parentfolderid ]);
  //dd($a);
  //$requestBody = new CopyPostRequestBody();
 // $requestBody->setDestinationId($parentfolderid);


  $requestBody=json_encode(['destinationId' => $parentfolderid]);







    switch ($type) {
        case 'subject_contains':

            $emails = $graph->createRequest("GET", '/users/'.$userId.'/messages?$filter=contains(subject, \''.$subject.'\')')
            ->setReturnType(Model\MailSearchFolder::class)
            ->execute()[0];


          break;
        case 'move_to_old':
            //$emails = $graph->createRequest("POST", '/users/'.$userId.'/mailFolders/'.$mailid.'/move')
            //->addHeaders(["Content-Type" => "application/json"])
            //->setReturnType(Model\MailSearchFolder::class)
           // ->attachBody($a)
           // ->execute();
          // $emails = $graph->createRequest("DELETE", '/users/'.$userId.'/messages/'. $mailid)
          // ->setReturnType(Model\MailSearchFolder::class)
           //->execute();

           $body="dsfgergerg";
           $sender="ts@nipponia.com";
           $recipient="tzimplakisv@nipponia.com";

           $mail = new Model\Message();
           $mail->setSubject("hjhjh")
                ->setBody($body)
                ->setSender($sender)
                ->setFrom($sender)
                ->setToRecipients(array($recipient));
   
                //dd($mail);
           //Send the mail through Graph
           $request = $graph->createRequest("POST", "/users/'.$userId.'/sendMail")
                            ->attachBody(json_encode(array("message" => $mail)));
           $request->execute();
 
          break;

          break;
        
        default:
          ;
      } 






return $emails;
  
}






public function gettoken()
{
    $clientId=env("MSGRAPH_CLIENT_ID", "");
    $clientSecret=env("MSGRAPH_SECRET_ID", "");
    $tenantId=env("MSGRAPH_TENANT_ID", "");


    $guzzle = new \GuzzleHttp\Client();
    $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/v2.0/token';
    $token = json_decode($guzzle->post($url, [
        'form_params' => [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => 'https://graph.microsoft.com/.default',
            'grant_type' => 'client_credentials',
        ],
    ])->getBody()->getContents());
    $accessToken = $token->access_token;
    return $accessToken;

    }







    public function get_send_mail_conversationid_old($subject)
    {
    
        $userId=env("EMAIL_USERID", ""); // gia to ts@nipponia.com
        //$userId='51c116ee-aae8-4ec5-9c20-ee0b947f06e1'; 
        //$conversationid='AAMkADdkNGQ1YjBhLTUwMjYtNDRmNS1iMjY5LTczNTA4ODcwMzY4OQAuAAAAAADI0mtx64SsR5nEA2SqXWvvAQCwi2yxLzSXSLpiqM7jYfQTAAAAAAEJAAA=';
      
        //$test=MsGraphAdmin::emails()->userid($userId)->get(["\$subject" => $subject]);

        //$userId='51c116ee-aae8-4ec5-9c20-ee0b947f06e1';
       // $subject2=urlencode($subject);
       //$a='users/'.$userId.'/messages?select=subject&$filter=subject eq \''.$subject2.'\'';
      // $h='AAQkADdkNGQ1YjBhLTUwMjYtNDRmNS1iMjY5LTczNTA4ODcwMzY4OQAQAI_yaetvvOlPlYZ36t7zpDw=';
    // $emails = MsGraphAdmin::get('users/'.$userId.'/messages?$filter=conversationId eq '. "'".$h."'"); //sosto
    
   
//array_push($a,'users/'.$userId.'/messages?$filter=conversationId eq '. "'".$h."'");
//$subject='Re: test1';
//$url='users/'.$userId.'/messages?$select=subject&$filter=subject eq \''.addslashes($subject).'\'';
//array_push($a,'users/'.$userId.'/messages?$filter=subject eq '. "'".$subject."'");
//AAQkADdkNGQ1YjBhLTUwMjYtNDRmNS1iMjY5LTczNTA4ODcwMzY4OQAQAG-mbA17XkhOpC1Q_O_rURo=
//$search="hello world"   $select=subject&$filter=subject eq 'Re: test1'
       //$conversationId = MsGraphAdmin::get('users/'.$userId.'/messages?$select=conversationId&$search='.$subject)['value'][0]['conversationId']; //sosto
       $emails = MsGraphAdmin::get('users/'.$userId.'/messages?select=subject&$filter=subject eq \''.$subject.'\''); //sosto
       $emails = MsGraphAdmin::delete('users/'.$userId.'/messages?select=subject&$filter=contains(subject, \''.$subject.'\')'); //sosto

       //=contains(deviceName, 'N5')
       //?$select=id,recevedDateTime,subject,from&$filter=singleValueExtendedProperties/any(ep:ep/id eq 'String 0x5D01' and ep/value eq 'gscales@blahblah.com')&$orderby=receivedDateTime DESC
       //$emails=htmlentities('https://graph.microsoft.com/v1.0/users/51c116ee-aae8-4ec5-9c20-ee0b947f06e1/messages?$select=subject&$search=Re: test1');
       dd( $emails);



        //$emails = MsGraphAdmin::get('users/'.$userId.'/messages?$filter=subject eq testgetmail case__75');
return $emails;
        //
    }




}