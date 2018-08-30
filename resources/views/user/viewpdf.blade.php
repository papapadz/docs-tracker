@extends('layouts.app')
@section('script')
<script>
if(PDFObject.supportsPDFs){
   PDFObject.embed("{{url('certificates/'.$did.'.pdf')}}");
} else {
   alert('error');
}
</script>
@endsection