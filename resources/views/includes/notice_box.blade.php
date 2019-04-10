@if(count($errors) > 0 || Session::has('success') || Session::has('fail'))
<div class="container notice-box">
    @if(count($errors) > 0)
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger" id="danger-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error! </strong><br>
                @foreach($errors->all() as $error)
                     - {{ $error }}<br>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('success'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-success" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Success! </strong> {{ Session::get('success') }}
            </div>
        </div>
    </div>
    @endif

    @if(Session::has('fail'))
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger" id="fail-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Error! </strong> {{ Session::get('fail') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endif