@extends('layouts.app')
@section('top')
<h3>New Assessor Details</h3>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form id="frm_empdetails" method="POST" action="{{url('assessors/new/add')}}" enctype="multipart/form-data">
			<div class="form-row">
				{{ csrf_field() }}
				<div class="col-md-4 mb-3">
					<label>Last Name</label>
					<input type="text" class="form-control" name="lastname" required/>
				</div>
				<div class="col-md-4 mb-3">
					<label>First Name</label>
					<input type="text" class="form-control" name="firstname" required/>
				</div>
				<div class="col-md-4 mb-3">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="middlename" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Accreditation ID No.</label>
					<input type="text" class="form-control" name="accre_id" required>
				</div>
				<div class="col-md-6 mb-3">
					<label>Accreditation Level</label>
					<input type="number" class="form-control" min="1" name="accre_level" required>
				</div>
			</div>
      <div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Date Issued</label>
					<input type="date" class="form-control" name="date_issued" required>
				</div>
				<div class="col-md-6 mb-3">
					<label>Expiration Date</label>
					<input type="date" class="form-control" name="date_expiry" required>
				</div>
			</div>
			<div class="file-field">
				<label>Upload Certificate</label><br>
					<div class="btn btn-primary">
						<input type="file" id="fileupload" name="fileupload">
					</div>
				</div>
			<hr>
			<button class="btn btn-success" onclick="return confirm('Are you sure you want to save this record?')" >Save Record</button>
			<a class="btn btn-danger text-white" href="{{url('assessors')}}">Back</a>
		</form>
	</div>
</div>
@endsection

@section('script')
<script>
@if(Session('success'))
	alert('Record has been saved!');
@endif
</script>
@endsection
