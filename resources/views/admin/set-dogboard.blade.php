@include('layouts.app')

<style>
	.catcat {
		width: 30rem;
	}
	.addtask {
		width: 25rem;
	}
	img {
		height: 8rem;
		width: 8rem;
	}
</style>

<head>
	<title>Dog Coach Francis - Dog Boarding Enrollment</title>
</head>

@include('layouts.nav')

<div class="container">
<center>
	@if(session('success'))
  <div style="width:30rem;height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
      {{ session('success') }}
  </div>
  @endif

<div class="card catcat">
  <div class="card-content">
      <h4>Dog Boarding Form</h4>
     <form class="col s12" method="POST">
       {{ csrf_field() }}
			 @foreach($petinfo as $pet)
			 <input name="pet_id" value="{{$pet->pet_id}}" type="text" hidden="true">
       <div class="row">
				 <div class="input-field col s6">
 					<img src="@if($pet->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pet->pet_img) }} @endif">
         </div>
				<div class="input-field col s6">
					<h5 class="left-align">{{ $pet->pet_name }}</h5>
					<h6 class="left-align">Breed: {{ $pet->breed }}</h5>
					<h6 class="left-align">Pet Parent: {{ $pet->firstname }} {{ $pet->lastname }}</h5>
        </div>
      </div>
			@if($pet->on_dogboard=="Y")
			<input type="text" name="is_onboard" value="Y" hidden="true">
			@foreach($boardinfo as $bi)
			<input type="text" name="board_id" value="{{ $bi->board_id }}" hidden="true">
      <div class="row">
        <div class="input-field col s6">
					<input name="sdate" placeholder="Start Date" type="text" class="datepicker" value="{{ \Carbon\Carbon::parse($bi->start_date)->format('M j, Y') }}" disabled>
					<label for="sdate">Start of Boarding School</label>
				</div>
				<div class="input-field col s6">
					<input name="edate" placeholder="End Date" type="text" class="datepicker" value="{{ \Carbon\Carbon::parse($bi->end_date)->format('M j, Y') }}" disabled>
					<label for="edate">End of Boarding School</label>
				</div>
			</div>
			<div class="row">
        <div class="input-field col s12">
					<input id="goal" name="goal" type="text" value="{{ $bi->goal }}" disabled>
					<label for="goal">Goals to achieve/Reasons for Dog Boarding</label>
				</div>
			</div>
      <button type="submit" class="btn red">Unenroll</button>
			@endforeach
			@else
			<input type="text" name="is_onboard" value="N" hidden="true">
			<div class="row">
        <div class="input-field col s6">
					<input name="sdate" placeholder="Start Date" type="text" class="datepicker">
					<label for="sdate">Start of Boarding School</label>
				</div>
				<div class="input-field col s6">
					<input name="edate" placeholder="End Date" type="text" class="datepicker">
					<label for="edate">End of Boarding School</label>
				</div>
			</div>
			<div class="row">
        <div class="input-field col s12">
					<input id="goal" name="goal" type="text">
					<label for="goal">Goals to achieve/Reasons for Dog Boarding</label>
				</div>
			</div>
      <button type="submit" class="btn">Enroll</button>
			@endif
			@endforeach
     </form>
  </div>
</div>
</center>
</div>
<script>
$('select').material_select();

$('.datepicker').pickadate({
	selectMonths: true, // Creates a dropdown to control month
	selectYears: 15, // Creates a dropdown of 15 years to control year,
	today: 'Today',
	clear: 'Clear',
	close: 'Ok',
	closeOnSelect: false, // Close upon selecting a date,
	format: 'yyyy-mm-dd'
});
</script>
