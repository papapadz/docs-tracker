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
use App\SerialNumbersModel as SERIALS;
use App\ClientsModel as CLIENTS;
use App\AgencyTypeModel as AGENCY;
use App\UsersModel as USER;
use App\CompetencyAssessmentModel as CAC;
use App\ProgramRegistrationModel as PR;
use App\BillingModel as BILL;
use App\DVModel as DV;
use App\CheckModel as CHECK;
use App\PaymentModel as PAYMENT;
use App\ConcernedStaffModel as CONCERNS;
use App\User as ACCT;
use App\AssessorsModel as ASSESSOR;
use App\LogModel as LOG;
use DB;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

     public function logout() {

      Session::flush();

      return redirect()->back();
    }

    static function countnoremarks() {

        $norem = INDOCS::WHERE('status',0)->WHERE('is_archived',0)->GET()->COUNT();

        if($norem>0)
          Session::set('norem',$norem);
        else
          Session::forget('norem');
    }

    static function countnoaction() {

      $noaction = INDOCS::SELECT()
        ->JOIN('tbl_concerned_staff','tbl_concerned_staff.incoming_id','=','tbl_incoming.doc_id')
        ->WHERE('status',1)
        ->WHERE('user_id',Auth::User()->user_id)
        ->WHERE('is_archived',0)
        ->GET()
        ->COUNT();

        if($noaction>0)
          Session::set('noact',$noaction);
        else
          Session::forget('noact',$noaction);
    }

    public function viewmenu() {

      $ulvl = Auth::User()->user_level;
      $data = USER::FIND(Auth::User()->user_id);

      Session::set('fname', $data['firstname']);
      Session::set('lname', $data['lastname']);

      if($ulvl==1)
        Session::set('utype','ADMINISTRATOR:');
      else if($ulvl==2)
        Session::set('utype','USER:');
      else
        Session::set('utype','RECEIVING:');

      if($ulvl==1 || $ulvl==3) {

        if($ulvl==3)
          MainController::countnoaction();

        MainController::countnoremarks();

        $activelink = 'home';

        $docs = INDOCS::SELECT(
            'doc_id',
            'doc_ctrl_num',
            'tbl_incoming.origin_id',
            'subject',
            'tbl_incoming.origin_id',
            'origin_name',
            'doc_type_id',
            'doc_type',
            'status',
            'tbl_incoming.created_at'
            )
            ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
            ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
            ->WHERE('is_archived',0)
            ->ORDERBY('tbl_incoming.created_at','DESC')
            ->GET();
        $types = DOCTYPES::ORDERBY('doc_type')->GET();
        return view('master/home', compact('activelink','docs','types'));

      }else {

        MainController::countnoaction();

        $activelink = 'mydocs';

        $docs = CONCERNS::SELECT('*',DB::RAW('tbl_incoming.created_at as doc_received'),DB::RAW('tbl_concerned_staff.created_at as doc_endorsed'))
          ->JOIN('tbl_incoming','tbl_incoming.doc_id','=','tbl_concerned_staff.incoming_id')
          ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
          ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
          ->WHERE('is_archived',0)
          ->WHERE('tbl_concerned_staff.user_id',Auth::user()->user_id)
          ->GET();

        return view('user/remarked-docs', compact('activelink','docs'));
      }

    }

    public function viewnewdoc($type_id) {

      $activelink = 'home';

      $courses = COURSE::ORDERBY('course')->GET();
      $agency = AGENCY::WHERE('agency_type_id',5)
        ->ORWHERE('agency_type_id',6)
        ->ORDERBY('agency_type')
        ->GET();

        if($type_id==9) {

          $origins = ORIGS::WHERE('type',5)
            ->ORDERBY('origin_name')
            ->GET();

        } else
          $origins = ORIGS::ORDERBY('origin_name')->GET();

        $clients = CLIENTS::ORDERBY('client_type_id')->GET();
        $user = ASSESSOR::ORDERBY('lastname')->WHEREDATE('expiry_date','>',Carbon::now())->GET();

        return view('receiving/newdocs', compact('activelink','origins','courses','clients','user','type_id','agency'));
    }

    public function addnewdoc(Request $req) {

        $activelink = 'home';

        $dtype = $req['doctype'];

        $newdoc = new INDOCS;

        $newdoc->origin_id = $req['origin'];
        $newdoc->doc_date = $req['datedoc'];
        $newdoc->doc_ctrl_num = $req['ctrlnum'];
        $newdoc->doc_type_id = $dtype;
        $newdoc->doc_date_issued = $req['dateissued'];
        $newdoc->subject = $req['subject'];
        $newdoc->signatory = $req['signatory'];
        $newdoc->action_taken = $req['actiontaken'];
        $newdoc->received_by = Auth::User()->user_id;
        $newdoc->SAVE();

        $incdoc_id = INDOCS::ORDERBY('created_at','DESC')->FIRST();

        $scan = $req->file('fileupload');

        if($scan !== null) {
          $input['file'] = $incdoc_id->doc_id.'.'.$scan->getClientOriginalExtension();
          $destinationPath = public_path('/files');
          $scan->move($destinationPath, $input['file']);

          $savetodocs = INDOCS::FIND($incdoc_id->doc_id);
          $savetodocs->doc_file = $input['file'];
          $savetodocs->SAVE();
        }

        switch($dtype) {
          case 6:
            $cac = new CAC;
            $cac->incoming_id = $incdoc_id->doc_id;
            $cac->course_id = $req['course'];
            $cac->assessor_id = $req['assessor'];
            $cac->num_candidates = $req['numclients'];
            $cac->client_type = $req['clienttype'];
            $cac->assessment_date = $req['dateassess'];
            $cac->start_date = $req['datestart'];
            $cac->end_date = $req['dateend'];
            $cac->SAVE();
            break;

          case 7:
            $pr = new PR;
            $pr->incoming_id = $incdoc_id->doc_id;
            $pr->course_id = $req['course'];
            $pr->SAVE();
            break;

          case 8:
            $bill = new BILL;
            $bill->incoming_id = $incdoc_id->doc_id;
            $bill->scholarship_details = $req['sgdetails'];
            $bill->client_type_id = $req['clienttype'];
            $bill->course_id = $req['course'];
            $bill->bill_amt = $req['amt'];
            $bill->numpax = $req['numpax'];
            $bill->date_start = $req['start'];
            $bill->date_end = $req['end'];
            $bill->assessment_date = $req['ass_date'];
            $bill->SAVE();
            break;

        }

        $log = NEW LOG;
        $log->incoming_id = $incdoc_id->doc_id;
        $log->action_taken = "Logged a new Incoming Document";
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
        /*
        $docs = INDOCS::SELECT(
          'doc_id',
          'tbl_incoming.origin_id',
          'subject',
          'tbl_incoming.origin_id',
          'origin_name',
          'doc_type_id',
          'doc_type',
          'status',
          'tbl_incoming.created_at'
          )
          ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
          ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
          ->WHERE('is_archived',0)
          ->ORDERBY('tbl_incoming.created_at','DESC')
          ->GET();
        $types = DOCTYPES::ORDERBY('doc_type')->GET();

        MainController::countnoremarks();

        Session::flash('success','Incoming document has been recorded!');
        return view('master/home', compact('activelink','docs','types'));
        */
        return redirect()->route('view.home')->with('success','Incoming document has been recorded!');
    }

    public function viewdocinfo($doc_id) {

      $activelink = 'home';

      $origins = ORIGS::ORDERBY('origin_name')->GET();
      $staff = USER::ORDERBY('lastname')->GET();
      $courses = COURSE::ORDERBY('course')->GET();
      $client = CLIENTS::SELECT()->GET();
      $doctypes = DOCTYPES::SELECT()->GET();
      $endorsedto = CONCERNS::ORDERBY('lastname')->JOIN('tbl_users','tbl_users.user_id','=','tbl_concerned_staff.user_id')->WHERE('incoming_id',$doc_id)->GET();

      $incdoc = INDOCS::SELECT()
        ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
          ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
        ->WHERE('doc_id',$doc_id)
        ->FIRST();

      $type = $incdoc->doc_type_id;

      switch ($type) {

        case 6:
          $incdoc = INDOCS::SELECT()
            ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
            ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
            ->JOIN('tbl_competency_assessment_certification','tbl_competency_assessment_certification.incoming_id','=','tbl_incoming.doc_id')
            ->JOIN('tbl_courses','tbl_courses.course_id','=','tbl_competency_assessment_certification.course_id')
            ->JOIN('tbl_assessors','tbl_assessors.assessor_id','=','tbl_competency_assessment_certification.assessor_id')
            ->WHERE('doc_id',$doc_id)
            ->FIRST();

            $assessor = ASSESSOR::ORDERBY('lastname')->GET();

            return view('user/viewcac', compact('activelink','incdoc','origins','staff','assessor','endorsedto','courses','client','doctypes'));
          break;

        case 7:
          $incdoc = INDOCS::SELECT()
            ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
            ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
            ->JOIN('tbl_program_registration','tbl_program_registration.incoming_id','=','tbl_incoming.doc_id')
            ->JOIN('tbl_courses','tbl_courses.course_id','=','tbl_program_registration.course_id')
            ->WHERE('doc_id',$doc_id)
            ->FIRST();
            return view('user/viewpr', compact('activelink','incdoc','origins','staff','endorsedto','courses','client','doctypes'));
          break;

        case 8:
          $incdoc = INDOCS::SELECT('*',DB::RAW('tbl_billing.billing_id as b_id'))
            ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
            ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
            ->JOIN('tbl_billing','tbl_billing.incoming_id','=','tbl_incoming.doc_id')
            ->JOIN('tbl_courses','tbl_courses.course_id','=','tbl_billing.course_id')
            ->JOIN('tbl_client_types','tbl_client_types.client_type_id','=','tbl_billing.client_type_id')
            //->LEFTJOIN('tbl_billing_dv','tbl_billing_dv.billing_id','=','tbl_billing.billing_id')
            //->LEFTJOIN('tbl_billing_check','tbl_billing_check.billing_id','=','tbl_billing.billing_id')
            //->LEFTJOIN('tbl_billing_payment','tbl_billing_payment.billing_id','=','tbl_billing.billing_id')
            ->WHERE('doc_id',$doc_id)
            ->FIRST();

            $trainingcost_dv = GettersController::getdv($incdoc->b_id,1);
            $trainingcost_check = GettersController::getcheck($incdoc->b_id,1);
            $trainingcost_payment = GettersController::getpayment($incdoc->b_id,1);

            $assessmentfee_dv = GettersController::getdv($incdoc->b_id,2);
            $assessmentfee_check = GettersController::getcheck($incdoc->b_id,2);
            $assessmentfee_payment = GettersController::getpayment($incdoc->b_id,2);

            $entrepfee_dv = GettersController::getdv($incdoc->b_id,3);
            $entrepfee_check = GettersController::getcheck($incdoc->b_id,3);
            $entrepfee_payment = GettersController::getpayment($incdoc->b_id,3);

            $bookallowance_dv = GettersController::getdv($incdoc->b_id,4);
            $bookallowance_check = GettersController::getcheck($incdoc->b_id,4);
            $bookallowance_payment = GettersController::getpayment($incdoc->b_id,4);

            $trainingallowance_dv = GettersController::getdv($incdoc->b_id,5);
            $trainingallowance_check = GettersController::getcheck($incdoc->b_id,5);
            $trainingallowance_payment = GettersController::getpayment($incdoc->b_id,5);

            $studentfinasst_dv = GettersController::getdv($incdoc->b_id,6);
            $studentfinasst_check = GettersController::getcheck($incdoc->b_id,6);
            $studentfinasst_payment = GettersController::getpayment($incdoc->b_id,6);

            return view('user/viewbill', compact(
              'activelink','incdoc','origins','staff','courses','endorsedto','client','doctypes',
              'trainingcost_dv','trainingcost_check','trainingcost_payment',
              'assessmentfee_dv','assessmentfee_check','assessmentfee_payment',
              'entrepfee_dv','entrepfee_check','entrepfee_payment',
              'bookallowance_dv','bookallowance_check','bookallowance_payment',
              'trainingallowance_dv','trainingallowance_check','trainingallowance_payment',
              'studentfinasst_dv','studentfinasst_check','studentfinasst_payment'
            ));
        break;
      }

      return view('master/docinfo', compact('activelink','incdoc','origins','staff','endorsedto','courses','client','doctypes'));

    }

    public function viewpdf($doc_id) {

      $activelink = 'home';

      $did = $doc_id;
      return view('master/viewpdf', compact('activelink','did'));
    }

    public function setremarks(Request $req) {

      $did = $req['inc_id'];
      $incdoc = INDOCS::FIND($did);
      $incdoc->remarks = $req['remarks'];
      $incdoc->status = 1;
      $incdoc->SAVE();

      $i = 0;
      foreach($req['staffconcerned'] as $st) {
        $con = new CONCERNS;
        $con->incoming_id = $did;
        $con->user_id = $req['staffconcerned'][$i];
        $con->SAVE();
        $i++;
      }

      $log = NEW LOG;
      $log->incoming_id = $did;
      $log->action_taken = "Set remarks on the document and endorsed to concerned staff";
      $log->user_id = Auth::User()->user_id;
      $log->SAVE();

      MainController::countnoremarks();

      return redirect()->back();
    }

    public function viewendorsed() {

      MainController::countnoaction();

      $activelink = 'mydocs';

      $docs = CONCERNS::SELECT('*',DB::RAW('tbl_incoming.created_at as doc_received'),DB::RAW('tbl_concerned_staff.created_at as doc_endorsed'))
        ->JOIN('tbl_incoming','tbl_incoming.doc_id','=','tbl_concerned_staff.incoming_id')
        ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
        ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
        ->WHERE('is_archived',0)
        ->WHERE('tbl_concerned_staff.user_id',Auth::user()->user_id)
        ->GET();

      return view('user/remarked-docs', compact('activelink','docs'));
    }

    public function markdonedoc($doc_id) {

      $doc = INDOCS::FIND($doc_id);
      $doc->status = 2;
      $doc->SAVE();

      $log = NEW LOG;
      $log->incoming_id = $doc_id;
      $log->action_taken = "Marked the document as Done";
      $log->user_id = Auth::User()->user_id;
      $log->SAVE();

      return redirect()->back()->with('success','success');
    }

    public function markundonedoc($doc_id) {

      $doc = INDOCS::FIND($doc_id);
      $doc->status = 1;
      $doc->SAVE();

      $log = NEW LOG;
      $log->incoming_id = $doc_id;
      $log->action_taken = "Marked the document as Undone";
      $log->user_id = Auth::User()->user_id;
      $log->SAVE();

      return redirect()->back()->with('success','success');
    }

    public function updatepr(Request $req) {

      $dtype = $req['datetype'];
      $thisdate = Carbon::parse($req['dateset'])->toDateString();

      $pr = PR::FIND($req['prid']);

      switch ($dtype) {

        case 1:
          $pr->orientation_date = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 2;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Conducted the Orientation";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;

        case 2:
          $pr->occular_start_date = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 3;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Started the Occular Inspection";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;

        case 3:
          $pr->occular_end_date = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 4;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Finished the Occular Inspection";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;

        case 4:
          $pr->recommendation_date = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 5;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Forwared the Recommendation to Regional Office";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;

        case 5:
          $pr->recommendation_date_received = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 6;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Received the Recommendation from Regional Office";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;

        case 6:
          $pr->ctpr_num = $req['ctprnum'];
          $pr->num_days = $req['numdays'];
          $pr->ctpr_date_issued = $thisdate;
          $pr->SAVE();

          $incdoc = INDOCS::FIND($req['did']);
          $incdoc->status = 7;
          $incdoc->SAVE();

          $log = NEW LOG;
          $log->incoming_id = $req['did'];
          $log->action_taken = "Issued CTPR Number";
          $log->user_id = Auth::User()->user_id;
          $log->SAVE();
          break;
      }

    }

    public function updatecac(Request $req) {

      $type = $req['savetype'];
      $id = $req['cacid'];

      $cac = CAC::FIND($id);

      if($type==1) {

        $cac->assessment_result = $req['result'];
        $cac->SAVE();

        $incdoc = INDOCS::FIND($req['did']);
        $incdoc->status = 2;
        $incdoc->SAVE();

        $log = NEW LOG;
        $log->incoming_id = $req['did'];
        $log->action_taken = "Posted the Assessment Result";
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
      } else {
        $cac->docs_submission_date = $req['dateset'];
        $cac->SAVE();

        $incdoc = INDOCS::FIND($req['did']);
        $incdoc->status = 3;
        $incdoc->SAVE();

        $log = NEW LOG;
        $log->incoming_id = $req['did'];
        $log->action_taken = "Received RWAC and other supporting documents";
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
      }

    }

    public function updatebill(Request $req) {

      $type = $req['savetype'];
      $id = $req['billid'];
      $billingtype = GettersController::getbillingtype($req['billtype']);
      //$bill = BILL::FIND($id);

      GettersController::setbillstat($req['feetype'],$req['billtype'],$id);

      if($type==1) {

        $dv = NEW DV;
        $dv->dv_num = $req['dvnum'];
        $dv->dv_date = $req['dvdate'];
        $dv->obr_num = $req['obrnum'];
        $dv->obr_date = $req['obrdate'];
        $dv->serial_num = $req['serial'];
        $dv->payee = $req['payee'];
        $dv->gross = $req['gross'];
        $dv->tax = $req['tax'];
        $dv->net = $req['net'];
        $dv->billing_id = $id;
        $dv->billing_type_id = $req['billtype'];
        $dv->SAVE();

        $incdoc = INDOCS::FIND($req['did']);
        $incdoc->status = '2'.$req['billtype'];
        $incdoc->SAVE();

        $log = NEW LOG;
        $log->incoming_id = $req['did'];
        $log->action_taken = "Prepared the DV and OBR numbers for the ".$billingtype;
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
      } else if($type==2) {

        $check = NEW CHECK;
        $check->check_num = $req['checknum'];
        $check->check_name = $req['checkname'];
        $check->check_amt = $req['checkamt'];
        $check->check_date = $req['checkdate'];
        $check->billing_id = $id;
        $check->billing_type_id = $req['billtype'];
        $check->SAVE();

        $incdoc = INDOCS::FIND($req['did']);
        $incdoc->status = '3'.$req['billtype'];
        $incdoc->SAVE();

        $log = NEW LOG;
        $log->incoming_id = $req['did'];
        $log->action_taken = "Prepared the Check for the ".$billingtype;
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
      } else {

        $payment = NEW PAYMENT;
        $payment->released_to = $req['releasedto'];
        $payment->or_num = $req['ornum'];
        $payment->release_date = Carbon::now();
        $payment->released_by = Auth::User()->user_id;
        $payment->billing_id = $id;
        $payment->billing_type_id = $req['billtype'];
        $payment->SAVE();

        $incdoc = INDOCS::FIND($req['did']);
        $incdoc->status = '4'.$req['billtype'];
        $incdoc->SAVE();

        $log = NEW LOG;
        $log->incoming_id = $req['did'];
        $log->action_taken = "Released the Payment for the ".$billingtype;
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();
      }

    }

    public function updateall(Request $req) {

      $type = $req['doc_type'];
      $did = $req['inc_id'];

      $incdoc = INDOCS::FIND($did);
      $incdoc->origin_id = $req['origin'];
      $incdoc->doc_date = $req['doc_date'];
      $incdoc->doc_ctrl_num = $req['doc_ctrl_num'];
      $incdoc->doc_type_id = $type;
      $incdoc->doc_date_issued = $req['doc_date_issued'];
      $incdoc->subject = $req['subject'];
      $incdoc->signatory = $req['signatory'];
      $incdoc->action_taken = $req['action_taken'];
      $incdoc->remarks = $req['savedremarks'];
      $incdoc->SAVE();

      if($req['removestaffconcerned']!=null){

        $i = 0;
        foreach($req['removestaffconcerned'] as $st) {

          $con = CONCERNS::WHERE('incoming_id',$did)->WHERE('user_id',$req['removestaffconcerned'][$i])->FIRST();
          $con->DELETE();
          $i++;
        }
      }

      $scan = $req->file('fileupload');

			if($scan !== null) {
				$input['file'] = $did.'.'.$scan->getClientOriginalExtension();
				$destinationPath = public_path('/files');
				$scan->move($destinationPath, $input['file']);

				$saveto = INDOCS::FIND($did);
				$saveto->doc_file = $input['file'];
				$saveto->SAVE();
			}

      switch($type) {
        case 6:
          $cac = CAC::FIND($req['cacid']);
          $cac->course_id = $req['course'];
          $cac->assessor_id = $req['assessor'];
          $cac->num_candidates = $req['numclients'];
          $cac->client_type = $req['clienttype'];
          $cac->start_date = $req['datestart'];
          $cac->end_date = $req['dateend'];
          $cac->assessment_result = $req['assresult'];
          $cac->docs_submission_date = $req['rwacsubmit'];
          $cac->SAVE();
          break;

        case 7:
          $pr = PR::FIND($req['prid']);
          $pr->course_id = $req['course'];
          $pr->orientation_date = $req['orientation_date'];
          $pr->occular_start_date = $req['occular_start_date'];
          $pr->occular_end_date = $req['occular_end_date'];
          $pr->recommendation_date = $req['recommendation_date'];
          $pr->recommendation_date_received = $req['recommendation_date_received'];
          $pr->ctpr_num = $req['ctpr_num'];
          $pr->ctpr_date_issued = $req['ctpr_date_issued'];
          $pr->SAVE();
          break;

        case 8:
          $bill = BILL::FIND($req['billid']);
          $bill->scholarship_details = $req['sgdetails'];
          $bill->client_type_id = $req['clienttype'];
          $bill->course_id = $req['course'];
          $bill->bill_amt = $req['amt'];
          $bill->numpax = $req['numpax'];
          $bill->date_start = $req['start_assessment'];
          $bill->date_end = $req['end_assessment'];
          $bill->assessment_date = $req['assessment_date'];
          $bill->SAVE();
          //$bill->dv_num = $req['dv_num'];
          //$bill->gross_amt = $req['gross_amt'];
          //$bill->net_amt = $req['net_amt'];
          //$bill->check_num = $req['check_num'];
          //$bill->check_name = $req['check_name'];
          //$bill->check_amt = $req['check_amt'];
          //$bill->check_date = $req['check_date'];
          //$bill->release_date = $req['release_date'];
          //$bill->released_to = $req['released_to'];
          if($bill->tc_stat>=1)
            GettersController::updatedvdetails($req,1);
          if($bill->af_stat>=1)
            GettersController::updatedvdetails($req,2);
          if($bill->ef_stat>=1)
            GettersController::updatedvdetails($req,3);
          if($bill->ba_stat>=1)
            GettersController::updatedvdetails($req,4);
          if($bill->ta_stat>=1)
            GettersController::updatedvdetails($req,5);
          if($bill->sfa_stat>=1)
            GettersController::updatedvdetails($req,6);

          if($bill->tc_stat>=2)
            GettersController::updatecheckdetails($req,1);
          if($bill->af_stat>=2)
            GettersController::updatecheckdetails($req,2);
          if($bill->ef_stat>=2)
            GettersController::updatecheckdetails($req,3);
          if($bill->ba_stat>=2)
            GettersController::updatecheckdetails($req,4);
          if($bill->ta_stat>=2)
            GettersController::updatecheckdetails($req,5);
          if($bill->sfa_stat>=2)
            GettersController::updatecheckdetails($req,6);

          if($bill->tc_stat>=3)
            GettersController::updatepaymentdetails($req,1);
          if($bill->af_stat>=3)
            GettersController::updatepaymentdetails($req,2);
          if($bill->ef_stat>=3)
            GettersController::updatepaymentdetails($req,3);
          if($bill->ba_stat>=3)
            GettersController::updatepaymentdetails($req,4);
          if($bill->ta_stat>=3)
            GettersController::updatepaymentdetails($req,5);
          if($bill->sfa_stat>=3)
            GettersController::updatepaymentdetails($req,6);

          break;
        }

        $log = NEW LOG;
        $log->incoming_id = $did;
        $log->action_taken = "Edited Document Details";
        $log->user_id = Auth::User()->user_id;
        $log->SAVE();

        return redirect()->back()->with('success','success');
    }

    public function viewstaff() {

      $activelink = 'employees';

     $staff = USER::ORDERBY('lastname')->GET();

     return view('master/staff', compact('activelink','staff'));
    }

    public function viewaddstaff() {

      $activelink = 'employees';

      return view('master/newstaff', compact('activelink'));
    }

    public function addstaff(Request $req) {

      $staff = new USER;
      $staff->emp_id = $req['emp_id'];
      $staff->firstname = $req['firstname'];
      $staff->middlename = $req['middlename'];
      $staff->lastname = $req['lastname'];
      $staff->position = $req['position'];
      $staff->emp_stat = $req['emp_stat'];
      $staff->SAVE();

      $staff = USER::ORDERBY('created_at','DESC')->FIRST();

      $staffaccount = new ACCT;
      $staffaccount->username = $req['username'];
      $staffaccount->password = bcrypt($req['pass2']);
      $staffaccount->user_id = $staff->user_id;
      $staffaccount->user_level = $req['user_level'];
      $staffaccount->SAVE();
    }

    public function viewstaffdetails($user_id) {

      $activelink = 'employees';

      $staff = USER::SELECT()
        ->JOIN('tbl_accounts','tbl_accounts.user_id','=','tbl_users.user_id')
        ->WHERE('tbl_accounts.user_id',$user_id)
        ->FIRST();

      return view('master/staffdetails', compact('activelink','staff'));
    }

    public function updateemployee(Request $req) {

      $staff = USER::FIND($req['user_id']);
      $staff->emp_id = $req['emp_id'];
      $staff->firstname = $req['firstname'];
      $staff->middlename = $req['middlename'];
      $staff->lastname = $req['lastname'];
      $staff->position = $req['position'];
      $staff->emp_stat = $req['emp_stat'];
      $staff->SAVE();

      if($req['updatelogin']=='Y'){

        $staffaccount = ACCT::WHERE('user_id',$req['user_id'])->FIRST();
        $staffaccount->username = $req['username'];
        $staffaccount->password = bcrypt($req['pass2']);
        $staffaccount->user_id = $req['user_id'];
        $staffaccount->user_level = $req['user_level'];
        $staffaccount->SAVE();
      }
    }

    public function viewdoctypes() {

      $activelink = 'doctypes';

      $doctypes = DOCTYPES::ORDERBY('doc_type')->GET();

      return view('master/doctypes', compact('activelink','doctypes'));
    }

    public function updatedoctype(Request $req) {

      $doctype = DOCTYPES::FIND($req['did']);
      $doctype->doc_type = $req['dtype'];
      $doctype->description  = $req['remarks'];
      $doctype->SAVE();
    }

    public function adddoctype(Request $req) {

      $doctype = new DOCTYPES;
      $doctype->doc_type = $req['dtype'];
      $doctype->description  = $req['remarks'];
      $doctype->SAVE();
    }

    public function deldoctype(Request $req) {

      $doctype = DOCTYPES::FIND($req['id']);
      $doctype->DELETE();
    }

    public function viewclienttypes() {

      $activelink = 'clienttypes';

      $clienttypes = CLIENTS::ORDERBY('client_type')->WHERE('client_type_id','!=',1)->GET();

      return view('master/scholarships', compact('activelink','clienttypes'));
    }

    public function updateclienttype(Request $req) {

      $client = CLIENTS::FIND($req['cid']);
      $client->client_type = $req['ctype'];
      $client->description  = $req['remarks'];
      $client->SAVE();
    }

    public function addclienttype(Request $req) {

      $client = new CLIENTS;
      $client->client_type = $req['ctype'];
      $client->description  = $req['remarks'];
      $client->SAVE();
    }

    public function delclienttype(Request $req) {

      $client = CLIENTS::FIND($req['id']);
      $client->DELETE();
    }

    public function archivedoc($doc_id) {

      $doc = INDOCS::FIND($doc_id);
      $doc->is_archived = 1;
      $doc->SAVE();

      $log = NEW LOG;
      $log->incoming_id = $doc_id;
      $log->action_taken = "Archived the Document";
      $log->user_id = Auth::User()->user_id;
      $log->SAVE();

      return redirect()->back()->with('success','success');
    }

    public function restoredoc($doc_id) {

      $doc = INDOCS::FIND($doc_id);
      $doc->is_archived = 0;
      $doc->SAVE();

      $log = NEW LOG;
      $log->incoming_id = $doc_id;
      $log->action_taken = "Restored the Document from the Archives";
      $log->user_id = Auth::User()->user_id;
      $log->SAVE();

      return redirect()->back()->with('success','success');
    }

    public function viewcourses() {

      $activelink = 'courses';

      $courses = COURSE::ORDERBY('course')->GET();

      return view('master/courses', compact('activelink','courses'));
    }

    public function updatecourse(Request $req) {

      $course = COURSE::FIND($req['did']);
      $course->course = $req['dtype'];
      $course->description  = $req['remarks'];
      $course->SAVE();
    }

    public function addcourse(Request $req) {

      $course = new COURSE;
      $course->course = $req['dtype'];
      $course->description  = $req['remarks'];
      $course->SAVE();
    }

    public function delcourse(Request $req) {

      $course = COURSE::FIND($req['id']);
      $course->DELETE();
    }

    public function viewagencytypes() {

      $activelink = 'agencytypes';

      $agencytype = AGENCY::ORDERBY('agency_type')->GET();

      return view('master/agencytypes', compact('activelink','agencytype'));
    }

    public function updateagencytype(Request $req) {

      $agencytype = AGENCY::FIND($req['did']);
      $agencytype->agency_type = $req['atype'];
      $agencytype->description = $req['remarks'];
      $agencytype->SAVE();
    }

    public function addagencytype(Request $req) {

      $agencytype = new AGENCY;
      $agencytype->agency_type = $req['atype'];
      $agencytype->description = $req['remarks'];
      $agencytype->SAVE();
    }

    public function delagencytype(Request $req) {

      $agencytype = AGENCY::FIND($req['id']);
      $agencytype->DELETE();
    }

    public function viewarchive() {

      $activelink = 'archives';

      $docs = INDOCS::SELECT(
          'doc_id',
          'tbl_incoming.origin_id',
          'subject',
          'tbl_incoming.origin_id',
          'origin_name',
          'doc_type_id',
          'doc_type',
          'status',
          'tbl_incoming.created_at',
          'tbl_incoming.updated_at'
          )
          ->JOIN('tbl_origins','tbl_origins.origin_id','=','tbl_incoming.origin_id')
          ->JOIN('tbl_doc_types','tbl_doc_types.doctype_id','=','tbl_incoming.doc_type_id')
          ->WHERE('is_archived',1)
          ->ORDERBY('tbl_incoming.created_at','DESC')
          ->GET();
      $types = DOCTYPES::ORDERBY('doc_type')->GET();
      return view('master/archives', compact('activelink','docs','types'));

    }

    public function viewlogs() {

      $activelink = 'logs';

      $log = LOG::SELECT(
        'tbl_logs.action_taken',
        DB::RAW('tbl_logs.created_at as log_date'),
        'tbl_incoming.doc_id',
        'tbl_incoming.created_at',
        'tbl_incoming.updated_at',
        'tbl_users.lastname',
        'tbl_users.firstname'
      )
      ->JOIN('tbl_incoming','tbl_incoming.doc_id','=','tbl_logs.incoming_id')
      ->JOIN('tbl_users','tbl_users.user_id','=','tbl_logs.user_id')
      ->GET();

      return view('master/logs', compact('activelink','log'));
    }

    public function viewserialnum() {

      $activelink = 'serials';

      $serials = SERIALS::ORDERBY('serial_no_start')->GET();

      return view('master/serials', compact('activelink','serials'));
    }

    public function addserialnum(Request $req) {

      $serial = new SERIALS;
      $serial->serial_no_start = $req['sns'];
      $serial->serial_no_end  = $req['sne'];
      $serial->SAVE();
    }

    public function updateserialnum(Request $req) {

      $serial = SERIALS::FIND($req['sid']);
      $serial->serial_no_start = $req['sns'];
      $serial->serial_no_end  = $req['sne'];
      $serial->SAVE();
    }

     public function delserialnum(Request $req) {

      $serial = SERIALS::FIND($req['id']);
      $serial->DELETE();
    }

    public function viewpayments() {

      $activelink = 'payments';

      $payments = PAYMENT::SELECT(
        'tbl_incoming.doc_id',
        'tbl_client_types.client_type',
        'tbl_billing_payment.release_date',
        'tbl_billing_types.billing_type',
        'tbl_billing_dv.serial_num',
        'tbl_billing_payment.released_to',
        'tbl_billing_check.check_amt'
        )
        ->JOIN('tbl_billing','tbl_billing.billing_id','=','tbl_billing_payment.billing_id')
        ->JOIN('tbl_incoming','tbl_incoming.doc_id','=','tbl_billing.incoming_id')
        ->JOIN('tbl_client_types','tbl_client_types.client_type_id','=','tbl_billing.client_type_id')
        ->JOIN('tbl_billing_types','tbl_billing_types.billing_type_id','=','tbl_billing_payment.billing_type_id')
        ->JOIN('tbl_billing_dv', function($join) {
            $join->ON('tbl_billing_dv.billing_id','=','tbl_billing.billing_id')
                ->ON('tbl_billing_dv.billing_type_id','=','tbl_billing_payment.billing_type_id');
        })
        ->JOIN('tbl_billing_check', function($join) {
            $join->ON('tbl_billing_check.billing_id','=','tbl_billing.billing_id')
                ->ON('tbl_billing_check.billing_type_id','=','tbl_billing_payment.billing_type_id');
        })
        ->WHERE('tbl_incoming.is_archived',0)
        ->GET();


        return view('master/payments', compact('activelink','payments'));
    }

}
?>
