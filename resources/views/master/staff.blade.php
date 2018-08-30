@extends('layouts.app')
@section('top')
<div class="btn-group mr-2" role="group">
    <button class="btn btn-sm bg-warning" id="a" onclick="printDiv('printDiv')">Print</button>
    @if(Auth::User()->user_level!=2)
    <a class="btn btn-sm bg-success text-white" href="{{url('employees/new')}}">Add New Employee</a>
    @endif
</div>
@endsection

@section('content')
<div id="printDiv">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Employee No.</th>
      <th scope="col">Name of Employee</th>
      <th scope="col">Position</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($staff as $s)
    <tr>
    	<td>{{$s->emp_id}}</td>
    	<td><a href="{{url('employees/view/'.$s->user_id)}}">{{$s->lastname}}, {{$s->firstname}} {{$s->middlename}}</td>
    	<td>{{$s->position}}</td>
    	<td>{{$s->emp_stat}}</td>
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
			window.open('home','_self');
		}
  </script>
@endsection
