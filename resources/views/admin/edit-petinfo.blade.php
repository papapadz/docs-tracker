@include('layouts.app')

<head>
	<title>Dog Coach Francis - Edit Pet</title>
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
    <h5><i class="fa fa-paw"></i> Pet Information Sheet</h5>
      <form class="col s12" id="addpet" method="POST" runat="server" enctype="multipart/form-data">
				<input id="pid" name="pid" value="{{ $petinfo->pet_id }}" type="text" hidden="true">
				{{ csrf_field() }}
        <div class="row">

          <div class="input-field col s6">
              <input id="key" type="text" class="validate" name="dogname" value="{{ $petinfo->pet_name }}">
              <label for="key">Dog's Name</label>
          </div>
          <div class="col s1">
            <div class="file-field input-field">
              <div class="btn-floating">
                <i class="fa fa-picture-o"></i>
                <input type="file" id="dogpic" name="dogpic">
              </div>
            </div>
          </div>
          <div class="input-field col s5" >
            <center><img style="height:8rem;width:8rem;" id="blah" src="@if($petinfo->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$petinfo->pet_img) }} @endif" alt="Upload your Dog's Picture" /></center>
          </div>
        </div>

        <div class="row">

          <div class="input-field col s6">
            <select name="dogbreed">
							<option value="" disabled selected>Choose Dog Breed</option>
						@foreach($breedlist as $dogbreeds)
              <option @if($petinfo->breed==$dogbreeds->breed_id) selected @endif value="{{ $dogbreeds->breed_id }}" > {{ $dogbreeds->breed }} </option>
            @endforeach
          </select>
          <label>Dog Breed</label>
					</div>
          <div class="input-field col s6">
            <input name="dogbday" placeholder="Birthday" type="text" class="datepicker" value="{{$petinfo->birthdate}}">
          </div>
        </div>

        <div class="row">

          <div class="col s6">
              Color
              <input name="color" value="{{$petinfo->color}}" type="color" id="color">
          </div>
          <div class="col s6">
            <input class="with-gap" name="doggender" type="radio" id="gender1" @if($petinfo->gender=='M') checked="true" @endif value="M"  />
            <label for="gender1">Male</label>
            <input class="with-gap" name="doggender" type="radio" id="gender2" @if($petinfo->gender=='F') checked="true" @endif value="F" />
            <label for="gender2">Female</label>
          </div>
        </div>

        <div class="row">

          <div class="col s4">
              <input @if($petinfo->reproductive_surgery=='Y') checked="true" @endif value="Y" type="checkbox" name="dogsurgery" class="filled-in" id="surgery" />
              <label for="surgery">Spayed/Neutered</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->on_vaccine=='Y') checked="true" @endif value="Y" type="checkbox" name="dogvacc" class="filled-in" id="vacc" />
              <label for="vacc">On Vaccine</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->bug_prevention=='Y') checked="true" @endif value="Y" type="checkbox" name="dogftprev" class="filled-in" id="ftprev" />
              <label for="ftprev">Flea and Tick Prevented</label>
          </div>

        </div>

        <div class="row">

          <div class="input-field col s12">
           <textarea name="dogdesc" id="dog_desc" class="materialize-textarea">{{ $petinfo->description }}</textarea>
           <label for="dog_desc">Dog Description</label>
         </div>

        </div>

        <div class="row">

          <div class="col s4">
              <input @if($petinfo->w_collar=='Y') checked="true" @endif value="Y" type="checkbox" name="dogcollar" class="filled-in" id="wc" />
              <label for="wc">Collar</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->w_leash=='Y') checked="true" @endif value="Y" type="checkbox" name="dogleash" class="filled-in" id="wl" />
              <label for="wl">Leash</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->w_tag=='Y') checked="true" @endif value="Y" type="checkbox" name="dogtag" class="filled-in" id="wt" />
              <label for="wt">Tag</label>
          </div>

        </div>

        <div class="row">

          <div class="col s4">
              <input @if($petinfo->is_crated=='Y') checked="true" @endif value="Y" type="checkbox" name="dogcrate" class="filled-in" id="ic" />
              <label for="ic">Crated</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->is_runofhouse=='Y') checked="true" @endif value="Y" type="checkbox" name="dogrun" class="filled-in" id="ir" />
              <label for="ir">Run off House</label>
          </div>
          <div class="col s4">
              <input @if($petinfo->is_outdoors=='Y') checked="true" @endif value="Y" type="checkbox" name="dogout" class="filled-in" id="io" />
              <label for="io">Outdoors</label>
          </div>

        </div>

        <div class="row">

          <div class="input-field col s12">
           <textarea name="doglimit" id="limit" class="materialize-textarea">{{ $petinfo->limited_to }}</textarea>
           <label for="limit">Limited to</label>
         </div>

        </div>

        <div class="row">
          <div class="input-field col s6">
              <input value="{{ $petinfo->favtoys }}" id="favtoy" type="text" name="dogfavtoy">
              <label for="favtoy">Favorite Toy</label>
          </div>
          <div class="input-field col s6">
            <input value="{{ $petinfo->food }}" id="favfood" type="text" name="dogfavfood">
            <label for="favfood">Favorite Food</label>
          </div>
        </div>

        <div class="row input_fields_wrap">
					<div class="input-field col s12">
	          Add Feeding Time &nbsp;&nbsp;<button class="btn-floating green add_field_button" id="addf"><i class="fa fa-plus"></i></button>
	        </div>

				@foreach($ftime as $ft)
				<div class="col s12">
				<div class="input-field col s6"><input value="{{ $ft->time }}" type="text" class="timepicker" placeholder="Feeding Time" name="dogftime[]"></div>
				<div class="input-field col s5"><input value="{{ $ft->food }}" type="text" id="food" name="dogfood[]"><label for="food">Food</label></div>
				<button id="{{ $ft->ft_id }}" class="btn-floating remove_field red"><i class="fa fa-times"></i></button><br><br></div>
				@endforeach

        </div>

        <div class="row">

          <div class="input-field col s12">
           <textarea name="dogfeedins" id="feedins" class="materialize-textarea">{{ $petinfo->feeding_ins }}</textarea>
           <label for="feedins">Feeding Instruction</label>
         </div>

        </div>

        <div class="row input_med_wrap">
					<div class="input-field col s12">
	          Add Medication &nbsp;&nbsp;<button class="btn-floating green add_med_button"><i class="fa fa-plus"></i></button>
	        </div>
					@foreach($meds as $m)
					<div class="col s12">
						<div class="input-field col s3">
							<input type="text" id="med" name="med[]" value="{{ $m->medicine }}">
							<label for="med">Medication</label>
						</div>
						<div class="input-field col s2">
							<input type="text" id="dosage" name="dosage[]" value="{{ $m->dosage }}">
							<label for="dosage">Dosage</label>
						</div>
						<button id="{{ $m->prescription_id }}" class="btn-floating remove_med red"><i class="fa fa-times"></i></button><br>
					</div>
					@endforeach
				</div>
				<br>
				<div class="row">
          <div class="col s3">
            <input @if($petinfo->is_sit=='Y') checked="true" @endif value="Y" type="checkbox" name="dogsit" class="filled-in" id="cs" />
            <label for="cs">Sit</label>
						</div>
          <div class="col s3">
            <input @if($petinfo->is_stay=='Y') checked="true" @endif value="Y" value="Y" type="checkbox" name="dogstay" class="filled-in" id="cst" />
            <label for="cst">Stay</label>
					</div>
					<div class="col s3">
            <input @if($petinfo->is_come=='Y') checked="true" @endif value="Y" value="Y" type="checkbox" name="dogcome" class="filled-in" id="cc" />
            <label for="cc">Come</label>
          </div>
          <div class="col s3">
            <input @if($petinfo->is_down=='Y') checked="true" @endif value="Y" value="Y" type="checkbox" name="dogcome" class="filled-in" id="cd" />
            <label for="cd">Down</label>
          </div>
        </div>
				<br>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="othercomm" name="dogothercomm" class="materialize-textarea">{{ $petinfo->other_commands }}</textarea>
            <label for="othercomm">Other known commands (Pls. separate with commas)</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <textarea id="walkins" name="dogwalkins" class="materialize-textarea">{{ $petinfo->walk_ins }}</textarea>
            <label for="walkins">Walking Instruction</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <textarea id="prec" name="dogprec" class="materialize-textarea">{{ $petinfo->precautions }}</textarea>
            <label for="prec">Pet Precautions</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12">
            <textarea id="otherinfo" name="dogotherinfo" class="materialize-textarea">{{ $petinfo->additional_info }}</textarea>
            <label for="otherinfo">Additional information</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s6">
            <select name="dogparent">
              @foreach($userslist as $users)
                <option @if($petinfo->user_id==$users->user_id) selected @endif value="{{ $users->user_id }}"> {{ $users->firstname }} {{ $users->lastname }} </option>
              @endforeach
            </select>
          <label>Pet Parent</label>
          </div>
        <div class="input-field col s6">
          <center><button class="btn" id="submit" type="submit">Update Record</button><center>
        </div>
      </div>
		</form>
    </div>
  </div>
