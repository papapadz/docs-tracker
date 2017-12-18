@include('layouts.app')

<style>
		.catcat {
			width: 25rem;
		}
</style>

<head>
	<title>Dog Coach Francis - Inventory Requests</title>
</head>

@include('layouts.nav-staff')

<div class="container">
  @if(session('success'))
  <div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
      {{ session('success') }}
  </div>
  @endif

	<div id="inventory">
				<table class="responsive-table highlight">
					<thead>
						<tr>
							<th>Item Name</th>
							<th>Qty</th>
							<th>Date Requested</th>
							<th>Days Left</th>
							<th>Status</th>
							<th>
								<button class="btn-floating modal-trigger" href="#addreq"><i class="fa fa-plus green"></i></button>
								<button class="btn-floating modal-trigger" href="#search"><i class="fa fa-search"></i></button>
							</th>
						</tr>
					</thead>
					<tbody>
						@forelse($inventorylist as $inv)
						<tr>
							<td>{{ $inv->item }}</td>
							<td>{{ $inv->qty }}</td>
							<td>{{ $inv->date }}</td>
							<td>{{ $inv->daysleft }}</td>
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
								<a class="tooltipped" data-tooltip="Cancel Request" href="{{ url('user/cancel-request/'.$inv->inventoryreq_id) }}"><i class="fa fa-close" style="color:red"></i></a>&nbsp;
							</td>
						</tr>
						@empty
							<tr>
								<td colspan="6" style="color:red" >You have no inventory requests.</td>
							</tr>
						@endforelse
						<tr>
							<td colspan="6">
								{{$inventorylist->links()}}
							</td>
						</tr>
					</tbody>
				</table>
	</div>
	</div>
</div>

<!-- Modal Structure -->
	<div id="search" class="modal catcat">
		<div class="modal-content">
			<h4>Search by</h4>
		 <form id="searchForm" method="POST" action="{{ url('user/search-request') }}" class="col s12">
			 {{ csrf_field() }}
			  <input class="with-gap" name="category" type="radio" id="cat1" value="1"  />
				 <label for="cat1">Item Name</label><br>
				 <input class="with-gap" name="category" type="radio" id="cat2" value="2" />
				 <label for="cat2">Date Requested</label><br>
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

	<!-- Modal Structure -->
		<div id="addreq" class="modal catcat">
			<div class="modal-content">
			 <form id="searchForm" method="POST" class="col s12">
				 {{ csrf_field() }}
				 <center><h5>Inventory Request Form</h5></center>
				<div class="row">
					<div class="input-field col s12">
						<input type="text" name="item" id="item"></textarea>
						<label for="item">Name of Item</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s3">
						<input type="number" name="qty" id="qty"></textarea>
						<label for="qty">Quantity</label>
					</div>
					<div class="input-field col s6">
						<select name="unit">
							<option value="bag" selected>Bag</option>
							<option value="bottle">Bottle</option>
							<option value="box">Box</option>
							<option value="can">Can</option>
							<option value="pack">Pack</option>
							<option value="pc">Piece</option>
							<option value="sachet">Sachet</option>
						</select>
					</div>
					<div class="input-field col s3">
						<input type="number" name="daysleft" id="daysleft"></textarea>
						<label for="daysleft">Days left</label>
					</div>
				</div>
				<center><button type="submit" class="btn" name="submit">Add Request</button></center>
			 </form>
			</div>
		</div>

<script>
$('.modal').modal();

$('select').material_select();

$('#catitem').hide();
$('#catdate').hide();
$('#catstat').hide();

$(document).on("click", "#cat1", function(){
	$('#catitem').show();
	$('#catdate').hide();
	$('#catstat').hide();
});

$(document).on("click", "#cat2", function(){
	$('#catitem').hide();
	$('#catdate').show();
	$('#catstat').hide();
});

$(document).on("click", "#cat4", function(){
	$('#catitem').hide();
	$('#catdate').hide();
	$('#catstat').show();
});
</script>
