@extends('layouts.app')
@section('top')
<h3>Assessor Details</h3>
@endsection

@section('content')
@if((\Carbon\Carbon::parse($assessor->expiry_date)->toDateString() > \Carbon\Carbon::now()->toDateString()) != 1)
<div class="alert alert-danger" role="alert">
	<b>Notice!</b> This Assessor's License has expired.
</div>
@endif
<div class="card">
	<div class="card-header">
		<div class="btn-group mr-2" role="group">
		<a class="btn btn-sm btn-warning @if($assessor->file==null) disabled @endif" href="{{url('certificate/pdf/'.$assessor->assessor_id)}}" target="_blank" >View Certificate</a>
			@if(Auth::User()->user_level==1)
	    <button class="btn btn-sm btn-primary" id="editdoc">Edit</button>
			@endif
	    <button class="btn btn-sm btn-danger" id="canceledit" hidden="true">Cancel</button>
	    <a href="{{url('assessors')}}" class="btn btn-sm btn-warning text-white">Back</a>
		</div>
		<a class="btn btn-sm btn-danger float-right" id="delass" hidden="true" href="{{url('assessors/delete/'.$assessor->assessor_id)}}" onclick="return confirm('Are you sure want to delete this Record?');">Delete</a>
	  </div>
	<div class="card-body">
		<form id="frm_empdetails" method="POST" action="{{url('assessors/update')}}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="text" value="{{$assessor->assessor_id}}" name="assessor_id" id="assessor_id" hidden="true">
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label>Last Name</label>
					<input type="text" class="form-control" name="lastname" value="{{$assessor->lastname}}" disabled="true" required/>
				</div>
				<div class="col-md-4 mb-3">
					<label>First Name</label>
					<input type="text" class="form-control" name="firstname" value="{{$assessor->firstname}}" disabled="true" required/>
				</div>
				<div class="col-md-4 mb-3">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="middlename" value="{{$assessor->middlename}}" disabled="true" required/>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Accreditation ID No.</label>
					<input type="text" class="form-control" name="accre_id" value="{{$assessor->accreditation_id}}" disabled="true" required>
				</div>
				<div class="col-md-6 mb-3">
					<label>Accreditation Level</label>
					<input type="number" class="form-control" min="1" name="accre_level" value="{{$assessor->level}}" disabled="true" required>
				</div>
			</div>
      <div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Date Issued</label>
					<input type="date" class="form-control" name="date_issued" value="{{$assessor->date_issued}}" disabled="true" required>
				</div>
				<div class="col-md-6 mb-3">
					<label>Expiration Date</label>
					<input type="date" class="form-control" name="date_expiry" value="{{$assessor->expiry_date}}" disabled="true" required>
				</div>
			</div>
			<div class="file-field" id="divupload" hidden="true" >
				<label>Upload Certificate</label><br>
					<div class="btn btn-primary">
						<input type="file" id="fileupload" name="fileupload" >
					</div>
			</div>
				<hr>
				<button class="btn btn-success" id="savedetails" hidden="true" >Save Record</button>
		</form>
	</div>
</div>
@endsection

@section('script')
<script>

	$('#editdoc').on('click', function() {
	  $('input').prop('disabled', false);
	  $('textarea').prop('disabled', false);
	  $('select').prop('disabled', false);
	  $('#editdoc').prop('hidden', true);
	  $('#canceledit').prop('hidden', false);
	  $('#savedetails').prop('hidden', false);
	  $('#username').prop('disabled', true);
	  $('#user_level').prop('disabled', true);
	  $('#savedetails').prop('disabled',false);
	  $('#divupload').prop('hidden',false);
	  $('#delass').prop('hidden',false);
	});

	$('#canceledit').on('click', function() {
	  $('input').prop('disabled', true);
	  $('textarea').prop('disabled', true);
	  $('select').prop('disabled', true);
	  $('#editdoc').prop('hidden', false);
	  $('#canceledit').prop('hidden', true);
	  $('#savedetails').prop('hidden', true);
	  $('#savedetails').prop('disabled',true);
	  $('#divupload').prop('hidden',true);
	  $('#delass').prop('hidden',true);
	 });

	 @if(Session('success'))
	 	alert('Record has been saved!');
	 @endif
	 </script>

</script>
@endsection
