@extends('layouts.app')
@section('top')
<h3>New Employee Details</h3>
@endsection

@section('content')
<div class="card">
	<div class="card-body">
		<form id="frm_empdetails">
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label>Employee No.</label>
					<input type="text" class="form-control" name="emp_id" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label>Last Name</label>
					<input type="text" class="form-control" name="lastname" />
				</div>
				<div class="col-md-4 mb-3">
					<label>First Name</label>
					<input type="text" class="form-control" name="firstname" />
				</div>
				<div class="col-md-4 mb-3">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="middlename" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Position</label>
					<input type="text" class="form-control" name="position">
				</div>
				<div class="col-md-6 mb-3">
					<label>Employment Status</label>
					<select type="text" class="form-control" name="emp_stat">
						<option value="" disabled selected>Choose Employment Status</option>
						<option value="Permanent">Permanent</option>
						<option value="Contract of Service">Contract of Service</option>
						<option value="Job Order">Job Order</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Username</label>
					<input type="text" class="form-control" name="username">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Password</label>
					<input type="password" class="form-control" id="pass1" name="pass1">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Re-type Password</label>
					<input type="password" class="form-control" id="pass2" name="pass2">
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Account Type</label>
					<select type="text" class="form-control" name="user_level">
						<option value="" disabled selected>Choose Type of Account</option>
						<option value="1">Administrator</option>
						<option value="2">User Level</option>
						<option value="3">Receiving Level</option>
					</select>
				</div>
			</div>
		</form>
		<button class="btn btn-success" id="savedetails" disabled="true">Save Record</button>
		<a class="btn btn-danger text-white" href="{{url('employees')}}">Back</a>
	</div>
</div>
@endsection

@section('script')
<script>

	$('#savedetails').on('click', function() {
      var frmdocs = $('#frm_empdetails').serialize();

      $.ajax ({
        url : '../employees/new/add?'+frmdocs
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){
      //alert(response);
      alert('Your record has been saved');
      window.open('../employees/new','_self');
    }).fail( function(response) {
      alert('Sorry, there was an error in saving your record');
    });
  });
	
	$('#pass1').on('change', function() {
		
		var passize = $('#pass1').val();

	    if(passize.length<6) {
	      alert('Password must be atleast 6 characters!');
	      $('#pass1').val('');
	    }
	    
	});

	$('#pass2').on('change', function() {
		if($('#pass2').val()!=$('#pass1').val()) {
	      alert('Passwords does not match!');
	       $('#pass2').val('');
	      $('#savedetails').attr('disabled',true);
	    } else
	    	 $('#savedetails').attr('disabled',false);
	});
</script>
@endsection