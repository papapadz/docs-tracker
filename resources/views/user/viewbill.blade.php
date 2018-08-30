@extends('layouts.app')

@section('top')
<h3>Document No. {{Carbon\Carbon::parse($incdoc->created_at)->year}}-{{Carbon\Carbon::parse($incdoc->created_at)->format('m')}}-{{$incdoc->doc_id}}</h3>
@endsection

@if($incdoc->is_archived!=1 && $incdoc->status != 0)
  @if(Auth::User()->user_level!=3)
  @section('lowmid')
    <div class="btn-group">
      @if($incdoc->client_type_id != 5)
      <div class="btn-group" >
        <button id="btnGroupDrop1" class="btn btn-sm bg-primary dropdown-toggle text-white @if($incdoc->tc_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Training Cost
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
          <a href="#" id="settcDV" @if($incdoc->tc_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif>DV No. and OBR No. +</a>
          <a href="#" id="settcCheck" @if($incdoc->tc_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="settcPayment" data-toggle="modal" data-target="#setPaymentModal">Payment +</a>
        </div>
      </div>
      @endif
    <div class="btn-group">
      <button id="btnGroupDrop2" class="btn btn-sm bg-success dropdown-toggle text-white @if($incdoc->af_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Assessment Fee
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
          <a href="#" id="setafDV" @if($incdoc->af_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif >DV No. and OBR No. +</a>
          <a href="#" id="setafCheck" @if($incdoc->af_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="setafPayment" data-toggle="modal" data-target="#setPaymentModal">Payment +</a>
        </div>
      </div>
      @if($incdoc->client_type_id == 3 || $incdoc->client_type_id == 7)
      <div class="btn-group">
      <button id="btnGroupDrop3" class="btn btn-sm bg-warning dropdown-toggle text-white @if($incdoc->ef_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Entrep Fee
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
          <a href="#" id="setefDV" @if($incdoc->ef_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif >DV No. and OBR No. +</a>
          <a href="#" id="setefCheck" @if($incdoc->ef_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="setefPayment" data-toggle="modal" data-target="#setPaymentModal" >Payment +</a>
        </div>
      </div>
      @endif
      @if($incdoc->client_type_id == 4)
      <div class="btn-group">
      <button id="btnGroupDrop4" class="btn btn-sm bg-info dropdown-toggle text-white @if($incdoc->ba_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Book Allowance
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop4">
          <a href="#" id="setbaDV" @if($incdoc->ba_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif >DV No. and OBR No. +</a>
          <a href="#" id="setbaCheck" @if($incdoc->ba_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="setbaPayment" data-toggle="modal" data-target="#setPaymentModal" >Payment +</a>
        </div>
      </div>
      @endif
      @if($incdoc->client_type_id == 3 || $incdoc->client_type_id == 6 || $incdoc->client_type_id == 7)
      <div class="btn-group">
      <button id="btnGroupDrop5" class="btn btn-sm btn-success bg-success dropdown-toggle text-white @if($incdoc->ta_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Training Allowance
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop5">
          <a href="#" id="settaDV" @if($incdoc->ta_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif >DV No. and OBR No. +</a>
          <a href="#" id="settaCheck" @if($incdoc->ta_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="settaPayment" data-toggle="modal" data-target="#setPaymentModal" >Payment +</a>
        </div>
      </div>
      @endif
      @if($incdoc->client_type_id == 4)
      <div class="btn-group">
      <button id="btnGroupDrop6" class="btn btn-sm bg-warning dropdown-toggle text-white @if($incdoc->sfa_stat==3) disabled @endif" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Student Financial Assistance
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop6">
          <a href="#" id="setsfaDV" @if($incdoc->sfa_stat>=1) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setDVModal" @endif >DV No. and OBR No. +</a>
          <a href="#" id="setsfaCheck" @if($incdoc->sfa_stat>=2) class="dropdown-item disabled" @else class="dropdown-item" data-toggle="modal"  data-target="#setCheckModal" @endif >Check +</a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item text-success" id="setsfaPayment" data-toggle="modal" data-target="#setPaymentModal" >Payment +</a>
        </div>
      </div>
      @endif
    </div>
    <hr>
  @endsection
  @endif
@endif
@section('content')

@if(Session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your changes has been saved.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

@if($incdoc->is_archived==1)
  <div class="alert alert-danger" role="alert"><b>Status: </b>This document is archived.</div>
@elseif($incdoc->status==0)
  <div class="alert alert-danger" role="alert"><b>Status: </b>No remarks yet.</div>
@elseif($incdoc->status==1)
  <div class="alert alert-primary" role="alert">
    <b>Status: </b>Endorsed to
    @foreach($endorsedto as $e)
      <i>,{{$e->firstname}} {{$e->lastname}} </i>
    @endforeach
  </div>
@else
  @include('docviews.billingstat')
@endif

<div class="card" >
  <div class="card-header">
    <div class="btn-group mr-2" role="group">
      <a class="btn btn-sm btn-warning @if($incdoc->doc_file==null) disabled @endif" href="{{url('document/pdf/'.$incdoc->doc_id)}}" target="_blank" >View PDF</a>
      @if($incdoc->is_archived==1)
        @if(Auth::User()->user_level == 1)
          <a class="btn btn-sm btn-success" href="{{url('document/restore/'.$incdoc->doc_id)}}" onclick="return confirm('Are you sure you want to restore this document from the archives?');">Restore</a>
        @endif
      @elseif($incdoc->status!=0 && Auth::User()->user_level == 1)
        <button class="btn btn-sm btn-primary" id="editdoc">Edit</button>
        <button class="btn btn-sm btn-danger" id="canceledit" hidden="true">Cancel</button>
      @endif
    </div>
    @if(Auth::User()->user_level != 2)
    <a class="btn btn-sm btn-danger float-right" id="deldoc" hidden="true" href="{{url('document/archive/'.$incdoc->doc_id)}}" onclick="return confirm('Are you sure want to archive this Document?');">Archive</a>
    @endif
  </div>
    <div class="card-body">
      <form id="frm_docinfo" method="POST" enctype="multipart/form-data" action="{{url('updateall')}}" >
        {{ csrf_field() }}
        <input type="text" value="{{$incdoc->doc_id}}" id="inc_id" name="inc_id" hidden/>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label for="origin">Origin of Document</label>
            <select class="custom-select" id="origin" name="origin" disabled >
                <option value="" disabled selected>Choose Origin</option>
                @foreach($origins as $origs)
                <option value="{{ $origs->origin_id }}" @if($incdoc->origin_id==$origs->origin_id) selected @endif> {{ $origs->origin_name }} </option>
                @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label >Date of Document</label>
            <input type="date" class="form-control" value="{{$incdoc->doc_date}}" id="doc_date" name="doc_date" disabled/>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3" @if($incdoc->doc_date_issued==null || $incdoc->doc_date_issued=='0000-00-00') hidden @endif>
            <label >Date Issued</label>
            <input type="date" class="form-control" value="{{$incdoc->doc_date_issued}}" id="doc_date_issued" name="doc_date_issued" disabled/>
          </div>
          <div class="col-md-6 mb-3" @if($incdoc->doc_ctrl_num==null || $incdoc->doc_ctrl_num=='') hidden @endif>
            <label >Document Control Number</label>
            <input type="text" class="form-control" value="{{$incdoc->doc_ctrl_num}}" id="doc_ctrl_num" name="doc_ctrl_num" disabled/>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label >Type of document</label>
            <select id="doc_type" name="doc_type" class="custom-select" disabled="true">
              <option value="" disabled>Choose Type of Document</option>
              @foreach($doctypes as $d)
              <option value="{{$d->doctype_id}}" @if($d->doctype_id==$incdoc->doc_type_id) selected @endif >{{$d->doc_type}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label >Subject</label>
            <input type="text" class="form-control" value="{{$incdoc->subject}}" id="subject" name="subject" disabled/>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3">
            <label >Signatory</label>
            <input type="text" class="form-control" value="{{$incdoc->signatory}}" id="signatory" name="signatory" disabled/>
          </div>
          <div class="col-md-6 mb-3">
            <label >Action Taken</label>
            <input type="text" class="form-control" value="{{$incdoc->action_taken}}" id="action_taken" name="action_taken" disabled/>
          </div>
        </div>
        <div id="divaddremarks">
        <div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Qualification </label>
    <select class="custom-select" id="course" name="course" disabled>
        <option value="" disabled selected>Choose Qualification</option>
        @foreach($courses as $c)
        <option value="{{ $c->course_id }}" @if($c->course_id==$incdoc->course_id) selected @endif > {{ $c->course }} </option>
        @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label >Number of Pax </label>
    <input type="text" class="form-control" name="numpax" value="{{$incdoc->numpax}}" disabled="true"/>
  </div>
</div>
<div class="form-row">
<div class="col-md-12 mb-3">
    <label >Training Institution </label>
    <input type="text" class="form-control" name="sgdetails" value="{{$incdoc->scholarship_details}}" disabled="true"/>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Type of Scholarship </label>
    <select class="custom-select" id="clienttype" name="clienttype" disabled>
        <option value="" disabled selected>Choose Type of Scholarship</option>
        @foreach($client as $cl)
        <option value="{{ $cl->client_type_id }}" @if($cl->client_type_id ==$incdoc->client_type_id) selected @endif > {{ $cl->client_type }} </option>
        @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label >Amount in Pesos </label>
    <input type="number" class="form-control" name="amt" value="{{$incdoc->bill_amt}}" disabled="true" />
  </div>
</div>
<div class="form-row">
  <div class="col-md-4 mb-3">
    <label >Start of Assessment</label>
    <input class="form-control" type="date" name="start_assessment" value="{{$incdoc->date_start}}" disabled="true"/>
  </div>
  <div class="col-md-4 mb-3">
    <label >End of Assessment</label>
    <input class="form-control" type="date" name="end_assessment" value="{{$incdoc->date_end}}" disabled="true"/>
  </div>
  <div class="col-md-4 mb-3">
    <label >Assessment Date</label>
    <input class="form-control" type="text" name="assessment_date" id="ass_date" value="{{$incdoc->assessment_date}}" disabled="true"/>
  </div>
</div>
          <hr>
          @if($incdoc->status==0)
            @if(Auth::User()->user_level==1)
            <div class="form-row">
              <div class="col-md-8 mb-3">
                <label>Remarks</label>
                 <textarea class="form-control" name="remarks"></textarea>
              </div>
            <div class="col-md-4 mb-3">
              <label>Persons Concerned</label>
              <select id="stafflist" class="custom-select">
                <option value="" selected disabled>Choose Staff</option>
                @foreach($staff as $s)
                <option value="{{$s->user_id}}" >{{$s->lastname}}, {{$s->firstname}}</option>
                @endforeach
              </select>
            </div>
            </div>
            @endif
          @else
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label>Remarks </label>
              <textarea class="form-control" disabled="true" name="savedremarks">{{$incdoc->remarks}}</textarea>
            </div>
          </div>

          @if($trainingcost_dv)
          <h5 class="text-primary">Training Cost</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="tc_dv" disabled="true" value="{{$trainingcost_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="tc_dv_date" disabled="true" value="{{$trainingcost_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="tc_obr" disabled="true" value="{{$trainingcost_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="tc_obr_date" disabled="true" value="{{$trainingcost_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="tc_payee" disabled="true" value="{{$trainingcost_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="tc_serial" disabled="true" value="{{$trainingcost_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="tc_gross" disabled="true" value="{{$trainingcost_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="tc_tax" disabled="true" value="{{$trainingcost_dv->tax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="tc_net" disabled="true" value="{{$trainingcost_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($trainingcost_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="tc_check_num" disabled="true" value="{{$trainingcost_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="tc_check_name" disabled="true" value="{{$trainingcost_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="tc_check_date" disabled="true" value="{{$trainingcost_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="tc_check_amt" disabled="true" value="{{$trainingcost_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($trainingcost_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="tc_or" disabled="true" value="{{$trainingcost_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="tc_released_to" disabled="true" value="{{$trainingcost_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="tc_release_date" disabled="true" value="{{$trainingcost_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @if($assessmentfee_dv)
          <h5 class="text-success">Assessment Fee</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="af_dv" disabled="true" value="{{$assessmentfee_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="af_dv_date" disabled="true" value="{{$assessmentfee_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="af_obr" disabled="true" value="{{$assessmentfee_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="af_obr_date" disabled="true" value="{{$assessmentfee_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="af_payee" disabled="true" value="{{$assessmentfee_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="af_serial" disabled="true" value="{{$assessmentfee_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="af_gross" disabled="true" value="{{$assessmentfee_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="af_tax" disabled="true" value="{{$assessmentfee_dv->tax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="af_net" disabled="true" value="{{$assessmentfee_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($assessmentfee_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="af_check_num" disabled="true" value="{{$assessmentfee_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="af_check_name" disabled="true" value="{{$assessmentfee_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="af_check_date" disabled="true" value="{{$assessmentfee_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="af_check_amt" disabled="true" value="{{$assessmentfee_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($assessmentfee_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="af_or" disabled="true" value="{{$assessmentfee_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="af_released_to" disabled="true" value="{{$assessmentfee_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="af_release_date" disabled="true" value="{{$assessmentfee_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @if($entrepfee_dv)
          <h5 class="text-warning">Entrep Fee</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="ef_dv" disabled="true" value="{{$entrepfee_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="ef_dv_date" disabled="true" value="{{$entrepfee_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="ef_obr" disabled="true" value="{{$entrepfee_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="ef_obr_date" disabled="true" value="{{$entrepfee_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="ef_payee" disabled="true" value="{{$entrepfee_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="ef_serial" disabled="true" value="{{$entrepfee_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="ef_gross" disabled="true" value="{{$entrepfee_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="ef_tax" disabled="true" value="{{$entrepfee_dv->tax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="ef_net" disabled="true" value="{{$entrepfee_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($entrepfee_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="ef_check_num" disabled="true" value="{{$entrepfee_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="ef_check_name" disabled="true" value="{{$entrepfee_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="ef_check_date" disabled="true" value="{{$entrepfee_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="ef_check_amt" disabled="true" value="{{$entrepfee_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($entrepfee_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="ef_or" disabled="true" value="{{$entrepfee_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="ef_released_to" disabled="true" value="{{$entrepfee_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="ef_release_date" disabled="true" value="{{$entrepfee_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @if($bookallowance_dv)
          <h5 class="text-info">Book Allowance</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="ba_dv" disabled="true" value="{{$bookallowance_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="ba_dv_date" disabled="true" value="{{$bookallowance_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="ba_obr" disabled="true" value="{{$bookallowance_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="ba_obr_date" disabled="true" value="{{$bookallowance_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="ba_payee" disabled="true" value="{{$bookallowance_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="ba_serial" disabled="true" value="{{$bookallowance_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="ba_gross" disabled="true" value="{{$bookallowance_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="ba_tax" disabled="true" value="{{$bookallowance_dv->tax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="ba_net" disabled="true" value="{{$bookallowance_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($bookallowance_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="ba_check_num" disabled="true" value="{{$bookallowance_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="ba_check_name" disabled="true" value="{{$bookallowance_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="ba_check_date" disabled="true" value="{{$bookallowance_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="ba_check_amt" disabled="true" value="{{$bookallowance_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($bookallowance_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="ba_or" disabled="true" value="{{$bookallowance_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="ba_released_to" disabled="true" value="{{$bookallowance_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="ba_release_date" disabled="true" value="{{$bookallowance_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @if($trainingallowance_dv)
          <h5 class="text-success">Training Allowance</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="ta_dv" disabled="true" value="{{$trainingallowance_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="ta_dv_date" disabled="true" value="{{$trainingallowance_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="ta_obr" disabled="true" value="{{$trainingallowance_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="ta_obr_date" disabled="true" value="{{$trainingallowance_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="ta_payee" disabled="true" value="{{$trainingallowance_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="ta_serial" disabled="true" value="{{$trainingallowance_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="ta_gross" disabled="true" value="{{$trainingallowance_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="ta_tax" disabled="true" value="{{$trainingallowance_dv->tax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="ta_net" disabled="true" value="{{$trainingallowance_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($trainingallowance_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="ta_check_num" disabled="true" value="{{$trainingallowance_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="ta_check_name" disabled="true" value="{{$trainingallowance_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="ta_check_date" disabled="true" value="{{$trainingallowance_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="ta_check_amt" disabled="true" value="{{$trainingallowance_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($trainingallowance_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="ta_or" disabled="true" value="{{$trainingallowance_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="ta_released_to" disabled="true" value="{{$trainingallowance_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="ta_release_date" disabled="true" value="{{$trainingallowance_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @if($studentfinasst_dv)
          <h5 class="text-warning">Student Financial Assistance</h4>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher No.</label>
              <input type="text" class="form-control" name="sfa_dv" disabled="true" value="{{$studentfinasst_dv->dv_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Disbursement Voucher Date</label>
              <input type="date" class="form-control" name="sfa_dv_date" disabled="true" value="{{$studentfinasst_dv->dv_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>OBR No.</label>
              <input type="text" class="form-control" name="sfa_obr" disabled="true" value="{{$studentfinasst_dv->obr_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>OBR Date</label>
              <input type="date" class="form-control" name="sfa_obr_date" disabled="true" value="{{$studentfinasst_dv->obr_date}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payee</label>
              <input type="text" class="form-control" name="sfa_payee" disabled="true" value="{{$studentfinasst_dv->payee}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Serial Number</label>
              <input type="text" class="form-control" name="sfa_serial" disabled="true" value="{{$studentfinasst_dv->serial_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Gross Amount</label>
              <input type="number" class="form-control" name="sfa_gross" disabled="true" value="{{$studentfinasst_dv->gross}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Tax</label>
              <input type="number" class="form-control" name="sfa_sfax" disabled="true" value="{{$studentfinasst_dv->sfax}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Net Amount</label>
              <input type="number" class="form-control" name="sfa_net" disabled="true" value="{{$studentfinasst_dv->net}}"></input>
            </div>
          </div>
          @endif
          @if($studentfinasst_check)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Check Number</label>
              <input type="text" class="form-control" name="sfa_check_num" disabled="true" value="{{$studentfinasst_check->check_num}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Name</label>
              <input type="text" class="form-control" name="sfa_check_name" disabled="true" value="{{$studentfinasst_check->check_name}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="sfa_check_date" disabled="true" value="{{$studentfinasst_check->check_date}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Check Amount</label>
              <input type="number" class="form-control" name="sfa_check_amt" disabled="true" value="{{$studentfinasst_check->check_amt}}"></input>
            </div>
          </div>
          @endif
          @if($studentfinasst_payment)
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Official Receipt No.</label>
              <input type="text" class="form-control" name="sfa_or" disabled="true" value="{{$studentfinasst_payment->or_num}}"></input>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-2">
              <label>Payment Released to</label>
              <input type="text" class="form-control" name="sfa_released_to" disabled="true" value="{{$studentfinasst_payment->released_to}}"></input>
            </div>
            <div class="col-md-6 mb-2">
              <label>Date Released</label>
              <input type="date" class="form-control" name="sfa_release_date" disabled="true" value="{{$studentfinasst_payment->release_date}}"></input>
            </div>
          </div>
          @endif
          @endif
          </div>
          <div id="divconcerned" class="form-row" hidden>
            <div class="col-md-12 mb-3">
              <label>Concerned Staff (Click to remove)</label><br>
              @foreach($endorsedto as $e)
                <a href="#" class="btn btn-lg staff-remove" id="{{$e->user_id}}" data-val="{{$e->user_id}}">{{$e->firstname}} {{$e->lastname}} </a>
              @endforeach
            </div>
          </div>
          <div class="form-row" id="divupload" hidden="true">
            <div class="file-field" >
      				<label>Upload New PDF File</label><br>
      					<div class="btn btn-primary">
      						<input type="file" id="fileupload" name="fileupload" >
      					</div>
      			</div>
          </div>
          @if($incdoc->status!=0)
          <button class="btn btn-success" id="btnsaveremarks" @if($incdoc->status!=0) hidden="true" @endif >Save Edits</button>
          @endif
          <input type="number" name="billid" id="doc_bid" value="{{$incdoc->billing_id}}" hidden/>
        </form>
        @if(Auth::User()->user_level==1)
        <a class="btn btn-success text-white" id="btnendorse" @if($incdoc->status>=1) hidden="true" @endif>Save</a>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setDVModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Disbursement Voucher Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setdv">
          <input class="form-control" type="number" name="did" value="{{$incdoc->doc_id}}" hidden/>
          <input class="form-control" type="number" name="billid" value="{{$incdoc->b_id}}" hidden/>
          <input class="form-control" type="number" name="savetype" value="1" hidden/>
          <input class="form-control billtype" type="number" name="billtype" value="0" hidden/>
          <input class="form-control feetype" type="number" name="feetype" value="0" hidden/>

          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>DV No.</label>
              <input type="text" class="form-control" id="dvnum" name="dvnum" value="{{$incdoc->dv_num}}" />
              <label>DV Date</label>
              <input type="date" class="form-control" id="dvdate" name="dvdate" value="{{$incdoc->dv_date}}"/>
            </div>
            <div class="col-md-6 mb-3">
              <label>OBR No.</label>
              <input type="text" class="form-control" id="obrnum" name="obrnum" value="{{$incdoc->obr_num}}"/>
              <label>OBR Date</label>
              <input type="date" class="form-control" id="obrdate" name="obrdate" value="{{$incdoc->obr_date}}"/>
            </div>
          </div>
           <label>Serial Number</label>
            <input type="text" class="form-control" id="serial" name="serial" />
            <label>Payee</label>
            <input type="text" class="form-control" id="payee" name="payee" />
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label>Gross Amount</label>
              <input type="number" min=0 class="form-control currency" id="gross" name="gross" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Tax</label>
              <input type="number" min=0 class="form-control" id="tax" name="tax" />
            </div>
          </div>
            <label>Net Amount</label>
            <input type="number" min=0 class="form-control currency" id="net" name="net" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savedv">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Check Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setcheck">
            <input class="form-control" type="number" name="did" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" name="billid" value="{{$incdoc->b_id}}" hidden/>
            <input class="form-control" type="number" name="savetype" value="2" hidden/>
            <input class="form-control billtype" type="number" name="billtype" value="0" hidden/>
            <input class="form-control feetype" type="number" name="feetype" value="0" hidden/>

            <label>Check No.</label>
            <input type="text" class="form-control" id="checknum" name="checknum" />
            <label>Check Name</label>
            <input type="text" class="form-control" id="checkname" name="checkname" />
            <label>Amount in Pesos</label>
            <input type="number" min=0 class="form-control" id="checkamt" name="checkamt" />
            <label>Date of Check</label>
            <input type="date" class="form-control" id="checkdate" name="checkdate" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savecheck">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setPaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setpayment">
            <input class="form-control" type="number" name="did" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" name="billid" value="{{$incdoc->b_id}}" hidden/>
            <input class="form-control" type="number" name="savetype" value="3" hidden/>
            <input class="form-control billtype" type="number" name="billtype" value="0" hidden/>
            <input class="form-control feetype" type="number" name="feetype" value="0" hidden/>

            <label>Check No.</label>
            <input type="text" class="form-control" id="checknumpayment" disabled />
            <label>Check Name</label>
            <input type="text" class="form-control" id="checknamepayment" disabled/>
            <label>Amount in Pesos</label>
            <input type="number" class="form-control" id="checkamtpayment" disabled />
            <label>Released to (First Name) (MI) (Last Name)</label>
            <input type="text" class="form-control" id="releasedto" name="releasedto" />
            <label>OR Number</label>
            <input type="text" class="form-control" id="ornum" name="ornum" />
            <label>Date Released</label>
            <input type="date" class="form-control" id="datereleased" name="datereleased" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savepayment">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {

  function setCheckDetails(btid) {

    var bid = $('#doc_bid').val();

    $.ajax ({
     url : '../getcheckinfo?bid='+bid+'&btid='+btid
     ,method : 'GET'
     ,cache : false
     ,beforeSend:function() {
     //$('#loadModal').modal({ backdrop: 'static' });
     }
   }).done( function(response){
     //alert(response);
     //$('#frm_dt').append(response);
     //var jsondata = JSON.parse(response);
     $('#checknumpayment').val(response['check_num']);
     $('#checknamepayment').val(response['check_name']);
     $('#checkamtpayment').val(response['check_amt']);
     //window.open(id,'_self');
   });
  }

  $('#settcDV').on('click', function() {
    $('input.billtype').val(1);
    $('input.feetype').val(1);
  });

  $('#settcCheck').on('click', function() {
    $('input.billtype').val(1);
    $('input.feetype').val(2);
  });

  $('#settcPayment').on('click', function() {

    setCheckDetails(1);

    $('input.billtype').val(1);
    $('input.feetype').val(3);
  });

  $('#setafDV').on('click', function() {
    $('input.billtype').val(2);
    $('input.feetype').val(1);
  });

  $('#setafCheck').on('click', function() {
    $('input.billtype').val(2);
    $('input.feetype').val(2);
  });

  $('#setafPayment').on('click', function() {

    setCheckDetails(2);

    $('input.billtype').val(2);
    $('input.feetype').val(3);
  });

  $('#setefDV').on('click', function() {
    $('input.billtype').val(3);
    $('input.feetype').val(1);
  });

  $('#setefCheck').on('click', function() {
    $('input.billtype').val(3);
    $('input.feetype').val(2);
  });

  $('#setefPayment').on('click', function() {

    setCheckDetails(3);

    $('input.billtype').val(3);
    $('input.feetype').val(3);
  });

  $('#setbaDV').on('click', function() {
   $('input.billtype').val(4);
    $('input.feetype').val(1);
  });

  $('#setbaCheck').on('click', function() {
    $('input.billtype').val(4);
    $('input.feetype').val(2);
  });

  $('#setbaPayment').on('click', function() {

    setCheckDetails(4);

    $('input.billtype').val(4);
    $('input.feetype').val(3);
  });

  $('#settaDV').on('click', function() {
    $('input.billtype').val(5);
    $('input.feetype').val(1);
  });

  $('#settaCheck').on('click', function() {
    $('input.billtype').val(5);
    $('input.feetype').val(2);
  });

  $('#settaPayment').on('click', function() {

    setCheckDetails(5);

    $('input.billtype').val(5);
    $('input.feetype').val(3);
  });

  $('#setsfaDV').on('click', function() {
    $('input.billtype').val(6);
    $('input.feetype').val(1);
  });

  $('#setsfaCheck').on('click', function() {
    $('#billtype').val(6);
    $('#feetype').val(2);
  });

  $('#setsfaPayment').on('click', function() {

    setCheckDetails(6);

    $('#billtype').val(6);
    $('#feetype').val(3);
  });

  function getNet() {
    var a = $('#gross').val();
    var b = $('#tax').val();
    var c = a-b;

    $('#net').val(c);
  }

  $('#gross').on('blur',function() {
    getNet();
  });

  $('#tax').on('blur',function() {
    getNet();
  });

  var v_token = "{{csrf_token()}}";
  //var serialval = $('#frm_setdate').serialize();
  //var billid = $('#billid').val();
  var did = $('#inc_id').val();

    $('#editdoc').on('click', function() {
      $('input').prop('disabled', false);
      $('textarea').prop('disabled', false);
      $('select').prop('disabled', false);
      $('#btnsaveremarks').prop('hidden', false);
      $('#editdoc').prop('hidden', true);
      $('#canceledit').prop('hidden', false);
      $('#deldoc').prop('hidden', false);
      $('#divupload').prop('hidden',false);
      $('#divconcerned').prop('hidden',false);
    });

  $('#canceledit').on('click', function() {
    $('input').prop('disabled', true);
    $('textarea').prop('disabled', true);
    $('select').prop('disabled', true);
    $('#btnsaveremarks').prop('hidden', true);
    $('#editdoc').prop('hidden', false);
    $('#canceledit').prop('hidden', true);
    $('#deldoc').prop('hidden', true);
    $('#divupload').prop('hidden',true);
    $('#divconcerned').prop('hidden',true);
  });

  $('#btnendorse').on('click', function() {

      var frmdocs = $('#frm_docinfo').serialize();

      $.ajax ({
        url : '../set-remarks'
        ,method : 'GET'
        ,data: frmdocs
        ,cache : false
        ,contentType : false
        ,processData : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){
      //alert(response);
      alert('Your record has been saved');
      window.open(did,'_self');
    }).fail( function(response) {
      alert('Sorry, there was an error in saving your record');
    });
  });

  $('#savedv').on('click', function() {

   var frmdv = $('#frm_setdv').serialize();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : frmdv
          ,cache : false
          ,beforeSend:function() {
          //$('#loadModal').modal({ backdrop: 'static' });
          }
        }).done( function(response){
        //alert(response);
        alert('Your record has been saved');
        window.open(did,'_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in saving your record');
      });
  });

  $('#savecheck').on('click', function() {

    var frmcheck = $('#frm_setcheck').serialize();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : frmcheck
          ,cache : false
          ,beforeSend:function() {
          //$('#loadModal').modal({ backdrop: 'static' });
          }
        }).done( function(response){
        //alert(response);
        alert('Your record has been saved');
        window.open(did,'_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in saving your record');
      });
  });

  $('#savepayment').on('click', function() {

    var frmpayment = $('#frm_setpayment').serialize();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : frmpayment
          ,cache : false
          ,beforeSend:function() {
          //$('#loadModal').modal({ backdrop: 'static' });
          }
        }).done( function(response){
        //alert(response);
        alert('Your record has been saved');
        window.open(did,'_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in saving your record');
      });
  });

$('#stafflist').on('change', function() {
    var v = $('#stafflist').val();
    var n = $("#stafflist option:selected").text();
    $('#divaddremarks').append(
      '<a href="#" class="btn btn-lg btn-rem"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg> '+n+'</a>'+
      '<input type="text" name="staffconcerned[]" value="'+v+'" hidden>'
    );
  });

  $('a.staff-remove').on('click', function() {
    $aid = '#'+$(this).data('val');

    $($aid).prop('hidden',true);
    $('#divaddremarks').append('<input type="number" name="removestaffconcerned[]" value="'+$(this).data('val')+'" hidden>');
  });

  $('#ass_date').daterangepicker();

});
</script>
@endsection
