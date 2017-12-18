<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\PetInfoModel as PETS;
use App\BreedsModel as BREEDS;
use App\UsersModel as USERS;
use App\FeedingTimeModel as FEEDINGTIME;
use App\PrescriptionModel as PRESC;
use App\DogBoardingModel as DOGBOARD;
use Illuminate\Support\Facades\Storage as STORAGE;

class PetInfoController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

   public function selectbreed($breed_id) {

       $activeLink = 'petinfo';

       $petlist = DB::TABLE('tbl_pets')
           ->JOIN('tbl_users','tbl_pets.user_id','=','tbl_users.user_id')
           ->JOIN('tbl_breeds','tbl_pets.breed','=','tbl_breeds.breed_id')
           ->SELECT(
                'pet_id',
                'pet_name',
                'pet_img',
                'user_img',
                'tbl_pets.user_id',
                'tbl_pets.gender as gender',
                'breed_id',
                'tbl_breeds.breed AS breed',
                'color',
                'on_dogboard',
                DB::raw('TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old'),
                DB::raw('TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12  AS mos_old'),
                'firstname',
                'lastname'
            )
           ->WHERE('breed_id','=',$breed_id)
           ->ORDERBY('pet_name')
           ->paginate(10);

       return view('admin/petinfo', compact('activeLink','petlist'));

   }

   public function sortage() {

       $activeLink = 'petinfo';

       $petlist = DB::connection('mysql')->select("
            SELECT
            pet_id,
            pet_name,
            pet_img,
            user_img,
            tbl_pets.user_id,
            tbl_pets.gender AS gender,
            breed_id,
            tbl_breeds.breed AS breed,
            color,
            on_dogboard,
            TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old,
            TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12 AS mos_old,
            firstname,
            lastname
            FROM tbl_pets
            INNER JOIN tbl_users
            ON tbl_pets.user_id = tbl_users.user_id
            INNER JOIN tbl_breeds
            ON tbl_pets.breed = tbl_breeds.breed_id
            ORDER BY yrs_old DESC
        ");

       return view('admin/petinfo', compact('activeLink','petlist'));

   }

   public function petinfo() {
       $activeLink = 'petinfo';

       $petlist = DB::TABLE('tbl_pets')
           ->JOIN('tbl_users','tbl_pets.user_id','=','tbl_users.user_id')
           ->JOIN('tbl_breeds','tbl_pets.breed','=','tbl_breeds.breed_id')
           ->SELECT(
                'pet_id',
                'pet_name',
                'pet_img',
                'user_img',
                'tbl_pets.user_id',
                'tbl_pets.gender as gender',
                'breed_id',
                'tbl_breeds.breed AS breed',
                'color',
                'on_dogboard',
                DB::raw('TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old'),
                DB::raw('TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12  AS mos_old'),
                'firstname',
                'lastname'
            )
           ->ORDERBY('pet_name')
           ->paginate(10);

       return view('admin/petinfo', compact('activeLink','petlist'));
   }

   public function petprofile($pet_id) {
       $activeLink = 'petinfo';

       $petinfo = DB::connection('mysql')->select("
            SELECT
            pet_id,
            tbl_pets.user_id,
            user_img,
            pet_name,
            pet_img,
            tbl_pets.gender,
            tbl_breeds.breed AS breed,
            color,
            tbl_pets.description,
            reproductive_surgery AS rs,
            bug_prevention AS bp,
            on_vaccine AS vac,
            tbl_pets.description AS descr,
            w_collar AS collar,
            w_leash AS leash,
            w_tag AS tag,
            is_crated AS crate,
            is_runofhouse AS house,
            is_outdoors AS outdoors,
            limited_to,
            feeding_ins,
            food,
            is_sit,
            is_stay,
            is_come,
            is_down,
            walk_ins,
            favtoys,
            precautions,
            on_dogboard,
            additional_info AS addinfo,
            other_commands AS oc,
            firstname,
            lastname,
            TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old,
            DATE_FORMAT(tbl_pets.birthdate, '%b %d, %Y') as bday,
            TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12 AS mos_old
            FROM tbl_pets
            INNER JOIN tbl_users
            ON tbl_pets.user_id = tbl_users.user_id
            INNER JOIN tbl_breeds
            ON tbl_pets.breed = tbl_breeds.breed_id
            WHERE pet_id = '$pet_id'
        ");

       $feedingtime = DB::CONNECTION('mysql')->SELECT("
            SELECT DATE_FORMAT(time, '%I:%s %p') as t, food FROM tbl_feedingtime WHERE pet_id = '$pet_id' ORDER BY time
       ");

       $prescription = PRESC::SELECT('medicine','dosage')->WHERE('pet_id',$pet_id)->ORDERBY('medicine')->get();

       $board = DB::TABLE('tbl_dogboardlist')
        ->WHERE('pet_id','=',$pet_id)
        ->WHERE('status','=','1')
        ->GET();

       return view('admin/pet-profile', compact('activeLink','petinfo','feedingtime','prescription','board'));

   }

   public function viewaddpet() {
     $activeLink = 'petinfo';

     $breedlist = BREEDS::SELECT(
       'breed_id',
       'breed'
       )
       ->ORDERBY('breed')
       ->GET();

     $userslist = USERS::select(
       'user_id',
       'firstname',
       'middlename',
       'lastname'
       )
       ->orderBy('lastname')
       ->get();

       return view('admin/add-pet', compact('activeLink','breedlist','userslist'));
   }

    public function addpet(Request $req) {

        $pets = new PETS;

        $pet_img = $req->file('dogpic');
        if($pet_img !== null) {
          $input['dogpic'] = time().'.'.$pet_img->getClientOriginalExtension();
          $destinationPath = public_path('/images/pets');
          $pet_img->move($destinationPath, $input['dogpic']);
          $pets->pet_img = $input['dogpic'];
        }

        $surgery = $req['dogsurgery'];
        $vaccine = $req['dogvacc'];
        $ftprevention = $req['dogftprev'];
        $wcollar = $req['dogcollar'];
        $wleash = $req['dogleash'];
        $wtags = $req['dogtag'];
        $crated = $req['dogcrate'];
        $house = $req['dogrun'];
        $out = $req['dogout'];
        $sit = $req['dogsit'];
        $stay = $req['dogstay'];
        $come = $req['dogcome'];
        $down = $req['dogdown'];

        if($surgery == null)
            $surgery = 'N';
        if($vaccine == null)
            $vaccine = 'N';
        if($ftprevention == null)
            $ftprevention = 'N';
        if($wcollar == null)
            $wcollar = 'N';
        if($wleash == null)
            $wleash = 'N';
        if($wtags == null)
            $wtags = 'N';
        if($crated == null)
            $crated = 'N';
        if($house == null)
            $house = 'N';
        if($out == null)
            $out = 'N';
        if($sit == null)
            $sit = 'N';
        if($stay == null)
            $stay = 'N';
        if($come == null)
            $come = 'N';
        if($down == null)
            $down = 'N';

        $pets->pet_name = $req['dogname'];
        $pets->breed = $req['dogbreed'];
        $pets->birthdate = $req['dogbday'];
        $pets->color = $req['color'];
        $pets->user_id = $req['dogparent'];
        $pets->gender = $req['doggender'];
        $pets->reproductive_surgery = $surgery;
        $pets->bug_prevention = $ftprevention;
        $pets->on_vaccine = $vaccine;
        $pets->description = $req['dogdesc'];
        $pets->w_collar = $wcollar;
        $pets->w_leash = $wleash;
        $pets->w_tag = $wtags;
        $pets->is_crated = $crated;
        $pets->is_runofhouse = $house;
        $pets->is_outdoors = $out;
        $pets->limited_to = $req['doglimit'];
        $pets->favtoys = $req['dogfavtoy'];
        $pets->food = $req['dogfavfood'];
        $pets->feeding_ins = $req['dogfeedins'];
        $pets->is_sit = $sit;
        $pets->is_stay = $stay;
        $pets->is_come = $come;
        $pets->is_down = $down;
        $pets->other_commands = $req['dogothercomm'];
        $pets->walk_ins = $req['dogwalkins'];
        $pets->precautions = $req['dogprec'];
        $pets->additional_info = $req['dogotherinfo'];

        $petcount = DB::TABLE('tbl_pets')->COUNT();
        $petid = $petcount+1;
        $pets->pet_id = $petid;

        $pets->save();

        $i = 0;
        foreach ($req['dogfood'] as $dd) {
          $ftime = new FEEDINGTIME;
          $ftime->pet_id = $petid;
          $ftime->time = $req['dogftime'][$i];
          $ftime->food = $dd;
          $ftime->save();
          $i++;
        }

        $j = 0;
        foreach ($req['med'] as $dd) {
          $presc = new PRESC;
          $presc->pet_id = $petid;
          $presc->medicine = $dd;
          $presc->dosage = $req['dosage'][$i];
          $presc->save();
          $j++;
        }

       //Session::flash('success', ' Dog information has successfully added!');
       return redirect()->back()->with('success','Dog record has been added successfully!');

    }

    public function searchpet(Request $req) {

        $activeLink = 'petinfo';
        $keyword = $req['key'];

        $petlist = DB::TABLE('tbl_pets')
        ->JOIN('tbl_users','tbl_pets.user_id','=','tbl_users.user_id')
        ->JOIN('tbl_breeds','tbl_pets.breed','=','tbl_breeds.breed_id')
        ->SELECT(
          'pet_id',
          'pet_name',
          'pet_img',
          'user_img',
          'tbl_pets.user_id',
          'tbl_pets.gender as gender',
          'breed_id',
          'tbl_breeds.breed AS breed',
          'color',
          'on_dogboard',
          DB::raw('TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old'),
          DB::raw('TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12  AS mos_old'),
          'firstname',
          'lastname'
        )
        ->WHERE('pet_name','LIKE', '%'.$keyword.'%')
        ->ORDERBY('pet_name')
        ->paginate(10);

        return view('admin/petinfo', compact('activeLink','petlist'));
    }

    public function vieweditpetinfo($pet_id) {

      $petinfo = PETS::FIND($pet_id);

      $ftime = FEEDINGTIME::SELECT()
      ->WHERE('pet_id',$pet_id)
      ->GET();

      $meds = PRESC::SELECT()
      ->WHERE('pet_id',$pet_id)
      ->GET();

      $breedlist = BREEDS::SELECT(
        'breed_id',
        'breed'
        )
        ->ORDERBY('breed')
        ->GET();

      $userslist = USERS::select(
        'user_id',
        'firstname',
        'middlename',
        'lastname'
        )
        ->orderBy('lastname')
        ->get();

      return view('admin/edit-petinfo', compact('petinfo','ftime','meds','breedlist','userslist'));
    }

    public function editpetinfo(Request $req) {

      $pets = PETS::FIND($req['pid']);

      $pet_img = $req->file('dogpic');
      if($pet_img !== null) {
        $input['dogpic'] = time().'.'.$pet_img->getClientOriginalExtension();
        $destinationPath = public_path('/images/pets');
        STORAGE::DELETE($destinationPath.$req['pet_img']);
        $pet_img->move($destinationPath, $input['dogpic']);
        $pets->pet_img = $input['dogpic'];
      }

      $surgery = $req['dogsurgery'];
      $vaccine = $req['dogvacc'];
      $ftprevention = $req['dogftprev'];
      $wcollar = $req['dogcollar'];
      $wleash = $req['dogleash'];
      $wtags = $req['dogtag'];
      $crated = $req['dogcrate'];
      $house = $req['dogrun'];
      $out = $req['dogout'];
      $sit = $req['dogsit'];
      $stay = $req['dogstay'];
      $come = $req['dogcome'];
      $down = $req['dogdown'];

      if($surgery == null)
          $surgery = 'N';
      if($vaccine == null)
          $vaccine = 'N';
      if($ftprevention == null)
          $ftprevention = 'N';
      if($wcollar == null)
          $wcollar = 'N';
      if($wleash == null)
          $wleash = 'N';
      if($wtags == null)
          $wtags = 'N';
      if($crated == null)
          $crated = 'N';
      if($house == null)
          $house = 'N';
      if($out == null)
          $out = 'N';
      if($sit == null)
          $sit = 'N';
      if($stay == null)
          $stay = 'N';
      if($come == null)
          $come = 'N';
      if($down == null)
          $down = 'N';

      $pets->pet_name = $req['dogname'];
      $pets->breed = $req['dogbreed'];
      $pets->birthdate = $req['dogbday'];
      $pets->color = $req['color'];
      $pets->user_id = $req['dogparent'];
      $pets->gender = $req['doggender'];
      $pets->reproductive_surgery = $surgery;
      $pets->bug_prevention = $ftprevention;
      $pets->on_vaccine = $vaccine;
      $pets->description = $req['dogdesc'];
      $pets->w_collar = $wcollar;
      $pets->w_leash = $wleash;
      $pets->w_tag = $wtags;
      $pets->is_crated = $crated;
      $pets->is_runofhouse = $house;
      $pets->is_outdoors = $out;
      $pets->limited_to = $req['doglimit'];
      $pets->favtoys = $req['dogfavtoy'];
      $pets->food = $req['dogfavfood'];
      $pets->feeding_ins = $req['dogfeedins'];
      $pets->is_sit = $sit;
      $pets->is_stay = $stay;
      $pets->is_come = $come;
      $pets->is_down = $down;
      $pets->other_commands = $req['dogothercomm'];
      $pets->walk_ins = $req['dogwalkins'];
      $pets->precautions = $req['dogprec'];
      $pets->additional_info = $req['dogotherinfo'];

      $pets->save();

      if($req['todelete']) {

        foreach($req['todelete'] as $delft)
        DB::TABLE('tbl_feedingtime')
        ->WHERE('ft_id',$delft)
        ->DELETE();
      }

      if($req['dogfood']) {
        DB::TABLE('tbl_feedingtime')
        ->WHERE('pet_id',$req['pid'])
        ->DELETE();

        $i = 0;
        foreach ($req['dogfood'] as $dd) {
          $ftime = new FEEDINGTIME;
          $ftime->pet_id = $req['pid'];
          $ftime->time = $req['dogftime'][$i];
          $ftime->food = $dd;
          $ftime->save();
          $i++;
      }
    }

    if($req['todeletemed']) {

      foreach($req['todeletemed'] as $delmed)
      DB::TABLE('tbl_prescriptions')
      ->WHERE('prescription_id',$delmed)
      ->DELETE();
    }

    if($req['med']) {
      DB::TABLE('tbl_prescriptions')
      ->WHERE('pet_id',$req['pid'])
      ->DELETE();

      $i = 0;
      foreach ($req['med'] as $dd) {
        $presc = new PRESC;
        $presc->pet_id = $req['pid'];
        $presc->medicine = $dd;
        $presc->dosage = $req['dosage'][$i];
        $presc->save();
        $i++;
    }
  }

    return redirect()->back()->with('success','Record has been updated!');

    }

    public function viewsetdogboard($pet_id) {

      $petinfo = DB::TABLE('tbl_pets')
          ->JOIN('tbl_users','tbl_pets.user_id','=','tbl_users.user_id')
          ->JOIN('tbl_breeds','tbl_pets.breed','=','tbl_breeds.breed_id')
          ->SELECT(
               'pet_id',
               'pet_name',
               'pet_img',
               'user_img',
               'tbl_pets.user_id',
               'tbl_pets.gender as gender',
               'breed_id',
               'tbl_breeds.breed AS breed',
               'color',
               'on_dogboard',
               DB::raw('TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old'),
               DB::raw('TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12  AS mos_old'),
               'firstname',
               'lastname'
           )
          ->WHERE('pet_id','=',$pet_id)
          ->GET();

      $boardinfo = DB::TABLE('tbl_dogboardlist')
        ->SELECT()
        ->WHERE('pet_id','=',$pet_id)
        ->WHERE('status','=','1')
        ->GET();

      return view('admin/set-dogboard',compact('petinfo','boardinfo'));
    }

    public function setdogboard(Request $req) {

      if($req['is_onboard']=='Y') {

        $board = DOGBOARD::FIND($req['board_id']);
        $board->status = '0';
        $board->save();

        $pet = PETS::FIND($req['pet_id']);
        $pet->on_dogboard = 'N';
        $pet->save();

        $msg = 'Dog has been unenrolled on dog boarding';
      }else {

        $board = new DOGBOARD;
        $board->pet_id = $req['pet_id'];
        $board->start_date = $req['sdate'];
        $board->end_date = $req['edate'];
        $board->goal= $req['goal'];
        $board->save();

        $pet = PETS::FIND($req['pet_id']);
        $pet->on_dogboard = 'Y';
        $pet->save();

        $msg = 'Dog has been enrolled successfully';
      }

      return redirect()->back()->with('success',$msg);
    }

    public function viewpetprofile2($pet_id) {
      $petinfo = DB::connection('mysql')->select("
           SELECT
           pet_id,
           tbl_pets.user_id,
           user_img,
           pet_name,
           pet_img,
           tbl_pets.gender,
           tbl_breeds.breed AS breed,
           color,
           tbl_pets.description,
           reproductive_surgery AS rs,
           bug_prevention AS bp,
           on_vaccine AS vac,
           tbl_pets.description AS descr,
           w_collar AS collar,
           w_leash AS leash,
           w_tag AS tag,
           is_crated AS crate,
           is_runofhouse AS house,
           is_outdoors AS outdoors,
           limited_to,
           feeding_ins,
           food,
           is_sit,
           is_stay,
           is_come,
           is_down,
           walk_ins,
           favtoys,
           precautions,
           on_dogboard,
           additional_info AS addinfo,
           other_commands AS oc,
           firstname,
           lastname,
           TIMESTAMPDIFF(YEAR, tbl_pets.birthdate, CURDATE()) AS yrs_old,
           DATE_FORMAT(tbl_pets.birthdate, '%b %d, %Y') as bday,
           TIMESTAMPDIFF(MONTH, tbl_pets.birthdate, CURDATE()) % 12 AS mos_old
           FROM tbl_pets
           INNER JOIN tbl_users
           ON tbl_pets.user_id = tbl_users.user_id
           INNER JOIN tbl_breeds
           ON tbl_pets.breed = tbl_breeds.breed_id
           WHERE pet_id = '$pet_id'
       ");

      $feedingtime = DB::CONNECTION('mysql')->SELECT("
           SELECT DATE_FORMAT(time, '%I:%s %p') as t, food FROM tbl_feedingtime WHERE pet_id = '$pet_id' ORDER BY time
      ");

      $prescription = PRESC::SELECT('medicine','dosage')->WHERE('pet_id',$pet_id)->ORDERBY('medicine')->get();

      $board = DB::TABLE('tbl_dogboardlist')
       ->WHERE('pet_id','=',$pet_id)
       ->WHERE('status','=','1')
       ->GET();

      return view('user/pet-profile', compact('petinfo','feedingtime','prescription','board'));
    }

}
