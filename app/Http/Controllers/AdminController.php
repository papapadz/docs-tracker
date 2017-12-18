<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Http\Requests;
use DB;
use App\PetInfoModel as PETS;
use App\TasksModel as TASKS;
use App\InventoryRequestsModel as INVENTORY;
use App\PetLogsModel as LOGS;
use App\User as ACCOUNTS;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function redirectview() {

      if(Auth::user()->user_level == '1') {
          return redirect('admin/home');
      } else if(Auth::user()->user_level == '2') {
        return redirect('user/user-home');
      }

    }

    public function searchtask(Request $req) {

      $cat = $req['category'];

      if($cat=='1') {
        $key = "task_title";
        $word = $req['cattask'];
      }
      else if($cat=='2') {
        $key = "date";
        $word = $req['catdate'];
      }
      else {
        $key = "status";
        $word = $req['catstat'];
      }

      $tasklist = TASKS::SELECT()
          ->WHERE($key,'LIKE','%'.$word.'%')
          ->ORDERBY('priority_lvl','DESC')
          ->ORDERBY('date','DESC')
          ->PAGINATE(10);

      return view('admin/home',compact('tasklist'));
    }

    public function viewaddtask() {

       return view('admin/add-task');
    }

    public function addtask(Request $req) {

       $tasks = new TASKS;

       $tasks->task_title = $req['task_title'];
       $tasks->task_content = $req['instructions'];
       $tasks->priority_lvl = $req['priority'];
       $tasks->save();

       $tasklist = TASKS::SELECT()
         ->ORDERBY('priority_lvl','DESC')
         ->ORDERBY('date','DESC')
         ->PAGINATE(10);

       return redirect()->back()->with('success','Record added successfully!');
    }

    public function viewedittask($task_id) {

      $task = TASKS::SELECT()
        ->WHERE('task_id',$task_id)
        ->GET();

      return view('admin/edit-task',compact('task'));
    }

    public function edittask(Request $req,$task_id) {

      $task = TASKS::FIND($task_id);

      $task->task_title = $req['task_title'];
      $task->task_content = $req['instructions'];
      $task->priority_lvl = $req['priority'];

      $task->save();

      return redirect()->back()->with('success','Record has been updated!');
    }

    public function deletetask($task_id) {

      $task = TASKS::FIND($task_id);

      $task->DELETE();

      return redirect()->back()->with('success','Record has been deleted!');
    }

    public function viewmenu() {

      if(Auth::user()->user_level == 2) {
        return redirect('user/user-home');
      }

      $tasklist = TASKS::SELECT()
        ->ORDERBY('priority_lvl','DESC')
        ->ORDERBY('date','DESC')
        ->PAGINATE(10);

      $stafflist = DB::TABLE('tbl_accounts')
        ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
        ->SELECT('nickname')
        ->WHERE('user_level','2')
        ->ORDERBY('nickname')
        ->GET();

      //$myuser = ACCOUNTS::FIND(Auth::user()->account_id)->GET();

      return view('admin/home',compact('stafflist','tasklist'));
    }

    public function viewinventoryreq() {

      $inventorylist = INVENTORY::SELECT()
        ->JOIN('tbl_users','user_id','=','requested_by')
        ->ORDERBY('date','DESC')
        ->PAGINATE(10);

      $stafflist = DB::TABLE('tbl_accounts')
        ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
        ->SELECT('tbl_accounts.user_id','nickname')
        ->WHERE('user_level','2')
        ->ORDERBY('nickname')
        ->GET();

      return view('admin/inventory-requests',compact('inventorylist','stafflist'));
    }

    public function searchinventoryreq(Request $req) {

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
        ->JOIN('tbl_staffs','staff_id','=','requested_by')
        ->WHERE($key,'LIKE','%'.$word.'%')
        ->ORDERBY('date','DESC')
        ->PAGINATE(10);

      $stafflist = DB::TABLE('tbl_accounts')
        ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
        ->SELECT('tbl_accounts.user_id','nickname')
        ->WHERE('user_level','2')
        ->ORDERBY('nickname')
        ->GET();

      return view('admin/inventory-requests',compact('inventorylist','stafflist'));

    }

    public function approveinventoryreq($inventoryreq_id) {

      $invreq = INVENTORY::FIND($inventoryreq_id);

      $invreq->status = '1';

      $invreq->save();

      return redirect()->back()->with('success','Item has been approved!');
    }

    public function disapproveinventoryreq($inventoryreq_id) {

      $invreq = INVENTORY::FIND($inventoryreq_id);

      $invreq->status = '2';

      $invreq->save();

      return redirect()->back()->with('disapproved','Item has been disapproved!');
    }


    public function viewstafflogs() {

      $petloglist = DB::TABLE('tbl_petlogs')
        ->JOIN('tbl_users','tbl_users.user_id','=','tbl_petlogs.staff_id')
        ->SELECT()
        ->ORDERBY('date','DESC')
        ->PAGINATE(10);

      $stafflist = DB::TABLE('tbl_accounts')
        ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
        ->SELECT('tbl_accounts.user_id','nickname')
        ->WHERE('user_level','2')
        ->ORDERBY('nickname')
        ->GET();

      return view('admin/staff-logs',compact('petloglist','stafflist'));
    }

    public function searchstafflogs(Request $req) {

      $cat = $req['category'];

      if($cat=='1') {
        $key = "date";
        $word = $req['catdate'];
      }
      else {
        $key = "tbl_users.user_id";
        $word = $req['catreqby'];
      }

      $petloglist = DB::TABLE('tbl_petlogs')
        ->JOIN('tbl_users','tbl_users.user_id','=','tbl_petlogs.staff_id')
        ->SELECT()
        ->WHERE($key,'LIKE','%'.$word.'%')
        ->ORDERBY('date','DESC')
        ->PAGINATE(10);

      $stafflist = DB::TABLE('tbl_accounts')
        ->JOIN('tbl_users','tbl_accounts.user_id','=','tbl_users.user_id')
        ->SELECT()
        ->WHERE('user_level','2')
        ->ORDERBY('nickname')
        ->GET();

      return view('admin/staff-logs',compact('petloglist','stafflist'));
    }

    public function dogsonboard() {

      $petlist = DB::TABLE('tbl_pets')
          ->JOIN('tbl_users','tbl_pets.user_id','=','tbl_users.user_id')
          ->JOIN('tbl_breeds','tbl_pets.breed','=','tbl_breeds.breed_id')
          ->SELECT(
               'pet_id',
               'pet_name',
               'pet_img',
               'tbl_breeds.breed_id',
               'tbl_breeds.breed'
               )
          ->WHERE('on_dogboard','=','Y')
          ->ORDERBY('pet_name')
          ->GET();

          return view('admin/dogs-onboard',compact('petlist'));
    }

    public function staffonduty() {
      $stafflist = DB::TABLE('tbl_staffsched')
        ->JOIN('tbl_users','tbl_users.user_id','=','tbl_staffsched.user_id')
        ->SELECT('tbl_users.user_id', 'nickname','time_in','time_out','user_img')
        ->WHEREDATE('date','=',Carbon::today()->toDateString())
        ->ORDERBY('time_in')
        ->GET();

     return view('admin/staff-onduty',compact('stafflist'));
    }

    public function taskundone($task_id) {

      $t = TASKS::FIND($task_id);

      $t->status = '0';

      $t->save();

      return redirect()->back();

    }
}
?>
