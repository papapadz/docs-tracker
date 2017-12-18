@include('layouts.app')

<style>
.picker__select--month.browser-default {
    float: right;
    margin-right: 2em;
}
</style>

<head>
	<title>Dog Coach Francis - Add New Pet Parent</title>
</head>

@include('layouts.nav')

<div class="container">
  @if(session('success'))
  <div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
      {{ session('success') }}
  </div>
  @endif
  <div class="card">
    <div class="card-content">
    <h5><i class="fa fa-paw"></i> Pet Owner's Information</h5>
      <form class="col s12" id="addparent" method="POST" runat="server" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
					<center>
          <div class="input-field col s12" >
						<img width="150rem" height="150rem" id="blah" src="#" alt="Upload your Picture" />
						<div class="file-field input-field">
              <div class="btn-floating">
                <i class="fa fa-picture-o"></i>
                <input type="file" id="profpic" name="profpic">
              </div>
            </div>
          </div>
				</center>
        </div>

        <div class="row">

          <div class="input-field col s4">
						<input id="lname" type="text" class="validate" name="lname">
						<label for="lname">Surname</label>
					</div>
					<div class="input-field col s4">
						<input id="fname" type="text" class="validate" name="fname">
						<label for="fname">First Name</label>
					</div>
					<div class="input-field col s4">
						<input id="mname" type="text" class="validate" name="mname">
						<label for="mname">Middle Name</label>
					</div>
        </div>

        <div class="row">

          <div class="col s6">
						<input class="with-gap" name="gender" type="radio" id="gender1" checked="true" value="M"  />
            <label for="gender1">Male</label>
            <input class="with-gap" name="gender" type="radio" id="gender2" value="F" />
            <label for="gender2">Female</label>
          </div>
          <div class="col s6">
						<input value="Y" type="checkbox" name="attended" class="filled-in" id="attended" />
						<label for="attended">Have you ever taken your dog to an obedience class before?</label>
          </div>
        </div>

        <div class="row">

          <div class="input-field col s6">
						<input id="emailadd" type="email" name="emailadd">
						<label for="emailadd">Email Address</label>
          </div>
          <div class="input-field col s6">
						<input name="bday" placeholder="Birthday" type="text" class="datepicker">
	        </div>

        </div>

				<div class="row">

          <div class="input-field col s6">
						<input id="homephone" type="tel" name="homephone">
						<label for="homephone">Home Phone Number</label>
          </div>
          <div class="input-field col s6">
						<input id="altphone" type="tel" name="altphone">
						<label for="altphone">Alternate Phone Number</label>
          </div>

        </div>

				<div class="row">

					<div class="input-field col s12">
						<textarea name="homeadd" id="homeadd" class="materialize-textarea"></textarea>
						<label for="homeadd">Home Address</label>
					</div>

				</div>

        <div class="row">

          <div class="input-field col s12">
           <textarea name="job" id="job" class="materialize-textarea"></textarea>
           <label for="job">Company/Job Description/Nature of Business</label>
         </div>

        </div>

				<div class="row">

          <div class="input-field col s12">
           <textarea name="hope" id="hope" class="materialize-textarea"></textarea>
           <label for="hope">What do you hope to get out of this class?</label>
         </div>

        </div>

				<div class="row">

          <div class="input-field col s12">
           <textarea name="hear" id="hear" class="materialize-textarea"></textarea>
           <label for="hear">How did you hear about Dog Coach Francis?</label>
         </div>

        </div>

				<div class="row">

          <div class="input-field col s6">
						<input id="username" type="text" name="username">
 					 <label for="username">Username</label>
         </div>
				 <div class="input-field col s6">
					 <input id="pass" type="password" name="pass">
					<label for="pass">Password</label>
				</div>

        </div>

				<!-- Modal Structure -->
			  <div id="modal1" class="modal modal-fixed-footer">
			    <div class="modal-content">
			      <h4>Waiver and the Terms and Conditions</h4>
			      <p>
							I understand that all dogs are different and they progress at different rates. I understand that Dog Coach Francis, Inc. will make every attempt to help me train my dog to the best of their ability. I understand that I must continue training my dog at home or my dog may revert back to previous behaviors. I understand that by attending training classes at Dog Coach Francis, Inc. that I may be putting myself, my family, my dog and/or any guests who may also attend in a situation not without risk. Some of the dogs I/we may be exposed to could be hard to handle and could cause injury even when handled with the utmost care. I hereby waive and release the trainer, Francis Cleofas, Dog Coach Francis, Inc., their agents and employees from any and all liability for injury or damage to my dog or myself that may be incurred while attending training sessions. I will assume all risk of any injury or damage resulting from the actions of any dog including my own, while on the grounds and any surrounding area or when attending any training function. I understand that I am responsible for furnishing written proof of Rabies, Distemper and Kennel Cough vaccinations before entering the facility &/or the grounds.
						</p>
			    </div>
			    <div class="modal-footer">
			      <button class="btn-flat modal-action modal-close" id="submit" type="submit">Agree</button>
			    </div>
			  </div>

      </form>
			<div class="input-field col s6">
				<center><button class="btn modal-trigger" id="showterms">Save Record</button><center>
			</div>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {

	$(document).on("click", "#showterms", function(){
			$('.modal').modal();
			$('#modal1').modal('open');
	});

  	$('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 96, // Creates a dropdown of 15 years to control year,
      today: 'Today',
      clear: 'Clear',
      close: 'Ok',
      closeOnSelect: false, // Close upon selecting a date,
			max: 'Today',
	    min: new Date(1980, 1, 1),
			format: 'yyyy-mm-dd'
    });

  function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#profpic").change(function() {
  readURL(this);
});

});
</script>
