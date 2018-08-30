@if(Auth::User()->user_level!=3)
@section('mid')
<div class="btn-group mr-2" role="group">
    <a href="#" class="btn btn-sm btn-primary @if($incdoc->status>=2) disabled @endif" id="setresult" data-toggle="modal" data-target="#setresultModal" >Assessment Result +</a>
    <a href="#" class="btn btn-sm btn-warning @if($incdoc->status>=3) disabled @endif" id="setsubmitdate" data-toggle="modal" data-target="#setdateModal">Submission of RWAC and other docs +</a>
</div>
@endsection
@endif
@if($incdoc->status>=2)<hr>@endif
          <div class="form-row" @if($incdoc->status<2) hidden @endif>
            <div class="col-md-6 mb-3" >
              <label>Assessment Result out of <b>{{$incdoc->num_candidates}}</b> candidates</label>
              <input type="number" name="assresult" class="form-control" disabled="true" value="{{$incdoc->assessment_result}}" />
            </div>
            <div class="col-md-6 mb-3" @if($incdoc->status<3) hidden @endif>
              <label>Submission Date of RWAC and other Supporting Documents</label>
              <input type="date" name="rwacsubmit" class="form-control" disabled="true" value="{{$incdoc->docs_submission_date}}" />
            </div>
          </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setresultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Set Assessment Result</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setresult">
            <input class="form-control" type="number" id="docid" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" id="cacid" name="cacid" value="{{$incdoc->cac_id}}" hidden/>
            <label>Assessment Result</label>
            <input type="number" class="form-control" min="0" max="{{$incdoc->num_candidates}}" id="result" name="result" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveresult">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="setdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modaltitle">Set Date of Submission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_setdate">
            <input class="form-control" type="number" id="docid" value="{{$incdoc->doc_id}}" hidden/>
            <input class="form-control" type="number" id="cacid" name="prid" value="{{$incdoc->cac_id}}" hidden/>
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

  var did = $('#docid').val();
  var v_token = "{{csrf_token()}}";

  $('#saveresult').on('click', function() {

    //var serialval = $('#frm_setdate').serialize();

    var cacid = $('#cacid').val();
    var result = $('#result').val();

        $.ajax ({
          url : '../updatecac'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'cacid':cacid, 'result':result, 'savetype':1, 'did':did }
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

  $('#savedate').on('click', function() {

    //var serialval = $('#frm_setdate').serialize();

    var cacid = $('#cacid').val();
    var dateset = $('#dateset').val();
    var savetype = $('#savetype').val();

        $.ajax ({
          url : '../updatecac'
          ,method : 'GET'
          ,data : {'_token=':v_token, 'cacid':cacid, 'dateset':dateset, 'savetype':2, 'did':did }
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
