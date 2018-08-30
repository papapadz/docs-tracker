<div class="form-row">
  <div class="col-md-6">
    <label >Qualification </label>
    <select class="custom-select" id="course" name="course" disabled>
        <option value="" disabled selected>Choose Qualification</option>
        @foreach($courses as $c)
        <option value="{{ $c->course_id }}" @if($c->course_id==$incdoc->course_id) selected @endif > {{ $c->course }} </option>
        @endforeach
    </select>
  </div>
</div>
