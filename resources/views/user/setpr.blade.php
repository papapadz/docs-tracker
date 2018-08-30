@if(Auth::User()->user_level!=3)
@section('lowmid')
<a href="#" class="btn btn-sm btn-primary @if($incdoc->status>=2) disabled @endif" id="setorientation" data-toggle="modal" data-target="#setdate" >Orientation Date +</a>
<div class="btn-group mr-2" role="group">
  <a href="#" class="btn btn-sm btn-warning @if($incdoc->status>=3) disabled @endif" id="setstartins" data-toggle="modal" data-target="#setdate">Inspection Start Date +</a>
  <a href="#" class="btn btn-sm btn-warning @if($incdoc->status>=4) disabled @endif" id="setendins" data-toggle="modal" data-target="#setdate">Inspection End Date +</a>
</div>
<div class="btn-group mr-2" role="group">
  <a href="#" class="btn btn-sm btn-success @if($incdoc->status>=5) disabled @endif" id="setsendro" data-toggle="modal" data-target="#setdate">Recommendation to RO Date +</a>
  <a href="#" class="btn btn-sm btn-success @if($incdoc->status>=6) disabled @endif" id="setrecro" data-toggle="modal" data-target="#setdate">Date Received Recommendation +</a>
</div>
<a href="#" class="btn btn-sm btn-info" id="setcptr" data-toggle="modal" data-target="#setdate">CPTR Issuance Date +</a>
<hr>
@endsection
@endif
          @if($incdoc->status>=2)<hr>@endif
          <div class="form-row" @if($incdoc->status<2) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Orientation Date</label>
              <input type="date" class="form-control" name="orientation_date" disabled="true" value="{{$incdoc->orientation_date}}" />
            </div>
          </div>
          @if($incdoc->status>=3)<hr>@endif
          <div class="form-row" @if($incdoc->status<3) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Inspection Start Date</label>
              <input type="date" class="form-control" name="occular_start_date" disabled="true" value="{{$incdoc->occular_start_date}}" />
            </div>
            <div class="col-md-6 mb-3" @if($incdoc->status<4) hidden @endif>
              <label>Inspection End Date</label>
              <input type="date" class="form-control" name="occular_end_date" disabled="true" value="{{$incdoc->occular_end_date}}" />
            </div>
          </div>
          @if($incdoc->status>=4)<hr>@endif
          <div class="form-row" @if($incdoc->status<5) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>Date Released Recommendation to RO</label>
              <input type="date" class="form-control" name="recommendation_date" disabled="true" value="{{$incdoc->recommendation_date}}" />
            </div>
            <div class="col-md-6 mb-3" @if($incdoc->status<6) hidden @endif>
              <label>Date Received Recommendation from RO</label>
              <input type="date" class="form-control" name="recommendation_date_received" disabled="true" value="{{$incdoc->recommendation_date_received}}" />
            </div>
          </div>
          @if($incdoc->status>=7)<hr>@endif
          <div class="form-row" @if($incdoc->status<7) hidden @endif>
            <div class="col-md-6 mb-3">
              <label>CTPR Number</label>
              <input type="text" class="form-control" name="ctpr_num" disabled="true" value="{{$incdoc->ctpr_num}}" />
            </div>
            <div class="col-md-6 mb-3">
              <label>CTPR Issuance Date</label>
              <input type="date" class="form-control" name="ctpr_date_issued" disabled="true" value="{{$incdoc->ctpr_date_issued}}" />
            </div>
          </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Set Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setdate">
            <input class="form-control" type="number" id="docid" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" id="datetype" name="datetype"  hidden/>
            <input class="form-control" type="number" id="prid" name="prid" value="{{$incdoc->pr_id}}" hidden/>
            <div id="appendctpr"></div>
            <label>Date</label>
            <input type="date" class="form-control" id="dateset" name="dateset" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savedate">Save changes</button>
      </div>
    </div>
  </div>
</div>


@section('script')
<script type="text/javascript">

var v_token = "{{csrf_token()}}";
var did = $('#docid').val();

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
    $('#divupload').prop('hidden',false);
  });

  $('#btnsaveremarks').on('click', function() {

    var frmdocs = $('#frm_docinfo').serialize();

      $.ajax ({
        url : '../updateall?'+frmdocs
        ,method : 'GET'
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

  $('#setorientation').on('click', function() {
    $('#datetype').val(1);
  });

  $('#setstartins').on('click', function() {
    $('#datetype').val(2);
  });

  $('#setendins').on('click', function() {
    $('#datetype').val(3);
  });

  $('#setsendro').on('click', function() {
    $('#datetype').val(4);
  });

  $('#setrecro').on('click', function() {
    $('#datetype').val(5);
  });

  $('#setcptr').on('click', function() {
    $('#datetype').val(6);
    $('#appendctpr').append(
      '<label>CTPR Number</label>'+
      '<input type="text" class="form-control" id="ctprnum" name="ctprnum" />'+
      '<label>Number of Days</label>'+
      '<input type="number" class="form-control" id="numdays" name="numdays" />'
      );
  });

  $('#savedate').on('click', function() {

    var prid = $('#prid').val();
    var dateset = $('#dateset').val();
    var datetype = $('#datetype').val();

    var ctprnum = $('#ctprnum').val();
    var numdays = $('#numdays').val();

        $.ajax ({
          url : '../updatepr'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'prid':prid, 'dateset':dateset, 'datetype':datetype, 'ctprnum':ctprnum, 'numdays':numdays, 'did':did }
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
