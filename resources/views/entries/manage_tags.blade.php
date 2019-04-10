@extends('layouts.entry_template')
@section('content')
<div class="row">
    <div class="col-xs-12">
        <section class="search-entry">
            @include('includes.entry_search')
        </section>
        <section class="list-tags">
            <div class="listing-header">Add New Tag</div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="add-tag-block">
                        <div class="input-group col-md-offset-2 col-md-8">
                            <input type="text" class="form-control" placeholder="Tag Name" name="new_tag" id="new_tag">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button" name="add_tag" id="add_tag">Add</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list-tag-block">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="listing-header">
                            Existing Tags : Recent First
                        </div>
                    </div>
                </div>
                @if(count($tags) > 0)
                <div class="row" id="tag-boxes-wrap">
                    @foreach($tags as $tag)
                    <div class="col-md-4 edit-tag-box" id="tag_box_{{ $tag->id }}">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button title="Delete" class="btn btn-secondary del_tag" type="button" data-id="{{ $tag->id }}" name="del_tag"><span class="glyphicon glyphicon-remove"></span></button>
                            </span>
                            <input type="text" class="form-control" placeholder="Tag Name" name="tag_{{ $tag->id }}" id="tag_{{ $tag->id }}" value="{{ $tag->name }}">
                            <span class="input-group-btn">
                                <button title = "Save" class="btn btn-secondary save_tag" type="button" data-id="{{ $tag->id }}" name="save_tag"><span class="glyphicon glyphicon-floppy-disk"></span></button>
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                    <div class="col-xs-12">
                        There are no tags to display.
                    </div>
                </div>
                @endif
            </div>
            {{ $tags->links() }}
        </section>
    </div>
</div>
@endsection

@section('title')
KnowledgeBase::Manage - List
@endsection

@section('scripts')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ URL::to('js/manage_tags.js') }} "></script>
@endsection