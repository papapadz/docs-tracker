@if($incdoc->sfa_stat>=1)
<h5 class="text-warning">Student Financial Assistance</h4>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Disbursement Voucher No.</label>
    <input type="text" class="form-control" name="sfa_dv" disabled="true" value="{{$studentfinasst->dv_num}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>Disbursement Voucher Date</label>
    <input type="date" class="form-control" name="sfa_dv_date" disabled="true" value="{{$studentfinasst->dv_date}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>OBR No.</label>
    <input type="text" class="form-control" name="sfa_obr" disabled="true" value="{{$studentfinasst->obr_num}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>OBR Date</label>
    <input type="date" class="form-control" name="sfa_obr_date" disabled="true" value="{{$studentfinasst->obr_date}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Payee</label>
    <input type="text" class="form-control" name="sfa_payee" disabled="true" value="{{$studentfinasst->payee}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>Serial Number</label>
    <input type="text" class="form-control" name="sfa_serial" disabled="true" value="{{$studentfinasst->serial_num}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Gross Amount</label>
    <input type="number" class="form-control" name="sfa_gross" disabled="true" value="{{$studentfinasst->gross}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>sfax</label>
    <input type="number" class="form-control" name="sfa_sfax" disabled="true" value="{{$studentfinasst->sfax}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Net Amount</label>
    <input type="number" class="form-control" name="sfa_net" disabled="true" value="{{$studentfinasst->net}}"></input>
  </div>
</div>
@endif
@if($incdoc->sfa_stat>=2)
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Check Number</label>
    <input type="text" class="form-control" name="sfa_check_num" disabled="true" value="{{$studentfinasst->check_num}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>Check Name</label>
    <input type="text" class="form-control" name="sfa_check_name" disabled="true" value="{{$studentfinasst->check_name}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Date of Check</label>
    <input type="date" class="form-control" name="sfa_check_date" disabled="true" value="{{$studentfinasst->check_date}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>Check Amount</label>
    <input type="number" class="form-control" name="sfa_check_amt" disabled="true" value="{{$studentfinasst->check_amt}}"></input>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-2">
    <label>Payment Released to</label>
    <input type="text" class="form-control" name="sfa_released_to" disabled="true" value="{{$studentfinasst->released_to}}"></input>
  </div>
  <div class="col-md-6 mb-2">
    <label>Date Released</label>
    <input type="date" class="form-control" name="sfa_release_date" disabled="true" value="{{$studentfinasst->release_date}}"></input>
  </div>
</div>
@endif
