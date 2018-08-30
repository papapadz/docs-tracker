@extends('layouts.app')

@section('top')
<h3>Document No. {{Carbon\Carbon::parse($incdoc->created_at)->year}}-{{Carbon\Carbon::parse($incdoc->created_at)->format('m')}}-{{$incdoc->doc_id}}</h3>
@endsection

@if($incdoc->is_archived!=1 && $incdoc->status != 0)
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
    @if($incdoc->status==2)
      <div class="alert alert-warning" role="alert"><b>Status: </b>Orientation has been conducted.</div>
    @elseif($incdoc->status==3)
      <div class="alert alert-warning" role="alert"><b>Status: </b>On site inspection has been started.</div>
    @elseif($incdoc->status==4)
      <div class="alert alert-warning" role="alert"><b>Status: </b>On site inspection has been done.</div>
    @elseif($incdoc->status==5)
      <div class="alert alert-warning" role="alert"><b>Status: </b>Recommendation has been forwared to Regional Office.</div>
    @elseif($incdoc->status==6)
     <div class="alert alert-warning" role="alert"><b>Status: </b>Recommendation from Regional Office has been received.</div>
    @else
      <div class="alert alert-success" role="alert"><b>Status: </b>CTPR number has been issued.</div>
    @endif
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
          @include('docviews.pr')
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

          @endif
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
          <input type="number" name="prid" value="{{$incdoc->pr_id}}" hidden/>
        </form>
        @if(Auth::User()->user_level==1)
        <a class="btn btn-success text-white" id="btnendorse" @if($incdoc->status>=1) hidden="true" @endif>Save</a>
        @endif
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

@endsection

@section('script')
<script>
$(document).ready(function() {

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
          ,data : {'prid':prid, 'dateset':dateset, 'datetype':datetype, 'ctprnum':ctprnum, 'numdays':numdays, 'did':did }
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


});
</script>
@endsection
