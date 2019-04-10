@extends('../layouts.master')
@section('content')
<div class="content">
    <h1>Contact Us</h1>
    <p> <strong>Thank you.</strong>  Your query has been recieved and will be looked at shortly.  We'll get back to you ASAP!. </p>
    <p> The following is your query.</p>
    <p> Query: {{ $query }}</p>
    <p> You may continue to enjoy our content till then.</p>

</div>
@endsection

@section('title')
LaraTrain : ThankYou
@endsection