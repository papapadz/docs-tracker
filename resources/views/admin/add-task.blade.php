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

<div class="card center-align">
  <div class="card-content">
      <h4>Add a New Task</h4>
     <form class="col s12" method="POST">
       {{ csrf_field() }}
       <div class="row">
        <div class="input-field col s6">
          <input name="task_title" id="task_title" type="text" class="validate">
          <label for="task_title">Task Title</label>
        </div>
        <div class="input-field col s6">
          <select name="priority">
            <option value="" disabled selected>Priority Level</option>
            <option value="2">High</option>
            <option value="1">Medium</option>
            <option value="0">Low</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <textarea name="instructions" id="instructions" class="materialize-textarea"></textarea>
          <label for="instructions">Instructions</label>
        </div>
      </div>
      <button type="submit" class="btn">Save</button>
     </form>
  </div>
</div>
</center>
</div>
<script>
$('select').material_select();
</script>
