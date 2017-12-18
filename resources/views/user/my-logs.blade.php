@include('layouts.app')

<style>
		.catcat {
			width: 25rem;
		}
</style>

<head>
	<title>Dog Coach Francis - My Logs</title>
</head>

@include('layouts.nav-staff')

<div class="container">
  @if(session('success'))
  <div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
      {{ session('success') }}
  </div>
  @endif

	<table class="responsive-table highlight">
		<thead>
			<tr>
				<th>Date</th>
				<th>Log</th>
				<th>
					<a class="waves-effect waves-teal btn-floating green" href="{{ url('/user/user-home') }}" ><i class="fa fa-plus"></i></a>
					<button class="btn-floating modal-trigger" href="#search"><i class="fa fa-search"></i></button>
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse($petloglist as $log)
			<tr>
				<td>{{ $log->date }}</td>
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

<!-- Modal Structure -->
	<div id="search" class="modal catcat">
		<div class="modal-content">
			<h4>Search by</h4>
		 <form id="searchForm" method="POST" class="col s12">
			 {{ csrf_field() }}
			  	<div id="catdate" class="input-field">
						<input name="catdate" placeholder="YYYY-MM-DD" type="text" class="datepicker">
					</div>
				</p>
			<center><button type="submit" class="btn" name="submit">Search</button></center>
		 </form>
		</div>
	</div>

<script>
$('.modal').modal();

</script>
