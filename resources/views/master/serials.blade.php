@extends('layouts.app')
@section('top')
<h1 class="h2">Settings - Serial Numbers</h1>
@endsection
@section('content')
<div class="card">
  <div class="card-header">
    <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#addModal">Add New</button>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <div class="input-group mb-3">
        <select class="custom-select" placeholder="Choose type of document" id="select_serial" name="select_serial" required>
            <option value="0" disabled selected>Choose a Series</option>
            @foreach($serials as $sn)
            <option value="{{ $sn->serial_id }}" > {{ $sn->serial_no_start }} to {{ $sn->serial_no_end }} </option>
            @endforeach
        </select>
        <div class="input-group-append">
          <button class="btn btn-primary" data-toggle="modal" data-target="#editModal" type="button" id="editdt">Edit</button>
          <button class="btn btn-danger" @if(Auth::User()->user_level!=1) disabled="true" @endif type="button" id="deldt">Delete</button>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Serial Number Series</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_dt">
          <input type="text" name="sid" id="sid" hidden>
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label>Start of Serial Number</label>
              <input type="text" class="form-control" id="sns" name="sns" />
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label>End of Serial Numnber</label>
              <input type="text" class="form-control" id="sne" name="sne" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnsaveedit">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Serial Number Series</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_add">
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label>Start of Serial Number</label>
              <input type="text" class="form-control" id="sns" name="sns" />
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label>End of Serial Number</label>
              <input type="text" class="form-control" id="sne" name="sne" />
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btnadd">Save Record</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>


$('#editdt').on('click', function() {

  var id = $('#select_serial').val();

     $.ajax ({
      url : '../settings/getserialnuminfo?id='+id
      ,method : 'GET'
      ,cache : false
      ,beforeSend:function() {
      //$('#loadModal').modal({ backdrop: 'static' });
      }
    }).done( function(response){
      //alert(response);
      //$('#frm_dt').append(response);
      var jsondata = JSON.parse(response);
      $('#sid').val(jsondata['serial_id']);
      $('#sns').val(jsondata['serial_no_start']);
      $('#sne').val(jsondata['serial_no_end']);
      //window.open(id,'_self');
    });
});

$('#btnsaveedit').on('click', function() {

  var id = $('#select_serial').val();

  var thisform = $('#frm_dt').serialize();

  if(confirm('Are you sure you want to save your changes?')) {

      $.ajax ({
        url : '../settings/serial-numbers/update?'+thisform
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){

      alert('Your changes has been saved!');
      window.open('../settings/serial-numbers','_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in saving your record');
      });
    }
});

$('#btnadd').on('click', function() {

  var thisform = $('#frm_add').serialize();

  if(confirm('Are you sure you want to save your changes?')) {

      $.ajax ({
        url : '../settings/serial-numbers/add?'+thisform
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){

      alert('Your changes has been saved!');
      window.open('../settings/document-types','_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in saving your record');
      });
    }
});

$('#deldt').on('click', function() {

  var id = $('#select_serial').val();

  if(confirm('Are you sure you want to delete this record?')) {

      $.ajax ({
        url : '../settings/serial-numbers/delete?id='+id
        ,method : 'GET'
        ,cache : false
        ,beforeSend:function() {
        //$('#loadModal').modal({ backdrop: 'static' });
        }
      }).done( function(response){

      alert('Record has been deleted!');
      window.open('../settings/serial-numbers','_self');
      }).fail( function(response) {
        alert('Sorry, there was an error in deleting the record');
      });
    }
});
</script>
@endsection
