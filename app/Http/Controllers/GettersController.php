<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use App\Http\Requests;
use App\IncomingModel as INDOCS;
use App\DocTypesModel as DOCTYPES;
use App\OriginsModel as ORIGS;
use App\CoursesModel as COURSE;
use App\ClientsModel as CLIENTS;
use App\AgencyTypeModel as AGENCY;
use App\UsersModel as USER;
use App\CompetencyAssessmentModel as CAC;
use App\ProgramRegistrationModel as PR;
use App\BillingModel as BILL;
use App\BillingTypesModel as BILLTYPES;
use App\ConcernedStaffModel as CONCERNS;
use App\SerialNumbersModel as SERIALS;
use App\User as ACCT;
use App\DVModel as DV;
use App\CheckModel as CHECK;
use App\PaymentModel as PAYMENT;
use DB;

class GettersController extends Controller
{

  public function getdoctypeinfo(Request $req) {

    $data = DOCTYPES::FIND($req['id']);

    echo $data;
  }

  public function getclienttypeinfo(Request $req) {

    $data = CLIENTS::FIND($req['id']);

    echo $data;
  }

  public function getcourseinfo(Request $req) {

    $data = COURSE::FIND($req['id']);

    echo $data;
  }

  public function getagencytypeinfo(Request $req) {

    $data = AGENCY::FIND($req['id']);

    echo $data;
  }

  public function getserialnuminfo(Request $req) {

    $data = SERIALS::FIND($req['id']);

    echo $data;

  }

  public static function getbillingtype($id) {

    $btype = BILLTYPES::FIND($id);
    $data = $btype->billing_type;

    return $data;
  }

  public static function getcheckdetails(Request $req) {

    $data = CHECK::WHERE('billing_id',$req['bid'])->WHERE('billing_type_id',$req['btid'])->FIRST();

    return $data;
  }

  public static function setbillstat($fid,$bid,$id) {

    $bill = BILL::FIND($id);

    switch ($bid) {
      case 1:
        $bill->tc_stat = $fid;
        break;
      case 2:
        $bill->af_stat = $fid;
        break;
      case 3:
        $bill->ef_stat = $fid;
        break;
      case 4:
        $bill->ba_stat = $fid;
        break;
      case 5:
        $bill->ta_stat = $fid;
        break;
      case 6:
        $bill->sfa_stat = $fid;
        break;
    }
    $bill->SAVE();
  }

  public static function getkeyword($i) {

    $keyword = '';

    switch ($i) {

      case 1:
        $keyword = 'tc';
        break;

      case 2:
        $keyword = 'af';
        break;

      case 3:
        $keyword = 'ef';
        break;

      case 4:
        $keyword = 'ba';
        break;

      case 5:
        $keyword = 'ta';
        break;

      case 6:
        $keyword = 'sfa';
        break;
    }

    return $keyword;
  }

  public static function updatedvdetails($req, $btid) {

    $keyword = GettersController::getkeyword($btid);

    $dv = DV::WHERE([
      ['billing_id',$req['billid']],
      ['billing_type_id',$btid]
    ])->FIRST();

    $dv->dv_num = $req[$keyword.'_dv'];
    $dv->dv_date = $req[$keyword.'_dv_date'];
    $dv->obr_num = $req[$keyword.'_obr'];
    $dv->obr_date = $req[$keyword.'_obr_date'];
    $dv->serial_num = $req[$keyword.'_serial'];
    $dv->payee = $req[$keyword.'_payee'];
    $dv->gross = $req[$keyword.'_gross'];
    $dv->tax = $req[$keyword.'_tax'];
    $dv->net = $req[$keyword.'_net'];
    $dv->SAVE();
  }

  public static function updatecheckdetails($req, $btid) {

    $keyword = GettersController::getkeyword($btid);

    $check = CHECK::WHERE([
      ['billing_id',$req['billid']],
      ['billing_type_id',$btid]
    ])->FIRST();

    $check->check_num = $req[$keyword.'_check_num'];
    $check->check_name = $req[$keyword.'_check_name'];
    $check->check_amt = $req[$keyword.'_check_amt'];
    $check->check_date = $req[$keyword.'_check_date'];
    $check->SAVE();
  }

  public static function updatepaymentdetails($req, $btid) {

    $keyword = GettersController::getkeyword($btid);

    $payment = PAYMENT::WHERE([
      ['billing_id',$req['billid']],
      ['billing_type_id',$btid]
    ])->FIRST();

    $payment->or_num = $req[$keyword.'_or'];
    $payment->released_to = $req[$keyword.'_released_to'];
    $payment->release_date = $req[$keyword.'_release_date'];
    $payment->SAVE();
  }

  public static function getdv($bid,$btid) {

    $dv = DV::WHERE([
      ['billing_id',$bid],
      ['billing_type_id',$btid]
    ])->FIRST();

    return $dv;
  }

  public static function getcheck($bid,$btid) {

    $check = CHECK::WHERE([
      ['billing_id',$bid],
      ['billing_type_id',$btid]
    ])->FIRST();

    return $check;
  }

  public static function getpayment($bid,$btid) {

    $payment = PAYMENT::WHERE([
      ['billing_id',$bid],
      ['billing_type_id',$btid]
    ])->FIRST();

    return $payment;
  }

  public static function checkduplicate(Request $req) {

    $doc = INDOCS::WHERE([
      ['doc_type_id',$req['doc_type_id']],
      ['origin_id',$req['origin_id']],
      ['doc_date',$req['doc_date']],
      ['signatory',$req['signatory']],
      ['subject',$req['subject']],
      ['is_archived',0]
    ])->FIRST();

    if($doc)
      return $doc->doc_id;
    else
      return 0;
  }

}
