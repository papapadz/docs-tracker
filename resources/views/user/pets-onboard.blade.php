@include('layouts.app')

<style>
		.cardboard {
			height: 16rem;
			width: 15rem;
			display: inline-block;
		}
		.petimg {
			height: 12rem;
			width: 12rem;
		}
</style>

<head>
	<title>Dog Coach Francis - My Logs</title>
</head>

@include('layouts.nav-staff')

<div id="x" class="container">
<center>
@forelse($petlist as $pets)
				<div class="card cardboard">
	        <div class="card-image">
	          <img class="petimg" src="@if($pets->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pets->pet_img) }} @endif" class="circle">
	          <span class="card-title">{{$pets->pet_name}}</span>
	          <a class="btn-floating halfway-fab waves-effect waves-light green" href="{{url('user/pet-profile/'.$pets->pet_id)}}"><i class="fa fa-external-link"></i></a>
	        </div>
	        <div class="card-content">
						<p class="left-align"><i class="fa fa-calendar"></i> Until <bold>{{\Carbon\Carbon::parse($pets->end_date)->format('M j, Y')}} </bold> </p>
	        </div>
	      </div>
@empty
<h4>No dogs on board</h4>
@endforelse
</center>
</div>
