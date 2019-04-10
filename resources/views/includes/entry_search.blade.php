<div class="row">
    <div class="col-xs-12 text-right">
        <form method="get" action="{{ route('entry_list') }}" class="form form-inline">
            <input type="text" name="s" placeholder="Search Keywords" value="{{ $s ? $s : Request::old('s') }}" class="form-control keyword-box"/>
            <button title="Search Author, Title" class="btn btn-primary" type="submit" name="search_shallow" value="1">Search</button>
            <button title="Search All" class="btn btn-primary" type="submit" name="search_deep" value="1">Search +</button>
            <a title="Clear filters" class="btn btn-primary" href="{{ route('entry_list') }}">Reset</a>
        </form>
    </div>
</div>