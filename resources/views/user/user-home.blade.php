@include('layouts.app')

<style>
	.opentask {
		width: 25rem;
	}
	.addtask {
		width: 25rem;
	}
</style>

<head>
	<title>Dog Coach Francis - Home</title>
</head>

@foreach($staffinfo as $staff)

@include('layouts.nav-staff')

<div class="container">
  @if(session('success'))
  <div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
      {{ session('success') }}
  </div>
  @endif
	<div class="row">
		<div class="divider">

		</div>
	</div>
	<div class="row">

    <div class="col s8">
      <form id="addlog" method="POST">
      {{ csrf_field() }}
      <div class="card">
					<div class="card-image">
              <img src="{{ asset('images/banners/banner1.jpg') }}">
              <span class="card-title"><b>Log Form</b></span>
            </div>
            <div class="card-content">
              <div class="row">
                <div class="input-field col s12">
                  <textarea name="stafflog" id="stafflog" class="materialize-textarea"></textarea>
                  <label for="stafflog">Staff Log</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s6">
                  <select name="pet">
      							<option value="" disabled selected>Tag a Dog</option>
      						  @foreach($petlist as $pets)
                    <option value="{{ $pets->pet_id }}">{{ $pets->pet_name }}</option>
                    @endforeach
                	</select>
                </div>
                <div class="input-field col s6">
                  <center><button class="btn" id="submit" type="submit">Submit</button></center>
                </div>
              </div>
            </div>
      </div>
      </form>
    </div>

    <div class="col s4">
      <ul class="collection with-header">
				<li class="collection-header green darken-3"><h4 class="blink_me" style="color:white">ACTIVE TASKS</h4></li>
       @forelse($tasklist as $tasks)
          <li class="collection-item"><div>
              @if($tasks->priority_lvl=='2')
                <i class="fa fa-warning" style="color:red;">
              @elseif($tasks->priority_lvl=='1')
                <i class="fa fa-warning" style="color:orange;">
              @else
                <i class="fa fa-warning" style="color:yellow;">
              @endif
            <span style="color:black;"><b>{{ $tasks->task_title }}<b></span></i>
          <a href="#{{ $tasks->task_id }}" class="modal-trigger secondary-content"><i class="fa fa-external-link"></i></a></div></li>

          <div id="{{ $tasks->task_id }}" class="modal card opentask">
        		    <div class="card-content">
                  <span class="card-title">{{ $tasks->task_title }} posted @ {{ $tasks->date }}</span>
                  <h5>"{{ $tasks->task_content }}"</h5>
                </div>
                <div class="card-action">
                  <a href="{{ url('user/task-done/'.$tasks->task_id) }}">Mark as Done</a>
                </div>
          </div>

       @empty
        <li class="collection-item"><div style="color:red;">There are no tasks for today</div></li>
       @endforelse
      </ul>
    </div>

  </div>

</div>

@endforeach

<script>

  $('.modal').modal();

  $('select').material_select();

	function blinker() {
    $('.blink_me').fadeOut(1000);
    $('.blink_me').fadeIn(1000);
	}

	setInterval(blinker, 2000);
</script>
