@extends('layouts.entry_template')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <section class="search-entry">
            @include('includes.entry_search')
        </section>
        <section class="list-entry">
            <div class="listing-header">Listing Entries : Recent First</div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th><th>Title</th><th>Author</th><th>Created</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($entries) > 0)
                        @foreach($entries as $i=>$entry)
                        <tr class="">
                            <td>{{ $i+1 }}</td>
                            <td>{{ stripslashes($entry->title) }}</td>
                            <td><a href="{{ route('entry_author', ['s' => stripslashes($entry->author->name) ]) }}" class="link-author-filter">{{ stripslashes($entry->author->name) }}</a></td>
                            <td class="">{{ $entry->created_at }}</td>
                            <td class="action-box">
                                <a title="Edit Entry" href=" {{ route('entry_add', ['ei' => $entry->id] ) }} "><span class="glyphicon glyphicon-pencil"></span></a>
                                <a title="Delete Entry" href=" {{ route('entry_delete', ['ei' => $entry->id] ) }} " onclick = "return delete_alert('Entry');"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                         @endforeach
                    @else
                        <tr><td colspan="5">No entries to list</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
            {{ $entries->links() }}
        </section>
    </div>
</div>
@endsection

@section('title')
KnowledgeBase::Manage - List
@endsection