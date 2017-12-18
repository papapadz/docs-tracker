<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\PetInfoModel as PETS;
use App\BreedsModel as BREEDS;
use App\UsersModel as USERS;
use App\AccountModel as ACCOUNTS;

class UserInfoController extends BaseController
{
    public function userinfo() {
       $activeLink = 'userinfo';

       $userlist = DB::TABLE('tbl_accounts')
       ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
       ->SELECT('tbl_accounts.user_id', 'firstname', 'middlename', 'lastname', 'home_phone', 'alt_phone', 'address','user_img')
       ->ORDERBY('lastname')
       ->WHERE('user_level','3')
       ->paginate(10);

       return view('admin/userinfo', compact('activeLink','userlist'));
   }

   public function userprofile($user_id) {
       $activeLink = 'userinfo';

       $userinfo = DB::connection('mysql')->select("
            SELECT
            tbl_users.user_id,
            firstname,
            middlename,
            lastname,
            home_phone,
            alt_phone,
            email,
            address,
            occupation,
            gender,
            is_attended,
            expectations,
            heard_of,
            user_img,
            DATE_FORMAT(tbl_users.birthdate, '%b %d, %Y') as bday
            FROM tbl_users
            WHERE tbl_users.user_id = '$user_id'
        ");

       $userpets = PETS::SELECT('pet_id','pet_name','pet_img')->ORDERBY('pet_name')->WHERE('user_id',$user_id)->get();

       return view('admin/user-profile', compact('activeLink','userinfo','userpets'));

   }

   public function searchuser(Request $req) {

       $activeLink = 'petinfo';
       $keyword = $req['key'];

       $userlist = DB::TABLE('tbl_accounts')
       ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
       ->SELECT(
         'user_id',
         'firstname',
         'middlename',
         'lastname',
         'home_phone',
         'alt_phone',
         'address',
         'user_img'
         )
       ->WHERE('lastname','LIKE','%'.$keyword.'%')
       ->ORWHERE('firstname','LIKE','%'.$keyword.'%')
       ->ORDERBY('lastname')
       ->ANDWHERE('user_level','3')
       ->paginate(10);

       return view('admin/userinfo', compact('activeLink','userlist'));

   }

   public function viewaddparent() {

     $activeLink = 'userinfo';

     return view('admin/add-petparent', compact('activeLink'));

   }

   public function addparent(Request $req) {

     $username = $req['username'];

     if (!(ACCOUNTS::where('username', '=', $username)->exists())) {

       $users = new USERS;

       $pet_img = $req->file('profpic');
       if($pet_img !== null) {
         $input['profpic'] = time().'.'.$pet_img->getClientOriginalExtension();
         $destinationPath = public_path('/images/parents');
         $pet_img->move($destinationPath, $input['profpic']);
         $users->user_img = $input['profpic'];
       }

       $users->lastname = $req['lname'];
       $users->firstname = $req['fname'];
       $users->middlename = $req['mname'];
       $users->gender = $req['gender'];
       $users->email = $req['emailadd'];
       $users->birthdate = $req['bday'];
       $users->home_phone = $req['homephone'];
       $users->alt_phone = $req['altphone'];
       $users->address = $req['homeadd'];
       $users->occupation = $req['job'];
       $users->expectations = $req['hope'];
       $users->heard_of = $req['hear'];

       if($req['attended'] == null)
           $users->is_attended = "N";
       else
          $users->is_attended = $req['attended'];

       $usercount = DB::TABLE('tbl_users')->COUNT();
       $userid = $usercount+1;
       $users->user_id = $userid;

       $users->save();

       $accts = new ACCOUNTS;
       $accts->username = $req['username'];
       $accts->password = bcrypt($req['pass']);
       $accts->user_id = $userid;
       $accts->user_level = '3';
       $accts->save();

     }
      //Session::flash('success', ' Dog information has successfully added!');
      return redirect()->back()->with('success','A record has been added!');;

   }

}
?>
