@include('layouts.app')

<style>
	.catcat {
		width: 25rem;
	}
</style>

<head>
	<title>Dog Coach Francis - Home</title>
</head>

@include('layouts.nav')
@include('layouts.home-nav')

<div class="container">
	<div id="petlogs">
				<table class="responsive-table highlight">
					<thead>
						<tr>
							<th>Date</th>
							<th>Staff</th>
							<th>Log</th>
							<th>
								<button class="btn-floating modal-trigger" href="#search"><i class="fa fa-search"></i></button>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse($petloglist as $log)
						<tr>
							<td>{{ $log->date }}</td>
							<td>{{ $log->nickname }}</td>
							<td>
								@if($log->pet_id!=null)
								<a href="{{url('admin/petinfo/'.$log->pet_id)}}">{{ $log->pet_name }}</a>:
								@endif
								{{ $log->task }}
							</td>
							<td>
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="4" style="color:red" >There are no logs.</td>
							</tr>
						@endforelse
						<tr>
							<td colspan="4">
								{{$petloglist->links()}}
							</td>
						</tr>
					</tbody>
				</table>
	</div>
</div>
<!-- Modal Structure -->
	<div id="search" class="modal catcat">
		<div class="modal-content">
			<h4>Search by</h4>
		 <form id="searchForm" method="POST" class="col s12">
			 {{ csrf_field() }}
			  <input class="with-gap" name="category" type="radio" id="cat1" value="1"  />
				 <label for="cat1">Date</label><br>
				 <input class="with-gap" name="category" type="radio" id="cat2" value="2" />
				 <label for="cat2">Pet Care Assistant</label>
				<p>
					<div id="catdate" class="input-field">
						<input name="catdate" placeholder="YYYY-MM-DD" type="text" class="datepicker">
					</div>
					<div id="catreqby" class="input-field">
						<select name="catreqby">
							<option value="" disabled selected>Logged By</option>
							@foreach($stafflist as $staff)
								<option value="{{ $staff->user_id }}">{{ $staff->nickname }}</option>
							@endforeach
						</select>
					</div>
				</p>
			<center><button type="submit" class="btn" name="submit">Search</button></center>
		 </form>
		</div>
	</div>

<script>

	$('.modal').modal();

	$('select').material_select();

	$('#catdate').hide();
	$('#catreqby').hide();

	$(document).on("click", "#cat1", function(){
		$('#catdate').show();
		$('#catreqby').hide();
	});

	$(document).on("click", "#cat2", function(){
		$('#catdate').hide();
		$('#catreqby').show();
	});
</script>
