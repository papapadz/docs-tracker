@extends('layouts.app')
@section('script')
<script>
if(PDFObject.supportsPDFs){
   PDFObject.embed("{{url('files/'.$did.'.pdf')}}");
} else {
   alert('error');
}
</script>
@endsection
