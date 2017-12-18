@include('layouts.app')

<style>
	.catcat {
		width: 15rem;
	}
	.addtask {
		width: 25rem;
	}
</style>

<head>
	<title>Dog Coach Francis - Home</title>
</head>

@include('layouts.nav')
@include('layouts.home-nav')

<div class="container" id="tasks">
			<table class="responsive-table highlight">
				<thead>
					<tr>
						<th>Task</th>
						<th>Instructions</th>
						<th>Date Posted</th>
						<th>Status</th>
						<th>
							<button class="btn-floating modal-trigger" href="#search"><i class="fa fa-search"></i></button>
							<a id="add" class="waves-effect waves-teal btn-floating green" href="{{ url('/admin/add-task') }}" ><i class="fa fa-plus"></i></a>
						</th>
					</tr>
				</thead>
				<tbody>
					@forelse($tasklist as $tasks)
					<tr>
						<td>{{ $tasks->task_title }}</td>
						<td>{{ $tasks->task_content }}</td>
						<td>{{ $tasks->date }}</td>
						<td>
							@if($tasks->status==0)
								Task still active
							@else
								Task done
							@endif
						</td>
						<td>
								@if($tasks->status==0)
									<a class="tooltipped" data-tooltip="Edit" href="{{ url('admin/edit-task/'.$tasks->task_id) }}"><i class="fa fa-pencil-square-o"></i></a>&nbsp;
									<a class="tooltipped" data-tooltip="Delete" href="{{ url('admin/delete-task/'.$tasks->task_id) }}"><i class="fa fa-trash" style="color:red"></i></a>
								@else
									<a class="tooltipped" data-tooltip="Mark as Undone" href="{{ url('admin/set-taskstat/'.$tasks->task_id) }}">
									<i class="fa fa-check-square-o" style="color:green"></i>
								@endif
							</a>&nbsp;
						</td>
					</tr>
					@empty
						<tr>
							<td colspan="4" style="color:red" >There are no set tasks.</td>
						</tr>
					@endforelse
					<tr>
						<td colspan="4">
							{{$tasklist->links()}}
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
			 <p>
				 <input class="with-gap" name="category" type="radio" id="cat1" value="1"  />
				 <label for="cat1">Task Title</label>
				 <input class="with-gap" name="category" type="radio" id="cat2" value="2" />
				 <label for="cat2">Date Posted</label>
				 <input class="with-gap" name="category" type="radio" id="cat3" value="3" />
				 <label for="cat3">Status</label>
				</p>
				<p>
					<div id="cattask" class="input-field">
						<input  type="text" name="cattask">
						<label for="cattask">Enter Task Title</label>
					</div>
					<div id="catdate" class="input-field">
						<input name="catdate" placeholder="YYYY-MM-DD" type="text" class="datepicker">
					</div>
					<div id="catstat">
						<input class="with-gap" name="catstat" type="radio" id="cs1" value="0" />
						<label for="cs1">Active Tasks</label>
						<input class="with-gap" name="catstat" type="radio" id="cs2" value="1" />
						<label for="cs2">Finished Tasks</label>
					</div>
				</p>
			<center><button type="submit" class="btn" name="submit">Search</button></center>
		 </form>
		</div>
	</div>

	<script>

		$('.modal').modal();

		$('select').material_select();

		$('#cattask').hide();
		$('#catdate').hide();
		$('#catstat').hide();

		$(document).on("click", "#cat1", function(){
			$('#cattask').show();
			$('#catdate').hide();
			$('#catstat').hide();
		});

		$(document).on("click", "#cat2", function(){
			$('#cattask').hide();
			$('#catdate').show();
			$('#catstat').hide();
		});

		$(document).on("click", "#cat3", function(){
			$('#cattask').hide();
			$('#catdate').hide();
			$('#catstat').show();
		});

	</script>
