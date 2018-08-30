@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <div class="btn-group mr-2" role="group">
    @if(Auth::User()->user_level!=2)
    <button class="btn btn-sm btn-primary" id="editdoc">Edit</button>
    @endif
    <button class="btn btn-sm btn-danger" id="canceledit" hidden="true">Cancel</button>
    <a href="{{url('agencies')}}" class="btn btn-sm btn-warning text-white">Back</a>
    </div>
  </div>
  <div class="card-body">
    <form id="frm_agencydetails">
      {{csrf_field()}}
      <input type="text" value="{{$origin->origin_id}}" name="agency_id" id="agency_id" hidden="true">
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Name of Agency</label>
					<input type="text" class="form-control" name="agency_name" value="{{$origin->origin_name}}" disabled="true"/>
				</div>
				<div class="col-md-6 mb-3">
					<label>Type</label>
					<select class="form-control" name="agency_type" disabled="true" >
						<option value="" disabled selected>Choose a type</option>
						@foreach($atypes as $a)
						<option value="{{$a->agency_type_id}}" @if($a->agency_type_id==$origin->type) selected @endif>{{$a->agency_type}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Address of Agency</label>
					<input type="text" class="form-control" name="agency_address" value="{{$origin->address}}" disabled="true" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Contact Number</label>
					<input type="text" class="form-control" name="agency_contact" value="{{$origin->contact_num}}" disabled="true" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Email Address</label>
					<input type="text" class="form-control" name="agency_email" value="{{$origin->email}}" disabled="true"/>
				</div>
				<div class="col-md-6 mb-3">
					<label>Tin Number</label>
					<input type="text" class="form-control" name="agency_tin" value="{{$origin->tin_num}}" disabled="true" />
				</div>
			</div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Head of Agency</label>
          <input type="text" class="form-control" name="agency_head" value="{{$origin->head_of_origin}}" disabled="true"/>
        </div>
        <div class="col-md-6 mb-3">
          <label>Position of the Head</label>
          <input type="text" class="form-control" name="agency_headpos" value="{{$origin->head_position}}" disabled="true"/>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6 mb-3">
          <label>Contact Person</label>
          <input type="text" class="form-control" name="agency_contactperson" value="{{$origin->contact_person}}" disabled="true"/>
        </div>
        <div class="col-md-6 mb-3">
          <label>Contact No. of Contact Person</label>
          <input type="text" class="form-control" name="agency_contactpersonno" value="{{$origin->contact_person_no}}" disabled="true"/>
        </div>
      </div>
			<div class="form-row">
        <div class="col-md-6 mb-3">
					<label>Description</label>
					<input type="text" class="form-control" name="agency_desc" value="{{$origin->description}}" disabled="true" />
				</div>
			</div>
      <input type="number" name="snum" value="{{$origin->serial_num}}" hidden="true">
    </form>
    <button class="btn btn-success" id="btnsave" hidden="true">Save changes</button>
  </div>
</div>
@endsection

@section('script')
<script>

$('#editdoc').on('click', function() {
  $('input').prop('disabled', false);
  $('textarea').prop('disabled', false);
  $('select').prop('disabled', false);
  $('#btnsave').prop('hidden', false);
  $('#editdoc').prop('hidden', true);
  $('#canceledit').prop('hidden', false);
});

$('#canceledit').on('click', function() {
  $('input').prop('disabled', true);
  $('textarea').prop('disabled', true);
  $('select').prop('disabled', true);
  $('#btnsave').prop('hidden', true);
  $('#editdoc').prop('hidden', false);
  $('#canceledit').prop('hidden', true);
  });

  $('#btnsave').on('click', function() {
      var frm = $('#frm_agencydetails').serialize();
      var id = $('#agency_id').val();

      $.ajax ({
        url : '../update?'+frm
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){
      //alert(response);
      alert('Your record has been saved');
      window.open(id,'_self');
    }).fail( function(response) {
      alert('Sorry, there was an error in saving your record');
    });
  });
</script>
@endsection
