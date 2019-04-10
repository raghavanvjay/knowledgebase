@extends('layouts.entry_template')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <section class="search-entry">
            @include('includes.entry_search')
        </section>
        <section class="list-entry">
            <div class="listing-header">Listing Entries : Recent First</div>
            <div class="row">
                <div class="col-md-9">
                    @if(count($entries) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                @foreach($entries as $i=>$entry)
                                <tr class="entry-list-title-row">
                                    <td>{{ $i+1 }}</td>
                                    <td>{{ stripslashes($entry->title) }}</td>
                                    <td><a href="{{ route('entry_author', ['s' => stripslashes($entry->author->name) ]) }}" class="link-author-filter">{{ stripslashes($entry->author->name) }}</a></td>
                                    <td class="list-entry-date">{{ $entry->created_at }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <table class="table table-striped">
                                            <tr><td>Q:</td><td>{!! stripslashes($entry->description) !!}</td></tr>
                                            <tr><td>A:</td><td>{!! stripslashes($entry->solution) !!}</td></tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr class="list-tags-attached">
                                    <td colspan="4">
                                        Tags:
                                        @if(count($entry->tags) > 0)
                                            |
                                            @foreach($entry->tags as $tag)
                                                <a href="{{ route('entry_tag', ['ti' => $tag->id]) }}" class="list-tags-attached-link">{{ $tag->name }}</a> |
                                            @endforeach
                                        @else
                                        No tags attached.
                                        @endif
                                    </td>
                                </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row"><div class="col-xs-12">
                    {{ $entries->links() }}
                    </div></div>
                    @else
                        No entries to list.
                    @endif
                </div>
                <div class="col-md-3">
                    <div class="tags_box">
                        @if(count($tags) > 0)
                        <p class="tab-box-header">Search by Tags</p>
                        @foreach($tags as $tag)
                            <!-- //exclude tags already added to the list -->
                            <a href="{{ route('entry_tag', ['ti' => $tag->id]) }}" class="tag btn {{ $tag_classes[array_rand($tag_classes)] }}" >{{ $tag->name }}</a>
                        @endforeach
                        @else
                            <p class="tab-box-header">No tags to display.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@section('title')
KnowledgeBase::List
@endsection
