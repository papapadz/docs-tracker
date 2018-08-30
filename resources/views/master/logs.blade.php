@extends('layouts.app')

@section('content')
<div id="printreport">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Document No.</th>
      <th scope="col">Log</th>
      <th scope="col">Staff</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach($log as $d)
    <tr>
      <td scope="row"><a href="{{url('document/'.$d->doc_id)}}">{{Carbon\Carbon::parse($d->created_at)->year}}-{{Carbon\Carbon::parse($d->created_at)->format('m')}}-{{$d->doc_id}} <i data-feather="arrow-right-circle"></i></a></td>
      <td>{{$d->action_taken}}</td>
      <td>{{$d->firstname}} {{$d->lastname}}</td>
      <td>{{Carbon\Carbon::parse($d->log_date)->format('F d, Y - h:i A')}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
@section('script')
  <script>
    $('#maintable').DataTable( {
      "order": [ 3, 'desc' ]
    });

</script>
@endsection
