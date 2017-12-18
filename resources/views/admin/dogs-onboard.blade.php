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
	@forelse($petlist as $pet)

	<div class="card">
		<div class="card-image">
        <img src="@if($pet->pet_img=='') {{ asset('images/dog-avatar.png') }} @else {{ asset('images/pets/'.$pet->pet_img) }} @endif">
    </div>
		<div class="card-content">
			<i class="fa fa-paw"></i><a style="color:primary;" href="{{url('admin/petinfo/'.$pet->pet_id)}}">{{$pet->pet_name}}</a>
		</div>
	</div>
	@empty
	<h4 class="red lighten-3"><i>There are no Dogs on Boarding School right now</i></h4>
	@endforelse
	</center>
</div>


<script>
$(document).ready(function(){

});
</script>
