<header>
    <nav class="main-nav">
        <ul>
            <li><a href="{{ route('root') }}">Root</a></li>
            <li><a href="{{ route('home', ['name'=>'Vijay']) }}">Home</a></li>
            <li><a href="{{route('entry_list')}}">Knowledge Base</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="{{ route('contact-us') }}">Contact</a></li>
            <li><a href="{{ route('code-sample') }}">Code</a></li>
        </ul>
    </nav>
</header>
