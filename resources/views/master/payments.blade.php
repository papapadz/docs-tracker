@extends('layouts.app')
@section('top')
<div class="btn-group mr-2" role="group">
    <button class="btn btn-sm bg-warning" id="a" onclick="printDiv('printreport')">Print</button>
</div>
@endsection

@section('content')
<div id="printreport">
<table id="maintable" class="table">
  <thead>
    <tr>
      <th scope="col">Payment Code</th>
      <th scope="col">Billing Type</th>
      <th scope="col">Serial Number</th>
      <th scope="col">Amount</th>
      <th scope="col">Released to</th>
      <th scope="col">Release Date</th>
    </tr>
  </thead>
  <tbody>
    @foreach($payments as $p)
    <tr>
      <td scope="row"><a href="{{url('document/'.$p->doc_id)}}">{{$p->client_type}}-{{Carbon\Carbon::parse($p->release_date)->year}}-{{$p->doc_id}} <i data-feather="arrow-right-circle"></i></a></td>
      <td>{{$p->billing_type}}</td>
      <td>{{$p->serial_num}}</td>
      <td>
        <?php
          echo 'Php '.number_format($p->check_amt,2);
        ?>
      </td>
      <td>{{$p->released_to}}</td>
      <td>{{Carbon\Carbon::parse($p->release_date)->format('F d, Y')}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
@endsection
@section('script')
  <script>

  function format1(n, currency) {
    return currency + n.toFixed(2).replace(/./g, function(c, i, a) {
      return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
  }

    $('#maintable').DataTable( {
      "order": [ 0, 'asc' ]
    });

    function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			window.open('payments','_self');
		}
  </script>
@endsection
