@extends('layouts.app')
@section('top')
<h1 class="h2">New Document</h1>
@endsection
@section('content')
  <div class="card">
    <div class="card-body">
      <form id="newincoming" method="POST" action="{{ url('home') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input id="doctype" name="doctype" type="number" class="form-control" value="{{ $type_id }}" hidden >

        <div class="form-row">

        <div id="origlist" class="col-md-4 mb-3">
          <label for="origin">Origin of Document</label>
          <select class="custom-select" id="origin" name="origin" required>
              <option value="" disabled selected>Choose Origin</option>
              @foreach($origins as $origs)
              <option value="{{ $origs->origin_id }}" > {{ $origs->origin_name }} </option>
              @endforeach
              <option value="0" > New...</option>
          </select>
        </div>
        <div id="neworig" class="col-md-4 mb-3" hidden="true">
          <label for="neworigin">Origin of Document <a id="showlist" href=#>Show list</a></label>
          <input id="neworigin" name"neworigin" type="text" class="form-control"/>
        </div>
          <div class="col-md-4 mb-3">
						<label for="datedoc">Date of Document</label>
            <input id="datedoc" name="datedoc" placeholder="Date of Document" type="date" class="form-control" required>
          </div>
            <div class="col-md-4 mb-3">
						<label for="dateissued">Date Issued (if applicable)</label>
            <input id="dateissued" name="dateissued" placeholder="Date Issued" type="date" class="form-control" >
          </div>
        </div>

          <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="ctrlnum">Document Control # (if applicable)</label>
                <input id="ctrlnum" name="ctrlnum" placeholder="Document Control #" type="text" class="form-control" >
            </div>

            <div class="col-md-8 mb-3">
				<label for="signatory">Signatory</label>
                <input id="signatory" name="signatory" placeholder="Full Name of Signatory" type="text" class="form-control" required>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="subject">Subject</label>
				        <textarea name="subject" id="subject" class="form-control"></textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="actiontaken">Action Taken</label>
				        <textarea name="actiontaken" id="actiontaken" class="form-control"></textarea>
            </div>
          </div>

          <div id="appendcontent">
          </div>
          <div class="file-field">
              <div class="btn btn-primary">
                <input type="file" id="fileupload" name="fileupload">
              </div>
            </div>
      <div class="input-field col s6">
				<center><button class="btn btn-success">Save Record</button><center>
			</div>
    </form>

    </div>
  </div>
@endsection

