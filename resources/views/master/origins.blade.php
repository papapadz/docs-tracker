@extends('layouts.app')
@section('top')
<div class="btn-group mr-2" role="group">
    <button class="btn btn-sm bg-warning" id="a" onclick="printDiv('printreport')">Print</button>
    @if(Auth::User()->user_level!=2)
    <a class="btn btn-sm bg-success text-white" href="{{url('agencies/new')}}">Add new Agency</a>
    @endif
</div>
@endsection

@section('content')
<div id="printreport">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Agency No.</th>
      <th scope="col">Name of Agency</th>
      <th scope="col">Head of Agency</th>
      <th scope="col">Address</th>
      <th scope="col">Type</th>
    </tr>
  </thead>
  <tbody>
    @foreach($origins as $o)
    <tr>
      <td scope="row">{{Carbon\Carbon::parse($o->created_at)->year}}-{{Carbon\Carbon::parse($o->created_at)->format('m')}}-{{$o->origin_id}}</td>
      <td><a href="{{url('agencies/view/'.$o->origin_id)}}">{{$o->origin_name}} <i data-feather="arrow-right-circle"></i></a></td>
      <td>{{$o->head_of_origin}}</td>
      <td>{{$o->address}}</td>
      <td>{{$o->agency_type}}</td>
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
			window.open('agencies','_self');
		}
  </script>
@endsection
