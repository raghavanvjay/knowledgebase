@extends('layouts.master')
@section('content')
    <div class="content">
        <!--
        <h1>Contact Us</h1>
        <p>Please fill out the contact form if you have any queries.</p>
        <div class="form-errors">
            @if(count($errors) > 0)
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
        </div>

        <div class="contact-form">
            <form action="{{ route('contact-post') }}" method="post">
                <div class="form-row">
                    <label for="full-name">Full Name</label>
                    <input id="full-name" type="text" name="full_name" />
                </div>
                <div class="form-row">
                    <label for="email-id">Email</label>
                    <input id="email-id" type="email" name="email_id" />
                </div>
                <div class="form-row">
                    <label for="query">Your Query</label>
                    <textarea id="query" name="query"></textarea>
                </div>
                <div class="form-row">
                    <button type="submit" value="post_query">Post Query!</button>
                </div>
                <input type="hidden" name="_token" value="{{  Session::token() }}" />
            </form>
        </div>
        -->
        <div id="app"> <!-- ID: 'app' -->
            <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h2>Contact me</h2>
                        </div>
                        <div class="card-body">
                            <!--
                                Our component:
                            -->
                            <example></example>
                            <contact-form></contact-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('title')
LaraTrain : Contact Us
@endsection

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endsection
