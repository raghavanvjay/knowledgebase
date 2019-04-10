<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Facades\Response;
use App\Tag;

class TagController extends Controller
{
    public function manage_tags(Request $request)
    {
        $tags = Tag::orderBy('created_at','desc')->paginate(15);
        return view('entries.manage_tags', ['s' => '','tags' => $tags]);
    }

    public function escape_input( $input)
    {
        $input = addslashes(strip_tags($input));
        return trim($input);
    }

    public function add_new_tag(Request $request)
    {
        $status = 404;
        $message = 'Error saving new tag';
        $this->validate($request, [
            'name' => 'required|unique:tags',
        ], ['name.unique' => 'This tag already exists.']);
        $tag = new Tag();
        $tag->name = trim($this->escape_input($request['name']));
        if($tag->save())
        {
            $message = $tag;
            $status = 200;
        }
        return Response::json(array('message' => $message), $status);
    }

    public function get_tag(Request $request)
    {
        $message = 'Tag not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' ], ['id.required' => 'Tag not found.']);

        $tag_id = trim($this->escape_input($request['id']));
        $tag = Tag::find($tag_id);

        if($tag)
        {
            $message = $tag;
            $status = 200;
        }
        return Response::json(array('message' => $message), $status);
    }

    public function update_tag(Request $request)
    {
        $message = 'Tag not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' , 'name' => 'required|unique:tags' ], ['id.required' => 'Tag not found.', 'name.unique' => 'This tag already exists.']);

        $tag_id = trim($this->escape_input($request['id']));

        $tag = Tag::find($tag_id);

        if($tag)
        {
            $tag->name = trim($this->escape_input($request['name']));
            if($tag->save())
            {
                $message = $tag;
                $status = 200;
            }
            else
                $msg = 'Tag not updated.';
        }
        return Response::json(array('message' => $message), $status);
    }

    public function delete_tag(Request $request)
    {
        $message = 'Tag not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' ], ['id.required' => 'Tag not found.']);

        $tag_id = trim($this->escape_input($request['id']));

        $tag = Tag::find($tag_id);

        if($tag)
        {
            if($tag->delete())
            {
                $message = $tag;
                $status = 200;
            }
            else
                $msg = 'Tag not deleted.';
        }
        return Response::json(array('message' => $message), $status);
    }
}