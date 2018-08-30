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
    <label >Number of Pax </label>
    <input type="text" class="form-control" name="numpax" value="{{$incdoc->numpax}}" disabled="true"/>
  </div>
</div>
<div class="form-row">
<div class="col-md-12 mb-3">
    <label >Training Institution </label>
    <input type="text" class="form-control" name="sgdetails" value="{{$incdoc->scholarship_details}}" disabled="true"/>
  </div>
</div>
<div class="form-row">
  <div class="col-md-6 mb-3">
    <label >Type of Scholarship </label>
    <select class="custom-select" id="clienttype" name="clienttype" disabled>
        <option value="" disabled selected>Choose Type of Scholarship</option>
        @foreach($client as $cl)
        <option value="{{ $cl->client_type_id }}" @if($cl->client_type_id ==$incdoc->client_type_id) selected @endif > {{ $cl->client_type }} </option>
        @endforeach
    </select>
  </div>
  <div class="col-md-6 mb-3">
    <label >Amount in Pesos </label>
    <input type="number" class="form-control" name="amt" value="{{$incdoc->bill_amt}}" disabled="true" />
  </div>
</div>
