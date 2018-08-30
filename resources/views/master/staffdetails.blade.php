@extends('layouts.app')
@section('top')
<h3>Employee Details</h3>
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="btn-group mr-2" role="group">
			@if(Auth::User()->user_level==1)
	    <button class="btn btn-sm btn-primary" id="editdoc">Edit</button>
			@endif
	    <button class="btn btn-sm btn-danger" id="canceledit" hidden="true">Cancel</button>
	    <a href="{{url('employees')}}" class="btn btn-sm btn-warning text-white">Back</a>
		</div>
	  </div>
	<div class="card-body">
		<form id="frm_empdetails">
			{{csrf_field()}}
			<input type="text" value="{{$staff->user_id}}" name="user_id" id="user_id" hidden="true">
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label>Employee No.</label>
					<input type="text" class="form-control" name="emp_id" value="{{$staff->emp_id}}" disabled="true" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-4 mb-3">
					<label>Last Name</label>
					<input type="text" class="form-control" name="lastname" value="{{$staff->lastname}}" disabled="true" />
				</div>
				<div class="col-md-4 mb-3">
					<label>First Name</label>
					<input type="text" class="form-control" name="firstname" value="{{$staff->firstname}}" disabled="true" />
				</div>
				<div class="col-md-4 mb-3">
					<label>Middle Name</label>
					<input type="text" class="form-control" name="middlename" value="{{$staff->middlename}}" disabled="true" />
				</div>
			</div>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Position</label>
					<input type="text" class="form-control" name="position" value="{{$staff->position}}" disabled="true" >
				</div>
				<div class="col-md-6 mb-3">
					<label>Employment Status</label>
					<select type="text" class="form-control" name="emp_stat" disabled="true">
						<option value="" disabled selected>Choose Employment Status</option>
						<option value="Permanent" @if($staff->emp_stat=="Permanent") selected @endif>Permanent</option>
						<option value="Contract of Service" @if($staff->emp_stat=="Contract of Service") selected @endif>Contract of Service</option>
						<option value="Job Order" @if($staff->emp_stat=="Job Order") selected @endif>Job Order</option>
					</select>
				</div>
			</div>
			<hr>
			<div class="form-row">
				<div class="col-md-6 mb-3">
					<label>Username</label>
					<input type="text" class="form-control" name="username" id="username" value="{{$staff->username}}" disabled="true">
				</div>
				<div class="col-md-6 mb-3">
					<label>Account Type</label>
					<select type="text" class="form-control" name="user_level" id="user_level" disabled="true">
						<option value="" disabled selected>Choose Type of Account</option>
						<option value="1" @if($staff->user_level==1) selected @endif>Administrator</option>
						<option value="2" @if($staff->user_level==2) selected @endif>User Level</option>
						<option value="3" @if($staff->user_level==3) selected @endif>Receiving Level</option>
					</select>
				</div>
			</div>

			<div class="form-check" id="updateloginDiv" hidden="true">
			  <input class="form-check-input" type="checkbox" name="updatelogin" id="updatelogin" value="Y" >
			  <label class="form-check-label" for="updatelogin">
			    I want also to update my login details
			  </label>
			</div>
			<br>
			<div id="logindetailsDiv" hidden="true">
			<div id="divpass1" class="form-row" >
				<div class="col-md-6 mb-3">
					<label>Password</label>
					<input type="password" class="form-control" id="pass1" name="pass1">
				</div>
			</div>
			<div id="divpass2" class="form-row" >
				<div class="col-md-6 mb-3">
					<label>Re-type Password</label>
					<input type="password" class="form-control" id="pass2" name="pass2">
				</div>
			</div>
			</div>
		</form>
		<button class="btn btn-success" id="savedetails" disabled="true" hidden="true">Save Record</button>
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
	  $('#logindetailsDiv').prop('hidden', true);
	  $('#savedetails').prop('hidden', false);
	  $('#username').prop('disabled', true);
	  $('#user_level').prop('disabled', true);
	  $('#updateloginDiv').prop('hidden',false);
	  $('#savedetails').prop('disabled',false);
	});

	$('#canceledit').on('click', function() {
	  $('input').prop('disabled', true);
	  $('textarea').prop('disabled', true);
	  $('select').prop('disabled', true);
	  $('#editdoc').prop('hidden', false);
	  $('#canceledit').prop('hidden', true);
	  $('#logindetailsDiv').prop('hidden', true);
	  $('#savedetails').prop('hidden', true);
	  $('#updateloginDiv').prop('hidden',true);
	  $('#savedetails').prop('disabled',true);
	 });

	$('#savedetails').on('click', function() {

	  var id = $('#user_id').val();
      var frmdocs = $('#frm_empdetails').serialize();

      $.ajax ({
        url : '../update?'+frmdocs
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

	$('#updatelogin').click(function(){
	  if($('#updatelogin').prop('checked')) {
	    $('#updatelogin').value = 'Y';
	    $('#logindetailsDiv').prop('hidden',false);
	    $('#username').prop('disabled',false);
	    $('#user_level').prop('disabled',false);
	    $('#savedetails').prop('disabled',true);
	  }
	  else {
	    $('#updatelogin').value = 'N';
	    $('#logindetailsDiv').prop('hidden',true);
	    $('#username').prop('disabled',true);
	    $('#user_level').prop('disabled',true);
	    $('#savedetails').prop('disabled',false);
	  }
	});
</script>
@endsection
