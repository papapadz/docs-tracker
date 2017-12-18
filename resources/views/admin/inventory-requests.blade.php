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
	@if(session('success'))
	<div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
	{{ session('success') }}
	</div>
	@endif
	@if(session('disapproved'))
	<div style="height:2rem;line-height:.5rem;" class="card-panel red accent-1">
	{{ session('disapproved') }}
	</div>
	@endif
<div id="inventory">
			<table class="responsive-table highlight">
				<thead>
					<tr>
						<th>Item Name</th>
						<th>Qty</th>
						<th>Date Requested</th>
						<th>Days left</th>
						<th>Requested by</th>
						<th>Status</th>
						<th>
							<button class="btn-floating modal-trigger" href="#search"><i class="fa fa-search"></i></button>
						</th>
					</tr>
				</thead>
				<tbody>
					@forelse($inventorylist as $inv)
					<tr>
						<td>{{ $inv->item }}</td>
						<td>{{ $inv->qty }} {{ $inv->unit }}</td>
						<td>{{ $inv->date }}</td>
						<td>{{ $inv->daysleft }}</td>
						<td>{{ $inv->nickname }}</td>
						<td>
							@if($inv->status==0)
								Item pending
							@elseif($inv->status==1)
								Item approved
							@else
								Item disapproved
							@endif
						</td>
						<td>
							<a class="tooltipped" data-tooltip="Approve" href="{{ url('admin/approve-request/'.$inv->inventoryreq_id) }}"><i class="fa fa-thumbs-o-up"></i></a>&nbsp;
							<a class="tooltipped" data-tooltip="Disapprove" href="{{ url('admin/disapprove-request/'.$inv->inventoryreq_id) }}"><i class="fa fa-thumbs-o-down" style="color:red"></i></a>
						</td>
					</tr>
					@empty
						<tr>
							<td colspan="7" style="color:red" >There are no inventory requests.</td>
						</tr>
					@endforelse
					<tr>
						<td colspan="7">
							{{$inventorylist->links()}}
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
				 <label for="cat1">Item Name</label><br>
				 <input class="with-gap" name="category" type="radio" id="cat2" value="2" />
				 <label for="cat2">Date Requested</label><br>
				 <input class="with-gap" name="category" type="radio" id="cat3" value="3" />
				 <label for="cat3">Requested by</label><br>
				 <input class="with-gap" name="category" type="radio" id="cat4" value="4" />
				 <label for="cat4">Status</label>
				<p>
					<div id="catitem" class="input-field">
						<input  type="text" name="catitem">
						<label for="catitem">Item Name</label>
					</div>
					<div id="catdate" class="input-field">
						<input name="catdate" placeholder="YYYY-MM-DD" type="text" class="datepicker">
					</div>
					<div id="catreqby" class="input-field">
						<select name="staff">
							<option value="" disabled selected>Requested by</option>
							@foreach($stafflist as $staff)
								<option value="{{ $staff->user_id }}">{{ $staff->nickname }}</option>
							@endforeach
						</select>
					</div>
					<div id="catstat">
						<input class="with-gap" name="catstat" type="radio" id="cs1" value="0" />
						<label for="cs1">Pending Items</label><br>
						<input class="with-gap" name="catstat" type="radio" id="cs2" value="1" />
						<label for="cs2">Approved Items</label><br>
						<input class="with-gap" name="catstat" type="radio" id="cs3" value="2" />
						<label for="cs3">Disapproved Items</label><br>
					</div>
				</p>
			<center><button type="submit" class="btn" name="submit">Search</button></center>
		 </form>
		</div>
	</div>
<script>

	$('.modal').modal();

	$('select').material_select();

	$('#catitem').hide();
	$('#catdate').hide();
	$('#catreqby').hide();
	$('#catstat').hide();

	$(document).on("click", "#cat1", function(){
		$('#catitem').show();
		$('#catdate').hide();
		$('#catreqby').hide();
		$('#catstat').hide();
	});

	$(document).on("click", "#cat2", function(){
		$('#catitem').hide();
		$('#catdate').show();
		$('#catreqby').hide();
		$('#catstat').hide();
	});

	$(document).on("click", "#cat3", function(){
		$('#catitem').hide();
		$('#catdate').hide();
		$('#catreqby').show();
		$('#catstat').hide();
	});

	$(document).on("click", "#cat4", function(){
		$('#catitem').hide();
		$('#catdate').hide();
		$('#catreqby').hide();
		$('#catstat').show();
	});

</script>
