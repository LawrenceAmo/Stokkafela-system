<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Referral;
use App\Contact;
use App\Models\Auth_token;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;


class Api_authenticate extends Model
{
    use HasFactory;

    /////         decode API Tokens from cookies or Request   //////////
public function token_decode($tokens = null){
  if ($tokens === null) {
            if (count($_COOKIE) < 0) return false;
            if (!isset($_COOKIE['access_token']) || !isset($_COOKIE['secret_token']) ) return false;
            
              $access_token = $_COOKIE['access_token'];
              $secret_token =  $_COOKIE['secret_token'];
          } else {
              $access_token = $tokens->access_token;
              $secret_token =  $tokens->secret_token;        
          }
          
          $access_token_arr_len = 3;    // eccess token must have 3 parts when exploded(header,payload and signature)
          $access_token_arr = explode(".", $access_token);
          if( count($access_token_arr) !== $access_token_arr_len) return false;
          
          $header = $access_token_arr[0];
          $payload = $access_token_arr[1];
          $signature = $access_token_arr[2];
          
          $verify_header = hash('sha256', $payload."".$signature."".$secret_token);
         if(!hash_equals($verify_header, $header)) return false;

        return ["header"=>$header, "payload"=>$payload, "signature"=>$signature, "secret_token"=>$secret_token];
}

     // register in api user
    public function api_register($user)
    {
      try{
          $first_name = $user->first_name;
          $last_name = $user->last_name;
          $email = $user->email;
          $password = $user->password;
          $confirm_password = $user->confirm_password;
          $role = $user->role ?? 4;
        } catch (\Exception $e) {
          return "Fill all required imputs";
        } catch (\Throwable $e) {
          return "Fill all required imputs";
        }

      if (!is_string($email) || !is_string($password) || !is_string($first_name) || !is_string($last_name))
         return "Inputs must be of type string";

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "invalid email format";

      $validate_password = $this->validate_password($password, $confirm_password);
      if($validate_password !== "success") return $validate_password;

      $user_info = DB::table('users')->where('email',$email)->get();
      if(!$user_info->isEmpty()) return "This E-mail is already registered, sign in instead...";

        $user = User::create([
              'firstName' => $first_name,
              'lastName' => $last_name,
              'email' => $email,
              'status' => true,
              'roleID' => $role,
              'password' => Hash::make($password),
          ]);

        $token = new Auth_token();
        $token->authenticated = false;
        $token->userID = $user->id;
        $token->save();

        // $referral = new Referral();
        // $referral->referralID = $referralID;
        // $referral->referredID = $user->id;
        // $referral->affiliateID = $refID;
        // $referral->save();

        // $login = new Login(); // show that user logged in
        // $login->email = $email;
        // $login->status = true;  // successfully registered and logged in.
        // $login->save();

        DB::insert('insert into contacts (id)
        values (?)', [$user->id]);

        // Mail::to($email)->send(new WelcomeMail());

        return "success";
    }

    /*
     *  Authenticate the user api request by creating tokens
     *  check if user is Authenticated then if not exit fun with return false
     *  If whn checking if user is auth then return false, user must re-sign in
     *  that will show that user is not authenticated or the tokens are invalid
     *  then by re-sign in will refresh/re-issue new valid tokens.
    */
    public function api_isAuth($tokens = null):bool
    {         
          $data = $this->token_decode($tokens);
          if (!$data) return false;

          $payload = $data['payload'];
          $signature = $data['signature'];
          $secret_token = $data['secret_token'];
        
         try {
               $decrypted_payload = Crypt::decryptString($payload);
         } catch (DecryptException $e) {
           return false;
         }
         
         $data = json_decode($decrypted_payload,true);
 
        // checking if payload have valid parameters (if not then exit with return false)
        try {
               $issued_time = $data["issued_time"]; //  timestamp
               $exp_time = $data["expire_time"];    //  timestamp
               $role = $data["role"];                    //  string
               $permissions = $data["permissions"];      //  string
               $user_name = $data["user_name"];          //  string
               $user_uid = $data["user_uid"];            //  string
               $authenticated = $data["authenticated"];  //  boolean
               $user_agent = $data["user_agent"];        //  string
        } catch (\Exception $e) {
          return false;
        } catch (\Throwable $e) {
          return false;
        }       
     
        $current_time = now()->timestamp;

          // checking if data (specifically dates) privided in payload is valid
        if (
          $issued_time > $current_time ||
          $exp_time < $issued_time || 
          $exp_time < $current_time ||
          !$authenticated
          ) return false;

        $new_payload = [
                         "issued_time" => $current_time,
                         "expire_time" => $this->auth_timestamp(),
                         "role" => $role,
                         "permissions" => $permissions,
                         "user_name" => $user_name,
                         "user_uid" => $user_uid,
                         "authenticated" => $authenticated,
                         "user_agent" => $user_agent,
                       ];

        $new_access_token = $this->create_api_access_tokens($new_payload, $signature, $secret_token);
        $this->create_api_headers($new_access_token, $secret_token);
        return true;
    }



    // sign in api user
    public function api_signin($user_info, int $minutes = 30)
    {
        try{
          $email = $user_info->email;
          $password = $user_info->password;
        } catch (\Exception $e) {

              try {
                $email = $user_info["email"];
                $password = $user_info["password"];
              } catch (\Throwable $th) {
                return "Fill all required imputs";
              }  catch (\Exception $e) {
                return "Fill all required imputs";
              }
          
        } catch (\Throwable $e) {
          return "There's something wrong, Try to Fill all required imputs or contact your Admin, at support@amomad.com";
        }

      if (!is_string($email) || !is_string($password)) return "Inputs must be of type string";
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "invalid email format";

      if($this->validate_password($password) !== "success") return $this->validate_password($password);

      $user_info = DB::table('users')->where('email',$email)->get();
      if($user_info->isEmpty() || !Hash::check($password, $user_info[0]->password)) return "Invalid credintials!";
     
      $user = $user_info[0];
      // $role = DB::table('roles')->where('roleID', $user->roleID)->get();
      // $role = $role[0];

      $user_agent = getallheaders();
      $current_time = now()->timestamp;
      $new_payload = [
                      "issued_time" => $current_time,
                      "expire_time" => $this->auth_timestamp($minutes),
                      // "role" => $role->role,
                      // "permissions" => $role->permission,
                      "user_name" => $user->username,
                      "user_uid" => $user->id,
                      "authenticated" => true,
                      "user_agent" => $user_agent["User-Agent"],
                    ];

      $signature = $this->create_signature($user_info);
      $secret_token = $this->create_secret_token($user_info, $signature);

        $new_access_token = $this->create_api_access_tokens($new_payload, $signature, $secret_token);
        $verified_token = $new_access_token."".$secret_token;
        DB::table("auth_tokens")->where("userID", $user->id)
        ->update([
            'access_token' => $new_access_token,
            'secret_token' => $secret_token,
            'verify_tokens' => Hash::make($verified_token),
            'authenticated' => true,
        ]);
        $this->create_api_headers($new_access_token, $secret_token);
        return "success";
    }


    ///////******************************************************************** */
        ///////// Set the cookies   //////////
    public function api_deleteAuthCookies():void
    {
        setcookie('access_token','',time()-86000, '/');   
        setcookie('secret_token','',time()-86000, '/');         
    }

      public function requestPassword(string $email)
      {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid email";
        $token = $email."".$this->auth_timestamp();
        $token = Hash::make($token);

        DB::table('password_resets')->updateOrInsert(
          ['email' =>$email],
            ['token' => $token],
          );

          ////////// send email here ////
          
        return "success";
      }

    public function api_resetPassword($request)
    {
      try{
          $email = $request->email;
          $password = $request->password;
          $confirm_password = $request->confirm_password;
          $token = $request->token;
        } catch (\Exception $e) {
          return "Fill all required imputs";
        } catch (\Throwable $e) {
          return "Fill all required imputs";
        }
        
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Invalid email";

       $validate_password = $this->validate_password($password, $confirm_password);
       if($validate_password !== "success") return $validate_password;

        $password_reset_token = DB::table('password_resets')->where('email',$email)->get();
        if($password_reset_token->isEmpty()) 
          return "There was no request password reset for this email! try to log in or register";

        if(strcmp($password_reset_token[0]->token, $token) !== 0)
          return "This token is invalid, Please provide with a valid token or try to resend new token";
        
        $user_info = DB::table('users')->where('email',$email)->get();
        if($user_info->isEmpty()) return "No such user. Register new account";

        DB::table("users")->where("id",$user_info[0]->id)
            ->update([
                'password' => Hash::make($password),
            ]);
        DB::table('password_resets')->where('email',$email)->delete();
        return 'success';
    }


    ////////////////
    public function validate_password(string $password, string $confirm_password = null)
    {
      if(strlen($password) < 6) return "password too short! recommended legnth: 6 charactors";
      
      if(!preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) || !preg_match('/[^a-zA-Z\d]/', $password) || !preg_match('/\d/', $password) )
       return "password must contain number, special charactor and an upper case letter";

       if ($confirm_password !== null) {
             if(strcmp($password, $confirm_password) !== 0) return "password not match";
       }

      return "success";
    }

