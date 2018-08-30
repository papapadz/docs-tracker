@extends('layouts.app')
@section('top')
<h1 class="h2">New Incoming Document</h1>
@endsection
@section('content')
  <div class="card">
    <div class="card-body">
      <form id="newincoming" method="POST" action="{{ url('home') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-row">
          <div class="col-md-4 mb-3">
            <label for="origin">Origin of Document</label>
            <select class="custom-select" id="origin" name="origin" required>
                <option value="" disabled selected>Choose Origin</option>
                @foreach($origins as $origs)
                <option value="{{ $origs->origin_id }}" > {{ $origs->origin_name }} </option>
                @endforeach
                <option value="0" > New... </option>
            </select>
          </div>
          <div class="col-md-4 mb-3">
            <label for="origin">Type of Certification</label>
            <select class="custom-select" id="certtype" name="certtype" required>
                <option value="" disabled selected>Choose type of Certification</option>
                @foreach($agency as $a)
                <option value="{{ $a->agency_type_id }}" > @if($a->agency_type_id==5) Certificate of Accreditation @elseif($a->agency_type_id==6) National TVET Trainers Certificate @endif </option>
                @endforeach
            </select>
          </div>
        </div>

          <div id="appendcontent">

          </div>
          <div class="file-field">
              <div class="btn btn-primary">
                <i class="fa fa-picture-o"></i>
                <input type="file" id="fileupload" name="fileupload">
              </div>
            </div>
      <div class="input-field col s6">
				<center><button class="btn btn-success modal-trigger" id="showterms">Save Record</button><center>
			</div>
    </form>

    </div>
  </div>
@endsection

@section('script')
<script>
$('#certtype').on('change', function() {
  $orig = $('#origin').val();

  if(this.value==5) {

    $('div.val6').remove();

    if($orig==0) {

      $('#appendcontent').append(
      '<div class="form-row val5">'+
      '<div class="col-md-8 mb-3">'+
      '<label for="centername">Name of Assessment Center</label>'+
      '<input id="centername" name="centername" type="text" class="form-control" required>'+
      '</div>'+
      '<div class="col-md-4 mb-3">'+
      '<label for="course">Qualification</label>'+
      '<select class="custom-select" id="course" name="course" required>'+
      '<option value="" disabled selected>Choose Qualification</option>'+
      '@foreach($courses as $c)'+
      '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
      '@endforeach'+
      '</select></div>'+
      '</div>');
    } else {
      $('#appendcontent').append(
      '<div class="form-row val5">'+
      '<div class="col-md-4 mb-3">'+
      '<label for="course">Qualification</label>'+
      '<select class="custom-select" id="course" name="course" required>'+
      '<option value="" disabled selected>Choose Qualification</option>'+
      '@foreach($courses as $c)'+
      '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
      '@endforeach'+
      '</select></div>'+
      '</div>');
    }

  } else if(this.value==6) {
    $('div.val5').remove();
  }
})
</script>
@endsection
