@extends('layouts.entry_template')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <form method="post" action="{{ route('entry_create') }}">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input placeholder="Author" type="text" class="form-control" id="author" name="author" value="{{ Request::old('author')? Request::old('title') : ( empty($entry->author) ? '' : $entry->author->name) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <input placeholder="Title" type="text" class="form-control" id="title" name="title" value="{{ Request::old('title') ? Request::old('title') : ( empty($entry->title) ? '' : stripslashes($entry->title)) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <textarea rows="10" class="form-control" id="description" name="description" placeholder="Small Description of the Title">{{ Request::old('description') ? Request::old('description') : ( empty($entry->description) ? '' : stripslashes($entry->description) ) }}</textarea>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <textarea rows="10" class="form-control" id="solution" name="solution" placeholder="Solution if any">{{ Request::old('solution') ? Request::old('solution') :  ( empty($entry->solution) ? '' : stripslashes($entry->solution) ) }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="attached-tags-box">
                            <div class="attached-tags-header">Tags</div>
                            @if($entry)
                                @if(count($entry->tags) > 0)
                                @foreach($entry->tags as $e_tag)
                                <div class="attached-tag-wrap" id="tag_{{ $e_tag->id }}">
                                    <div class="attached-tag"> {{ $e_tag->name }}</div>
                                    <button type="button" class="remove-tag" data-tid="{{ $e_tag->id}}">&times;</button>
                                </div>
                                @endforeach
                                @endif
                            @endif
                        </div>
                        <!-- //display attached tags -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center submit-entry">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
                <input type="hidden" name="ei" value={{ empty($entry->id)?'':$entry->id }} />
                <input type="hidden" name="_token" value="{{  Session::token() }}" />
                <input type="hidden" name="tags_attached" id="tags_attached" value="" />
            </form>
        </div>
        <div class="col-md-4">
            <div class="tags_box">

                <p class="tab-box-header">Attach Tags</p>
                @if(count($tags) > 0)
                    @foreach($tags as $tag)
                        <div class="tag btn {{ $tag_classes[array_rand($tag_classes)] }}" id="tag_{{ $tag->id }}" data-tid="{{ $tag->id }}">{{ $tag->name }}</div>
                    @endforeach
                @else
                    <p class="tab-box-header">No tags to display.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('title')
KnowledgeBase::Add
@endsection

@section('scripts')
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="{{ URL::to('js/entry_tags.js') }} "></script>
@endsection