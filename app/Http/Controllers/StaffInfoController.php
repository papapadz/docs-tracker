<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\PetInfoModel as PETS;
use App\BreedsModel as BREEDS;
use App\UsersModel as USERS;
use App\AccountModel as ACCOUNTS;
use App\TasksModel as TASKS;
use App\InventoryRequestsModel as INVENTORY;
use App\PetLogsModel as LOGS;
use App\DogBoardingModel as DOGBOARD;

class StaffInfoController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function staffinfo() {
       $activeLink = 'staffinfo';

       $stafflist = DB::TABLE('tbl_accounts')
       ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
       ->SELECT(
            'tbl_users.user_id',
            'nickname',
            'user_img',
            'home_phone',
            'address',
            'user_level'
        )
       ->WHERE('user_level','2')
       ->ORDERBY('nickname')
       ->paginate(10);

       return view('admin/staffinfo', compact('activeLink','stafflist'));
   }

   public function staffprofile($staff_id) {
       $activeLink = 'staffinfo';

       $staffinfo = DB::TABLE('tbl_accounts')
       ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
       ->SELECT(
            'tbl_accounts.user_id',
            'firstname',
            'middlename',
            'lastname',
            'nickname',
            'address',
            'home_phone',
            'gender',
            'user_img',
            DB::raw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) AS yrs_old'),
            DB::raw('DATE_FORMAT(birthdate, "%b %d, %Y") as bday')
        )
        ->WHERE('user_level','2')
        ->GET();

       return view('admin/staff-profile', compact('activeLink','staffinfo'));

   }

   public function searchstaff(Request $req) {

       $activeLink = 'petinfo';
       $keyword = $req['key'];

       $stafflist = DB::TABLE('tbl_accounts')
       ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
       ->SELECT(
         'user_img',
         'tbl_accounts.user_id',
         'nickname',
         'home_phone',
         'address'
         )
       ->WHERE('nickname','LIKE','%'.$keyword.'%')
       ->ORWHERE('lastname','LIKE','%'.$keyword.'%')
       ->ORWHERE('firstname','LIKE','%'.$keyword.'%')
       ->ORDERBY('nickname')
       ->ANDWHERE('user_level','2')
       ->paginate(10);

       return view('admin/staffinfo', compact('activeLink','stafflist'));

   }

   public function viewaddstaff() {

     $activeLink = 'staffinfo';

     return view('admin/add-staff', compact('activeLink'));

   }

   public function addstaff(Request $req) {

     $username = $req['username'];

     if (!(ACCOUNTS::where('username', '=', $username)->exists())) {

       $staffs = new USERS;

       $pet_img = $req->file('profpic');
       if($pet_img !== null) {
         $input['profpic'] = time().'.'.$pet_img->getClientOriginalExtension();
         $destinationPath = public_path('/images/staffs');
         $pet_img->move($destinationPath, $input['profpic']);
         $staffs->staff_img = $input['profpic'];
       }

       $staffs->lastname = $req['lname'];
       $staffs->firstname = $req['fname'];
       $staffs->middlename = $req['mname'];
       $staffs->nickname = $req['nname'];
       $staffs->gender = $req['gender'];
       $staffs->birthdate = $req['bday'];
       $staffs->home_phone = $req['phone'];
       $staffs->address = $req['homeadd'];
       $staffs->start_date = $req['empdate'];
       $staffs->emp_stat = $req['stat'];

       $usercount = DB::TABLE('tbl_users')->COUNT();
       $userid = $usercount+1;
       $staffs->user_id = $userid;

       $staffs->save();

       $accts = new ACCOUNTS;
       $accts->username = $req['username'];
       $accts->password = bcrypt($req['pass']);
       $accts->user_id = $userid;
       $accts->user_level = "2";
       $accts->save();

     }
      //Session::flash('success', ' Dog information has successfully added!');
      return redirect()->back()->with('success','Record added successfully!');

   }

   public function staffhome() {

     $staffinfo = DB::TABLE('tbl_accounts')
      ->JOIN('tbl_users','tbl_users.user_id','=','tbl_accounts.user_id')
      ->WHERE('tbl_users.user_id',Auth::user()->user_id)
      ->GET();

    $tasklist = TASKS::SELECT()
      ->ORDERBY('priority_lvl','DESC')
      ->ORDERBY('date','DESC')
      ->WHERE('status','0')
      ->GET();

    $petlist = PETS::SELECT('pet_id','pet_name')
      ->ORDERBY('pet_name')
      ->GET();

    return view('user/user-home', compact('staffinfo','tasklist','petlist'));

   }

   public function taskdone($task_id) {

     $t = TASKS::FIND($task_id);
     $t->status = '1';
     $t->save();

     return redirect()->back()->with('success','Task Marked as Done!');

   }

   public function addlog(Request $req) {

     $logs = new LOGS;

     $logs->task = $req['stafflog'];
     $logs->staff_id = Auth::user()->user_id;

     if($req['pet']!=null) {
       $logs->pet_id = $req['pet'];
       $pname = PETS::FIND($req['pet']);
       $logs->pet_name = $pname->pet_name;
     }

     $logs->save();

     return redirect()->back()->with('success','Your log has been recorded!');

   }

   public function viewmyinvreq() {

     $inventorylist = INVENTORY::SELECT()
       ->WHERE('requested_by','=', Auth::user()->user_id)
       ->ORDERBY('date','DESC')
       ->PAGINATE(10);

     return view('user/my-requests', compact('inventorylist'));
   }

   public function addinvreq(Request $req) {

     $invreq = new INVENTORY;

     $invreq->item = $req['item'];
     $invreq->requested_by = Auth::user()->user_id;
     $invreq->unit = $req['unit'];
     $invreq->daysleft = $req['daysleft'];
     $invreq->save();

     return redirect()->back()->with('success','Your request has been sent!');

   }

   public function searchreq(Request $req) {

     $cat = $req['category'];

     if($cat=='1') {
       $key = "item";
       $word = $req['catitem'];
     }
     else if($cat=='2') {
       $key = "date";
       $word = $req['catdate'];
     }
     else if($cat=='3') {
       $key = "requested_by";
       $word = $req['catreqby'];
     }
     else {
       $key = "status";
       $word = $req['catstat'];
     }

     $inventorylist = INVENTORY::SELECT()
       ->WHERE('requested_by','=', Auth::user()->user_id)
       ->WHERE($key,'LIKE','%'.$word.'%')
       ->ORDERBY('date','DESC')
       ->PAGINATE(10);

     return view('user/my-requests',compact('inventorylist'));
   }

   public function cancelreq($inventoryreq_id) {

     $invreq = INVENTORY::FIND($inventoryreq_id);
     $invreq->DELETE();

     return redirect()->back()->with('success','Your request has been cancelled!');
   }

   public function viewmylogs() {

     $petloglist = LOGS::SELECT()
       ->WHERE('staff_id','=', Auth::user()->user_id)
       ->ORDERBY('date','DESC')
       ->PAGINATE(10);

     return view('user/my-logs', compact('petloglist'));
   }

   public function searchlog(Request $req) {

     $petloglist = LOGS::SELECT()
       ->WHERE('staff_id','=', Auth::user()->user_id)
       ->WHERE('date','LIKE','%'.$req['catdate'].'%')
       ->ORDERBY('date','DESC')
       ->PAGINATE(10);

     return view('user/my-logs', compact('petloglist'));
   }

   public function viewpetsonboard() {

     $petlist = DB::TABLE('tbl_dogboardlist')
         ->JOIN('tbl_pets','tbl_pets.pet_id','=','tbl_dogboardlist.pet_id')
         ->SELECT(
              'tbl_pets.pet_id',
              'pet_name',
              'pet_img',
              'end_date'
              )
         ->WHERE('status','=','1')
         ->ORDERBY('pet_name')
         ->GET();

         return view('user/pets-onboard',compact('petlist'));
   }

}
