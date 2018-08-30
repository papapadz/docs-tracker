<div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Qualification </label>
    <select class="custom-select" id="course" name="course" disabled>
        <option value="" disabled selected>Choose Qualification</option>
        @foreach($courses as $c)
        <option value="{{ $c->course_id }}" @if($c->course_id==$incdoc->course_id) selected @endif > {{ $c->course }} </option>
        @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label >Assessor's Name </label>
    <select class="custom-select" name="assessor" disabled="true">
      @foreach($assessor as $s)
      <option value="{{$s->assessor_id}}" @if($s->assessor_id==$incdoc->assessor_id) selected @endif >{{$s->lastname}}, {{$s->firstname}}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Number of Candidates </label>
    <input type="number" class="form-control" value="{{$incdoc->num_candidates}}" name="numclients" disabled="true" />
  </div>
  <div class="col-md-6 mb-3">
    <label >Client Type </label>
    <select class="custom-select" name="clienttype" disabled="true">
      @foreach($client as $cl)
      <option value="{{$cl->client_type_id}}" @if($cl->client_type_id==$incdoc->client_type) selected @endif >{{$cl->client_type}}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Assessment Date (start) </label>
    <input type="date" class="form-control" name="datestart" value="{{$incdoc->start_date}}" disabled="true" />
  </div>
  <div class="col-md-6 mb-3">
    <label >Assessment Date (end) </label>
    <input type="date" class="form-control" name="dateend" value="{{$incdoc->end_date}}" disabled="true" />
  </div>
</div>
