@if(Auth::User()->user_level!=3)
@section('mid')
<div class="btn-group mr-2" role="group">
    <a href="#" class="btn btn-sm btn-primary @if($incdoc->status>=2) disabled @endif" id="setdv" data-toggle="modal" data-target="#setdvModal" >Disbursement Voucher No. +</a>
    <a href="#" class="btn btn-sm btn-success @if($incdoc->status>=3) disabled @endif" id="setcheck" data-toggle="modal" data-target="#setcheckModal">Check +</a>
    <a href="#" class="btn btn-sm btn-info @if($incdoc->status>=4) disabled @endif" id="setpayment" data-toggle="modal" data-target="#setpaymentModal">Payment +</a>
</div>
@endsection
@endif
  @if($incdoc->status>=2)<hr>@endif
          <div class="form-row" @if($incdoc->status<2) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Disbursement Voucher No.</label>
              <input id="setdvnum" name="dv_num" type="text" class="form-control" disabled="true" value="{{$incdoc->dv_num}}" />
            </div>
          </div>
          <div class="form-row" @if($incdoc->status<2) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Gross Amount in Pesos</label>
              <input type="number" class="form-control" name="gross_amt" disabled="true" value="{{$incdoc->gross_amt}}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Net Amount in Pesos</label>
              <input type="number" class="form-control" name="net_amt" disabled="true" value="{{$incdoc->net_amt}}" />
            </div>
          </div>
          @if($incdoc->status>=3)<hr>@endif
          <div class="form-row" @if($incdoc->status<3) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Check No.</label>
              <input type="text" class="form-control" name="check_num" disabled="true" value="{{$incdoc->check_num}}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Name of Check</label>
              <input type="text" class="form-control" name="check_name" disabled="true" value="{{$incdoc->check_name}}" />
            </div>
          </div>
          <div class="form-row" @if($incdoc->status<3) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Amount of Check in Pesos</label>
              <input type="number" class="form-control" name="check_amt" disabled="true" value="{{$incdoc->check_amt}}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Date of Check</label>
              <input type="date" class="form-control" name="check_date" disabled="true" value="{{$incdoc->check_date}}" />
            </div>
          </div>
          @if($incdoc->status>=4)<hr>@endif
          <div class="form-row" @if($incdoc->status<4) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Released to</label>
              <input type="text" class="form-control" name="released_to" disabled="true" value="{{$incdoc->released_to}}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>Date Check Released</label>
              <input type="date" class="form-control" name="release_date" disabled="true" value="{{Carbon\Carbon::parse($incdoc->release_date)->toDateString()}}" />
            </div>
          </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setdvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Disbursement Voucher Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setresult">
            <input class="form-control" type="number" id="docid" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" id="billid" name="cacid" value="{{$incdoc->billing_id}}" hidden/>
            <label>DV No.</label>
            <input type="text" class="form-control" id="dvnum" name="dvnum" />
            <label>Gross Amount</label>
            <input type="number" min=0 class="form-control" id="gross" name="gross" />
            <label>Net Amount</label>
            <input type="text" min=0 class="form-control" id="net" name="net" />
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
<div class="modal fade" id="setcheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
<div class="modal fade" id="setpaymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setcheck">
            <label>Check No.</label>
            <input type="text" class="form-control" value="{{$incdoc->check_num}}" disabled />
            <label>Check Name</label>
            <input type="text" class="form-control" value="{{$incdoc->check_name}}" disabled/>
            <label>Amount in Pesos</label>
            <input type="number" class="form-control" value="{{$incdoc->check_amt}}" disabled />
            <label>Released to (First Name) (MI) (Last Name)</label>
            <input type="text" class="form-control" id="releasedto" name="releasedto" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savepayment">Save changes</button>
      </div>
    </div>
  </div>
</div>


@section('script')
<script type="text/javascript">

var v_token = "{{csrf_token()}}";
var did = $('#docid').val();
//var serialval = $('#frm_setdate').serialize();
var billid = $('#billid').val();

  $('#editdoc').on('click', function() {
    $('input').prop('disabled', false);
    $('textarea').prop('disabled', false);
    $('select').prop('disabled', false);
    $('#btnsaveremarks').prop('hidden', false);
    $('#editdoc').prop('hidden', true);
    $('#canceledit').prop('hidden', false);
    $('#deldoc').prop('hidden', false);
    $('#divupload').prop('hidden',false);
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
  });

  $('#btnsaveremarks').on('click', function() {

    var formdata = false;
    if (window.FormData){
        formdata = new FormData($('#frm_docinfo').get(0));
    }

    var frmdocs = $('#frm_docinfo').serialize();
      $.ajax ({
        url : '../updateall'
        ,method : 'POST'
        ,data: formdata ? formdata : frmdocs
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

    var dvnum = $('#dvnum').val();
    var gross = $('#gross').val();
    var net = $('#net').val();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'billid':billid, 'dvnum':dvnum, 'gross':gross, 'net':net ,'savetype':1, 'did':did }
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

    var checknum = $('#checknum').val();
    var checkname = $('#checkname').val();
    var checkamt = $('#checkamt').val();
    var checkdate = $('#checkdate').val();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'billid':billid, 'checknum':checknum, 'checkname':checkname, 'checkamt':checkamt ,'checkdate':checkdate,'savetype':2, 'did':did }
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

    var releasedto = $('#releasedto').val();

        $.ajax ({
          url : '../updatebill'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'billid':billid, 'releasedto':releasedto,'savetype':3, 'did':did }
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

</script>
@endsection
