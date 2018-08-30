@extends('layouts.app')
@section('top')
<h3>New Agency Details</h3>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form id="frm_agencydetails">
			{{csrf_field()}}
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Name of Agency</label>
					<input type="text" class="form-control" name="agency_name" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Type</label>
					<select class="form-control" name="agency_type" required>
						<option value="" disabled selected>Choose a type</option>
						@foreach($atypes as $a)
						<option value="{{$a->agency_type_id}}">{{$a->agency_type}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Address of Agency</label>
					<input type="text" class="form-control" name="agency_address" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Contact Number</label>
					<input type="text" class="form-control" name="agency_contact" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Email Address</label>
					<input type="text" class="form-control" name="agency_email" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Tin Number</label>
					<input type="text" class="form-control" name="agency_tin" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Head of Agency</label>
					<input type="text" class="form-control" name="agency_head" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Position</label>
					<input type="text" class="form-control" name="agency_headpos" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Contact Person</label>
					<input type="text" class="form-control" name="agency_contactperson" />
				</div>
				<div class="col-md-6 mb-3">
					<label>Contact No. of Contact Person</label>
					<input type="text" class="form-control" name="agency_contactpersonno" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Description (optional)</label>
					<input type="text" class="form-control" name="agency_desc" />
				</div>
			</div>
		</form>
		<button class="btn btn-success" id="savedetails" >Save</button>
		<a class="btn btn-danger text-white" href="{{url('agencies')}}">Back</a>
	</div>
</div>
@endsection

@section('script')
<script>

	$('#savedetails').on('click', function() {

		if(confirm('Are you sure you want to save this record?')) {
			
			var frmdocs = $('#frm_agencydetails').serialize();

      $.ajax ({
        url : '../agencies/new/add?'+frmdocs
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){
      //alert(response);
      alert('Your record has been saved');
      window.open('../agencies/new','_self');
    }).fail( function(response) {
      alert('Sorry, there was an error in saving your record');
    });
		}

  });
</script>
@endsection