@section('script')
<script>
$(document).ready(function() {

  $('#subject').on('blur', function() {
    var dtype = $('#doctype').val();
    var or = $('#origin').val();
    var dt = $('#datedoc').val();
    var sg = $('#signatory').val();
    var sb = $('#subject').val();


    $.ajax ({
     url : '../checkduplicate?doc_type_id='+dtype+'&origin_id='+or+'&doc_date='+dt+'&signatory='+sg+'&subject='+sb
     ,method : 'GET'
     ,cache : false
     ,beforeSend:function() {
     //$('#loadModal').modal({ backdrop: 'static' });
     }
   }).done( function(response){

     if(response!=0) {
       alert('A duplicate entry has been found. You are going to be redirected to the Document, press OK');
       window.open('../document/'+response,'_self');
     }
   });
  })

  $('#origin').on('change', function() {

    if(this.value==0) {
      if (confirm("You are going to redirected to a new page, are you sure?"))
        window.open('../agencies/new','_self');
    }
  });

  $('#showlist').on('click', function() {
    $('#origlist').show();
    $('#neworig').attr('hidden',true);
  });

  $('#addc').on('click',function() {
    alert('haha');
  });

  $('#schoolorig').on('change', function() {

    if(this.value==0) {
      $('#schoollist').hide();
      $('#newschool').attr('hidden',false);
    }
  });

  @if($type_id==6)
    $('#appendcontent').append(
    '<div class="form-row">'+
    '<div class="col-md-4 mb-3">'+
    '<label for="course">Qualification</label>'+
    '<select class="custom-select" id="course" name="course" required>'+
    '<option value="" disabled selected>Choose Qualification</option>'+
    '@foreach($courses as $c)'+
    '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
    '@endforeach'+
    '</select></div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="clienttype">Type of Client</label>'+
    '<select class="custom-select" id="clienttype" name="clienttype" required>'+
    '<option value="" disabled selected>Choose Type of Client</option>'+
    '@foreach($clients as $cl)'+
    '<option value="{{ $cl->client_type_id }}" > {{ $cl->client_type }} </option>'+
    '@endforeach'+
    '</select></div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="numclients">Number of Candidates</label>'+
    '<input class="form-control" type="number" id="numclients" name="numclients" placeholder="1 to 10" max="10" min="1">'+
    '</div></div>'+
    '<div class="form-row">'+
    '<div class="col-md-4 mb-3">'+
    '<label for="datedoc">Date of Assessment</label>'+
    '<input id="dateassess" name="dateassess" type="date" class="form-control" required>'+
    '</div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="datedoc">Start of Assessment</label>'+
    '<input id="datestart" name="datestart" type="date" class="form-control" required>'+
    '</div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="datedoc">End of Assessment</label>'+
    '<input id="dateend" name="dateend" type="date" class="form-control" required>'+
    '</div>'+
    '</div>'+
    '<div class="form-row">'+
    '<div class="col-md-6 mb-3">'+
    '<label for="assessor">Name of Assessor</label>'+
    '<select class="custom-select" id="assessor" name="assessor" required>'+
    '<option value="" disabled selected>Choose an Assessor</option>'+
    '@foreach($user as $u)'+
    '<option value="{{ $u->assessor_id }}" > {{ $u->lastname }}, {{ $u->firstname }} - Level {{ $u->level }} </option>'+
    '@endforeach'+
    '</select></div>'+
    '</div>');
  @elseif($type_id==7)
  $('#appendcontent').append(
    '<div class="form-row">'+
    '<div class="col-md-4 mb-3">'+
    '<label for="course">Qualification  </label>'+
    '<select class="custom-select" id="course" name="course" required>'+
    '<option value="" disabled selected>Choose Qualification</option>'+
    '@foreach($courses as $c)'+
    '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
    '@endforeach'+
    '</select></div>'+
    '</div>');
  @elseif($type_id==8)
  $('#appendcontent').append(
    '<div class="form-row">'+
    '<div class="col-md-6 mb-3">'+
    '<label for="sgdetails">Training Institution</label>'+
    '<input id="sgdetails" name="sgdetails" type="text" class="form-control" required>'+
    '</div>'+
    '<div class="col-md-6 mb-3">'+
    '<label for="amt">Amount in Pesos</label>'+
    '<input id="amt" name="amt" type="number" class="form-control" required>'+
    '</div>'+
    '</div>'+
    '<div class="form-row">'+
    '<div class="col-md-4 mb-3">'+
    '<label for="course">Qualification</label>'+
    '<select class="custom-select" id="course" name="course" required>'+
    '<option value="" disabled selected>Choose Qualification</option>'+
    '@foreach($courses as $c)'+
    '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
    '@endforeach'+
    '</select></div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="clienttype">Type of Scholarship</label>'+
    '<select class="custom-select" id="clienttype" name="clienttype" required>'+
    '<option value="" disabled selected>Choose Type of Scholarship</option>'+
    '@foreach($clients as $cl)'+
    '@if($cl->client_type_id!=1)<option value="{{ $cl->client_type_id }}" > {{ $cl->client_type }} </option>@endif'+
    '@endforeach'+
    '</select></div>'+
    '<div class="col-md-4 mb-3">'+
    '<label for="numpax">Number of Persons</label>'+
    '<input id="numpax" name="numpax" type="number" class="form-control" required>'+
    '</div>'+
    '</div>'+
    '<div class=form-row>'+
    '<div class="col-md-4 mb-3">'+
    '<label>Date of Start</label>'+
    '<input type="date" class="form-control" name="start" />'+
    '</div>'+
    '<div class="col-md-4 mb-3">'+
    '<label>Date Finished</label>'+
    '<input type="date" class="form-control" name="end" />'+
    '</div>'+
    '<div class="col-md-4 mb-3">'+
    '<label>Date of Assessment</label>'+
    '<input type="text" class="form-control" name="ass_date" id="ass_date" />'+
    '</div>'+
    '</div>');
  @elseif($type_id==9)
    $('#appendcontent').append(
    '<div class="form-row">'+
    '<div class="col-md-4 mb-3">'+
    '<label for="origin">Type of Certification</label>'+
    '<select class="custom-select" id="certtype" name="certtype" required>'+
    '<option value="" disabled selected>Choose type of Certification</option>'+
    '@foreach($agency as $a)'+
    '<option value="{{ $a->agency_type_id }}" > @if($a->agency_type_id==5) Certificate of Accreditation @elseif($a->agency_type_id==6) National TVET Trainers Certificate @endif </option>'+
    '@endforeach'+
    '</select>'+
    '</div>'+
    '</div>');
  @endif

  $('#certtype').on('change', function() {

    if(this.value==5) {

      $('div.val6').remove();
      $('#appendcontent').append(
      '<div class="form-row val5">'+
      '<div class="col-md-4 mb-3">'+
      '<label for="assname">Name of Assessment Center</label>'+
      '<input class="form-control" type"text" name="assname" />'+
      '</div>'+
      '<div class="col-md-4 mb-3">'+
      '<label for="course">Qualification</label>'+
      '<select class="custom-select" required>'+
      '<option value="" disabled selected>Choose Qualification</option>'+
      '@foreach($courses as $c)'+
      '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
      '@endforeach'+
      '</select></div>'+
      '<div id="appendcourse" class="col-md-6 mb-3">'+
      '</div>'+
      '</div>');
    } else {
      $('div.val5').remove();
      $('#appendcontent').append(
      '<div class="form-row val6">'+
      '<div class="col-md-4 mb-3">'+
      '<label>First Name of Assessor</label>'+
      '<input name="fname" class="form-control" type="text" required/>'+
      '</div>'+
      '<div class="col-md-4 mb-3">'+
      '<label>Middle Name of Assessor</label>'+
      '<input name="mname" class="form-control" type="text" />'+
      '</div>'+
      '<div class="col-md-4 mb-3">'+
      '<label>Last Name of Assessor</label>'+
      '<input name="lname" class="form-control" type="text" required />'+
      '</div>'+
      '</div>'+
      '<div class="form-row val6">'+
      '<div id="schoollist" class="col-md-4 mb-3">'+
      '<label for="schoolorig">Name of Assessment Center</label>'+
      '<select class="custom-select" id="schoolorig" name="schoolorig" required>'+
      '<option value="" disabled selected>Choose Assessment Center</option>'+
      '@foreach($origins as $origs)'+
      '<option value="{{ $origs->origin_id }}" > {{ $origs->origin_name }} </option>'+
      '@endforeach'+
      '</select>'+
      '</div>'+
      '<div class="col-md-4 mb-3">'+
      '<label for="course">Qualification </label>'+
      '<select class="custom-select" required>'+
      '<option value="" disabled selected>Choose Qualification</option>'+
      '@foreach($courses as $c)'+
      '<option value="{{ $c->course_id }}" > {{ $c->course }} </option>'+
      '@endforeach'+
      '</select></div>'+
      '<div id="appendcourse" class="col-md-6 mb-3">'+
      '</div>'+
      '</div>');
    }
  });

  $('#ass_date').daterangepicker();

});
</script>
@endsection
