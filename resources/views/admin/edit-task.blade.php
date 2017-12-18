@include('layouts.app')

<style>
	.card {
		width: 25rem;
	}
</style>

<head>
	<title>Dog Coach Francis - Add New Task</title>
</head>

@include('layouts.nav')
@include('layouts.home-nav')
<div class="container">
<center>

  @if(session('success'))
	<div style="height:2rem;line-height:.5rem;" class="card-panel light-green accent-1">
			{{ session('success') }}
	</div>
	@endif

@foreach($task as $t)
<div class="card center-align">
  <div class="card-content">
      <h4>Edit Task</h4>
     <form class="col s12" method="POST">
       {{ csrf_field() }}
       <div class="row">
        <div class="input-field col s6">
          <input name="task_title" id="task_title" type="text" value="{{$t->task_title}}">
          <label for="task_title">Task Title</label>
        </div>
        <div class="input-field col s6">
          <select name="priority">
            <option value="" disabled selected>Priority Level</option>
            <option @if($t->priority_lvl=='2') selected @endif value="2">High</option>
            <option @if($t->priority_lvl=='1') selected @endif value="1">Medium</option>
            <option @if($t->priority_lvl=='0') selected @endif value="0">Low</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea name="instructions" id="instructions" class="materialize-textarea">{{$t->task_content}}</textarea>
          <label for="instructions">Instructions</label>
        </div>
      </div>
      <button type="submit" class="btn">Update</button>
     </form>
  </div>
</div>
</center>
</div>
@endforeach

<script>
$('select').material_select();
</script>
