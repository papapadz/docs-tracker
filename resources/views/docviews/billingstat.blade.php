@if($incdoc->tc_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Training Cost.
  </div>
@elseif($incdoc->tc_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Training Cost.
  </div>
@elseif($incdoc->tc_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Training Cost.
  </div>
@endif
@if($incdoc->af_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Assessment Fee.
  </div>
@elseif($incdoc->af_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Assessment Fee.
  </div>
@elseif($incdoc->af_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Assessment Fee.
  </div>
@endif
@if($incdoc->ef_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Entrep Fee.
  </div>
@elseif($incdoc->ef_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Entrep Fee.
  </div>
@elseif($incdoc->ef_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Entrep Fee.
  </div>
@endif
@if($incdoc->ba_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Book Allowance.
  </div>
@elseif($incdoc->ba_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Book Allowance.
  </div>
@elseif($incdoc->ba_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Book Allowance.
  </div>
@endif
@if($incdoc->ta_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Training Allowance.
  </div>
@elseif($incdoc->ta_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Training Allowance.
  </div>
@elseif($incdoc->ta_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Training Allowance.
  </div>
@endif
@if($incdoc->sfa_stat==1)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  DV and OBR numbers has been prepared for the Student Financial Assistance.
  </div>
@elseif($incdoc->sfa_stat==2)
  <div class="alert alert-warning" role="alert"><b>Status: </b>
  Check has been prepared for the Student Financial Assistance.
  </div>
@elseif($incdoc->sfa_stat==3)
  <div class="alert alert-success" role="alert"><b>Status: </b>
  Released the Payment for the Student Financial Assistance.
  </div>
@endif
