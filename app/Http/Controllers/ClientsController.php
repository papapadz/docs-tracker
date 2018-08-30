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
use App\ConcernedStaffModel as CONCERNS;
use App\AssessorsModel as ASSESSOR;
use App\SerialNumbersModel as SERIALS;
use DB;

class ClientsController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function vieworigin() {

        $activelink = 'agencies';

    	$origins = ORIGS::SELECT()
    		->JOIN('tbl_agency_types','tbl_agency_types.agency_type_id','=','tbl_origins.type')
    		->ORDERBY('origin_name')
    		->GET();

    	return view('master/origins', compact('activelink','origins'));
    }

    public function viewneworigin() {

        $activelink = 'agencies';

    	$atypes = AGENCY::ORDERBY('agency_type')->GET();
    	//$serials = SERIALS::ORDERBY('serial_no_start')->WHERE('is_taken',0)->GET();

    	return view('master/neworigin', compact('activelink','atypes'));
    }

    public function addneworigin(Request $req) {

    	$agency = new ORIGS;
    	$agency->origin_name = $req['agency_name'];
    	$agency->type = $req['agency_type'];
    	$agency->address = $req['agency_address'];
    	$agency->head_of_origin = $req['agency_head'];
    	$agency->tin_num = $req['agency_tin'];
    	$agency->description = $req['agency_desc'];
		$agency->contact_num = $req['agency_contact'];
		$agency->email = $req['agency_email'];
		$agency->head_position = $req['agency_headpos'];
		$agency->contact_person = $req['agency_contactperson'];
		$agency->contact_person_no = $req['agency_contactpersonno'];
		//$agency->serial_num = $req['agency_serial'];
		$agency->SAVE();

		/*
		$serialnew = SERIALS::FIND($req['agency_serial']);
		$serialnew->is_taken = 1;
		$serialnew->SAVE();
		*/
    }

		public function vieworigindetails($origin_id) {

            $activelink = 'agencies';

			$origin = ORIGS::SELECT()
				->WHERE('origin_id',$origin_id)
				->FIRST();

			$atypes = AGENCY::ORDERBY('agency_type')->GET();

			return view('master/origindetails', compact('activelink','origin','atypes'));
		}

		public function updateorigin(Request $req) {

			$oldserial = $req['snum'];
			$newserial = $req['agency_serial'];

			$agency = ORIGS::FIND($req['agency_id']);
			$agency->origin_name = $req['agency_name'];
	    	$agency->type = $req['agency_type'];
	    	$agency->address = $req['agency_address'];
	    	$agency->head_of_origin = $req['agency_head'];
	    	$agency->tin_num = $req['agency_tin'];
	    	$agency->description = $req['agency_desc'];
			$agency->contact_num = $req['agency_contact'];
			$agency->email = $req['agency_email'];
			$agency->head_position = $req['agency_headpos'];
			$agency->contact_person = $req['agency_contactperson'];
			$agency->contact_person_no = $req['agency_contactpersonno'];

			/*
			if($oldserial!=0&&$newserial!=0) {

				if($oldserial!=$newserial) {

				$agency->serial_num = $newserial;

				$serialold = SERIALS::FIND($oldserial);
				$serialold->is_taken = 0;
				$serialold->SAVE();

				$serialnew = SERIALS::FIND($newserial);
				$serialnew->is_taken = 1;
				$serialnew->SAVE();
				}
			}
			*/
			$agency->SAVE();
		}

		public function viewassessors() {

			$activelink = 'assessors';

			$assessors = ASSESSOR::ORDERBY('lastname')->GET();

			return view('receiving/assessors', compact('activelink','assessors'));
		}

		public function viewnewassessor() {

			$activelink = 'assessors';

			return view('receiving/newassessor', compact('activelink'));
		}

		public function addnewassessor(Request $req) {

			$assessor = new ASSESSOR;
			$assessor->lastname = $req['lastname'];
			$assessor->firstname = $req['firstname'];
			$assessor->middlename = $req['middlename'];
			$assessor->accreditation_id = $req['accre_id'];
			$assessor->level = $req['accre_level'];
			$assessor->date_issued = $req['date_issued'];
			$assessor->expiry_date = $req['date_expiry'];
			$assessor->SAVE();

			$assessor = ASSESSOR::ORDERBY('created_at','DESC')->FIRST();

			$scan = $req->file('fileupload');

			if($scan !== null) {
				$input['file'] = $assessor->assessor_id.'.'.$scan->getClientOriginalExtension();
				$destinationPath = public_path('/certificates');
				$scan->move($destinationPath, $input['file']);

				$saveto = ASSESSOR::FIND($assessor->assessor_id);
				$saveto->file = $input['file'];
				$saveto->SAVE();
			}

			return redirect()->route('assessors.list')->with('success','New Assessor Details has been added!');
		}

		public function viewassessordetails($id) {

			$activelink = 'assessors';
			$assessor = ASSESSOR::FIND($id);

			return view('receiving/assessordetails', compact('activelink','assessor'));
		}

		public function updateassessor(Request $req) {

			$assessor = ASSESSOR::FIND($req['assessor_id']);
			$assessor->lastname = $req['lastname'];
			$assessor->firstname = $req['firstname'];
			$assessor->middlename = $req['middlename'];
			$assessor->accreditation_id = $req['accre_id'];
			$assessor->level = $req['accre_level'];
			$assessor->date_issued = $req['date_issued'];
			$assessor->expiry_date = $req['date_expiry'];
			$assessor->SAVE();

			$assessor = ASSESSOR::FIND($req['assessor_id']);

			$scan = $req->file('fileupload');

			if($scan !== null) {
				$input['file'] = $assessor->assessor_id.'.'.$scan->getClientOriginalExtension();
				$destinationPath = public_path('/certificates');
				$scan->move($destinationPath, $input['file']);

				$saveto = ASSESSOR::FIND($assessor->assessor_id);
				$saveto->file = $input['file'];
				$saveto->SAVE();
			}

			return redirect()->back()->with('success','success');
		}

	public function deleteassessor($aid) {

		$assessor = ASSESSOR::FIND($aid);
		$assessor->DELETE();

		return redirect()->route('assessors.list')->with('success','Assessor Details has been deleted!');
	}

	public function viewpdf($id) {

      $activelink = 'assessors';

      $did = $id;
      return view('user/viewpdf', compact('activelink','did'));
    }
}
