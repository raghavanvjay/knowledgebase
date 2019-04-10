@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h1>Welcome {{ $name }}!</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
    </div>
    @if(! empty($result))
    <div class="row">
        <div class="col-xs-12">
            <h1>Code Result</h1>
            @if(is_array($result))
                <pre>{{ print_r($result) }}</pre>
            @else
            <p>{!! $result !!}</p>
            @endif
        </div>
    </div>
    @endif
@endsection

@section('title')
LaraTrain
@endsection
