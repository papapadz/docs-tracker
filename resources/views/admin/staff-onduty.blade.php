@include('layouts.app')

<head>
	<title>Dog Coach Francis - Home</title>
</head>

@include('layouts.nav')
@include('layouts.home-nav')

<style>
    .card {
        height: 15rem;
        width: 15rem;
				display: inline-block;
        align-items: center;
    }
		img {
			height: 12rem;
			width: 12rem;
		}
</style>

<div class="container">
	<center>
	@forelse($stafflist as $staff)

	<div class="card">
		<div class="card-image">
        <img src="@if($staff->user_img=='') {{ asset('images/prof-pic.png') }} @else {{ asset('images/staffs/'.$staff->user_img) }} @endif">
    </div>
		<div class="card-content">
			<a href="staffinfo/{{$staff->user_id}}">{{$staff->nickname}}</a><br>
			<p>{{$staff->time_in}} to {{$staff->time_out}}</p>
		</div>
	</div>
	@empty
	<h4 class="red lighten-3"><i>There are no Pet Care Assistants on duty today</i></h4>
	@endforelse
	</center>
</div>


<script>
$(document).ready(function(){

});
</script>
