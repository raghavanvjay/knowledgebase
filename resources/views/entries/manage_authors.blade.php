@extends('layouts.entry_template')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <section class="search-entry">
            @include('includes.entry_search')
        </section>
        <section class="list-entry">
            <div class="listing-header">Listing Authors : Recent First</div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Name</th><th>Status</th><th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($authors) > 0)
                        @foreach($authors as $i=>$author)
                        <tr class="">
                            <td>{{ $i+1 }}</td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control author-name" placeholder="Author Name" name="author_{{ $author->id }}" id="author_{{ $author->id }}" value="{{ stripslashes($author->name) }}">
                                    <span class="input-group-btn">
                                        <button title = "Save" class="btn btn-secondary save_author" type="button" data-id="{{ $author->id }}" name="save_author"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" class="form-control author-status-label" placeholder="Author Name" name="author_{{ $author->id }}" id="author_status_{{ $author->id }}" value="{{ $author->status == 1 ? 'Active' : 'Inactive' }}" readonly="readonly">
                                    <span class="input-group-btn" id="author_toggle_{{ $author->id }}">
                                        <button title = "{{ $author->status == 1 ? 'Inactivate' : 'Activate' }}" class="btn btn-secondary toggle_author_status" type="button" data-id="{{ $author->id }}"><span class="glyphicon {{ $author->status == 1 ? 'glyphicon-thumbs-down' : 'glyphicon-thumbs-up' }}"></span></button>
                                    </span>
                                </div>

                            </td>
                            <td class="">{{ $author->created_at }}</td>
                        </tr>
                         @endforeach
                    @else
                        <tr><td colspan="3">No authors to list</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection

@section('title')
KnowledgeBase::Manage - List
@endsection

@section('scripts')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ URL::to('js/manage_authors.js') }} "></script>
@endsection