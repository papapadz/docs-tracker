@extends('layouts.app')
@section('top')
<div class="btn-group mr-2" role="group">
    <button class="btn btn-sm bg-warning" id="a" onclick="printDiv('printDiv')">Print</button>
    @if(Auth::User()->user_level!=2)
    <a class="btn btn-sm bg-success text-white" href="{{url('assessors/new')}}">Add New Assessor</a>
    @endif
</div>
@endsection

@section('content')
@if(Session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> {{Session('success')}}.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<div id="printDiv">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Assessor No.</th>
      <th scope="col">Name of Employee</th>
      <th scope="col">ID No.</th>
      <th scope="col">ID issuance</th>
      <th scope="col">ID expiration</th>
    </tr>
  </thead>
  <tbody>
    @foreach($assessors as $a)
    <tr>
    	<td>{{Carbon\Carbon::parse($a->created_at)->year}}-{{Carbon\Carbon::parse($a->created_at)->format('m')}}-{{$a->assessor_id}}</td>
    	<td><a href="{{url('assessors/view/'.$a->assessor_id)}}">{{$a->lastname}}, {{$a->firstname}} {{$a->middlename}}</td>
    	<td>{{$a->accreditation_id}}</td>
    	<td>{{Carbon\Carbon::parse($a->date_issued)->format('m-d-Y')}}</td>
      @if((\Carbon\Carbon::parse($a->expiry_date)->toDateString() > \Carbon\Carbon::now()->toDateString()) != 1)
      <td style="color:red;">Expired {{Carbon\Carbon::parse($a->expiry_date)->format('m-d-Y')}}</td>
      @else
      <td style="color:green;">{{Carbon\Carbon::parse($a->expiry_date)->format('m-d-Y')}}</td>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection

@section('script')
  <script>
    $('#maintable').DataTable( {
      "order": [ 1, 'asc' ]
    });

    function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			window.open('assessors','_self');
		}
  </script>
@endsection
