<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="main-title-section-wrap">
                    <div class="row">
                        <div class="col-sm-12 col-md-9">
                            <div class="entry-main-title">Knowledge Base Entries</div>
                        </div>
                        <div class="col-sm-12 col-md-3">
                            @include('includes.entry_admin_login')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-default entry-main-nav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('entry_list') }}">KnowledgeBase</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="{{ Request::is('entry/list')? 'active' : ''}}"><a href="{{ route('entry_list') }}">List</a></li>
                        <li class="{{ Request::is('entry/add')? 'active' : ''}}" ><a href="{{ route('entry_add') }}">Add</a></li>
                        @if(Auth::check())
                        <li class="{{ Request::is('manage/entry/list')? 'active' : ''}}"><a href="{{ route('manage_entry_list') }}">Entries</a></li>
                        <li class="{{ Request::is('manage/author*')? 'active' : ''}}"><a href="{{ route('manage_author_list') }}">Authors</a></li>
                        <li class="{{ Request::is('manage/tags')? 'active' : ''}}"><a href="{{ route('manage_tag_list') }}">Tags</a></li>
                        @endif
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
    </div>
</header>