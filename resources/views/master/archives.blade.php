@extends('layouts.app')

@section('content')
<div id="printreport">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Document No.</th>
      <th scope="col">Subject</th>
      <th scope="col">Document Type</th>
      <th scope="col">Origin</th>
      <th scope="col">Date Received</th>
      <th scope="col">Archived Since</th>
    </tr>
  </thead>
  <tbody>
    @foreach($docs as $d)
    <tr>
      <td scope="row">{{Carbon\Carbon::parse($d->created_at)->year}}-{{Carbon\Carbon::parse($d->created_at)->format('m')}}-{{$d->doc_id}}</td>
      <td><a href="{{url('document/'.$d->doc_id)}}">{{$d->subject}}  <i data-feather="arrow-right-circle"></i></a></td>
      <td>{{$d->doc_type}}</td>
      <td>{{$d->origin_name}}</td>
      <td>{{Carbon\Carbon::parse($d->created_at)->format('F d, Y')}}</td>
      <td>{{Carbon\Carbon::parse($d->updated_at)->format('F d, Y')}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
@section('script')
  <script>
    $('#maintable').DataTable( {
      "order": [ 0, 'desc' ]
    });

</script>
@endsection
