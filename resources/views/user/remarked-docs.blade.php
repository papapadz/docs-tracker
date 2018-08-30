@extends('layouts.app')
@section('top')
    <div class="btn-group mr-2" role="group">
      <button class="btn btn-sm bg-warning" id="a" onclick="printDiv('printreport')">Print</button>
    </div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> {{session('success')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>
@endif
<div id="printreport">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Document No.</th>
      <th scope="col">Subject</th>
      <th scope="col">Document type</th>
      <th scope="col">Signatory</th>
      <th scope="col">Origin</th>
      <th scope="col">Endorsed</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    @foreach($docs as $d)
    <tr>
      <td scope="row">{{Carbon\Carbon::parse($d->created_at)->year}}-{{Carbon\Carbon::parse($d->created_at)->format('m')}}-{{$d->doc_id}}</td>
      <td><a href="{{url('document/'.$d->doc_id)}}">{{$d->subject}}  <i data-feather="arrow-right-circle"></i></a></td>
      <td>{{$d->doc_type}}</td>
      <td>{{$d->signatory}}</td>
      <td>{{$d->origin_name}}</td>
      <td>{{Carbon\Carbon::parse($d->doc_endorsed)->format('F d, Y')}} at {{Carbon\Carbon::parse($d->doc_endorsed)->format('h:i A')}}</td>
      <td>
        @if($d->status==0)
          <p class="text-danger">No Remarks yet</p>
        @elseif($d->status==1)
          <p class="text-primary">Endorsed to Person/s concerned</p>
        @else
          @if($d->doc_type_id==6)
            @if($d->status==2)
              <p class="text-warning">Results have been posted</p>
            @else
              <p class="text-success">RWAC and other docs submitted</p>
            @endif
          @elseif($d->doc_type_id==7)
            @if($d->status==2)
              <p class="text-warning">Orientation conducted</p>
            @elseif($d->status==3)
              <p class="text-warning">Started Occular Inspection</p>
            @elseif($d->status==4)
              <p class="text-warning">Finished Occular Inspection</p>
            @elseif($d->status==5)
              <p class="text-warning">Submitted Recommendation to RO</p>
            @elseif($d->status==6)
              <p class="text-warning">Recommendation Received from RO</p>
            @else
              <p class="text-success">Issued CTPR Number</p>
            @endif
          @elseif($d->doc_type_id==8)
            @if($d->status==21)
              <p class="text-warning">Prepared DV for Training Cost</p>
            @elseif($d->status==31)
              <p class="text-warning">Prepared Check for Training Cost</p>
            @elseif($d->status==41)
              <p class="text-success">Released Payment for Training Cost</p>
            @elseif($d->status==22)
              <p class="text-warning">Prepared DV for Training Cost</p>
            @elseif($d->status==32)
              <p class="text-warning">Prepared Check for Assessment Fee</p>
            @elseif($d->status==42)
              <p class="text-success">Released Payment for Assessment Fee</p>
            @elseif($d->status==23)
              <p class="text-warning">Prepared DV for Entrep Fee</p>
            @elseif($d->status==33)
              <p class="text-warning">Prepared Check for Entrep Fee</p>
            @elseif($d->status==43)
              <p class="text-success">Released Payment for Entrep Fee</p>
            @elseif($d->status==24)
              <p class="text-warning">Prepared DV for Book Allowance</p>
            @elseif($d->status==34)
              <p class="text-warning">Prepared Check for Book Allowance</p>
            @elseif($d->status==44)
              <p class="text-success">Released Payment for Book Allowance</p>
            @elseif($d->status==25)
              <p class="text-warning">Prepared DV for Training Allowance</p>
            @elseif($d->status==35)
              <p class="text-warning">Prepared Check for Training Allowance</p>
            @elseif($d->status==45)
              <p class="text-success">Released Payment for Training Allowance</p>
            @elseif($d->status==26)
              <p class="text-warning">Prepared DV for Student Financial Assistance</p>
            @elseif($d->status==36)
              <p class="text-warning">Prepared Check for Student Financial Assistance</p>
            @elseif($d->status==46)
              <p class="text-success">Released Payment for Student Financial Assistance</p>
            @endif
          @else
            <p class="text-success">Marked as Done</p>
          @endif
        @endif
      </td>
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

    function printDiv(divName){
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      window.open('endorsements','_self');
    }
  </script>
@endsection