</div>
<script>
$(document).ready(function() {

	$('select').material_select();

	$('#ch').on('click',function() {

	});

  $('form').on('focus',".timepicker", function(){
    $(this).pickatime();
  });

  	$('.datepicker').pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 15, // Creates a dropdown of 15 years to control year,
      today: 'Today',
      clear: 'Clear',
      close: 'Ok',
      closeOnSelect: false, // Close upon selecting a date,
			format: 'yyyy-mm-dd'
    });

    $('.timepicker').pickatime({
    default: 'now', // Set default time: 'now', '1:30AM', '16:30'
    twelvehour: true, // Use AM/PM or 24-hour format
    donetext: 'OK', // text for done-button
    cleartext: 'Clear', // text for clear-button
    canceltext: 'Cancel', // Text for cancel-button
    autoclose: false, // automatic close timepicker
    ampmclickable: true, // make AM PM clickable
		//aftershow: function(){} //Function for after opening timepicker
    });

    var max_fields      = 5; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(wrapper).append(
            '<div class="col s12">'+
            '<div class="input-field col s6"><input type="text" class="timepicker" placeholder="Feeding Time" name="dogftime[]"></div>'+
            '<div class="input-field col s5"><input type="text" id="food" name="dogfood[]" /><label for="food">Food</label></div>'+
            '<button class="btn-floating remove_field red"><i class="fa fa-times"></i></button><br><br></div>'); //add input box
        }
    });

		var medwrapper         = $(".input_med_wrap"); //Fields wrapper
    var medadd_button      = $(".add_med_button"); //Add button ID

    var x = 1; //initlal text box count
    $(medadd_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment

            $(medwrapper).append(
            '<div class="col s12">'+
            '<div class="input-field col s3"><input type="text" id="med" name="med[]" /><label for="med">Medicine</label></div>'+
						'<div class="input-field col s2"><input type="text" id="dosage" name="dosage[]" /><label for="med">Dosage</label></div>'+
            '<button class="btn-floating remove_med red"><i class="fa fa-times"></i></button><br><br></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
				$(wrapper).append('<input value="'+this.id+'" name="todelete[]" hidden="true">');
			//	alert(this.id);
    });

		$(medwrapper).on("click",".remove_med", function(e){ //user click on remove text
				e.preventDefault(); $(this).parent('div').remove(); x--;
				$(medwrapper).append('<input value="'+this.id+'" name="todeletemed[]" hidden="true">');
			//	alert(this.id);
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

$("#dogpic").change(function() {
  readURL(this);
});

});
</script>
