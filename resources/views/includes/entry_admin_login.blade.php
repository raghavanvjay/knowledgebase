@if(Auth::check())
    <span class="label label-warning label-block label-lg">{{ Auth::user()->username }}</span>
    <span class="label label-warning label-block label-lg">Level {{ Auth::user()->level }}</span>
    <a class="btn btn-primary btn-block" href="{{ route('admin_login', ['a'=>'logout'] )}}">Logout</a>
@else
<form method="post" action="{{ route('admin_login') }}" class="form form-horizontal">
    <input type="text" name="username" placeholder="Username" value="" class="form-control"/>
    <input type="password" name="password" placeholder="Password" value="" class="form-control"/>
    <button title="Login" class="btn btn-primary btn-block" type="submit" name="admin_login" value="1">Login</button>
    <input type="hidden" name="_token" value="{{  Session::token() }}" />
</form>
@endif