    public function create_signature($user)
    {
      if ($user->isEmpty()) return false;
        return hash("sha256",json_encode($user));
    }

    public function create_secret_token($user, string $signature):string
    {
      if ($user->isEmpty()|| strlen($signature) < 1) return false;  // signature must be a long string
      $secret_token = json_encode($user).".".$signature;
      
       return Crypt::encryptString($secret_token);
    }


    public function create_api_access_tokens($payload, string $signature, string $secret_token):string
    {
      $new_payload = Crypt::encryptString(json_encode($payload));
      $hash_val = $new_payload."".$signature."".$secret_token;
      $head = hash("sha256", $hash_val);
      return $head.".".$new_payload.".".$signature;
    }


    public function create_api_headers(string $access_token, string $secret_token):void
    {
        setcookie('access_token',$access_token,$this->auth_timestamp(), '/');   // set the cookie
        setcookie('secret_token',$secret_token,$this->auth_timestamp(), '/');   // set the cookie

        header("access_token:".$access_token);
        header("secret_token:".$secret_token);
    }


       // add 15 min to keep user authenticated{works in api}
    public function auth_timestamp(int $minutes = 60):int
    {
       ($minutes < 1 || $minutes > 360) ? $minutes = 30 : $minutes = $minutes;
        return now()->addMinutes($minutes)->timestamp;
    }

////////////////////////////////////////////////////////////////// 
////////            get the user id from webapi   /////////
public function api_getUID($user_tokens){

      if (!$this->token_decode($user_tokens)) return false;
      $data = $this->token_decode($user_tokens);           

      $payload = $data['payload'];
         try {
               $decrypted_payload = Crypt::decryptString($payload);
         } catch (DecryptException $e) {
           return false;
         }
         
         $data = json_decode($decrypted_payload,true);
 
        try {
          
               $user_uid = $data["user_uid"];            //  string
        } catch (\Exception $e) {
          return false;
        } catch (\Throwable $e) {
          return false;
        }

        return $user_uid;
    }

public static function name(string $name){
  return strlen($name);
}
}
