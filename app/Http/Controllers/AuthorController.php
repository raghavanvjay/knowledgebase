<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

use App\Author;

class AuthorController extends Controller
{
    public function manage_authors($ai = 0)
    {
        $authors = Author::all();
        $author = Author::find($ai);
        return view('entries.manage_authors', ['s' => '', 'authors' => $authors, 'author' => $author]);
    }

    public function escape_input( $input)
    {
        $input = addslashes(strip_tags($input));
        return trim($input);
    }

    public function get_name(Request $request)
    {
        $message = 'Author not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' ], ['id.required' => 'Tag not found.']);

        $author_id = trim($this->escape_input($request['id']));
        $author = Author::find($author_id);

        if($author)
        {
            $message = $author;
            $status = 200;
        }
        return Response::json(array('message' => $message), $status);
    }

    public function update_author(Request $request)
    {
        $message = 'Author not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' , 'name' => 'required|unique:authors' ], ['id.required' => 'Author not found.', 'name.unique' => 'This author already exists.']);

        $author_id = trim($this->escape_input($request['id']));

        $author = Author::find($author_id);

        if($author)
        {
            $author->name = trim($this->escape_input($request['name']));
            if($author->save())
            {
                $message = $author;
                $status = 200;
            }
            else
                $msg = 'Author not updated.';
        }
        return Response::json(array('message' => $message), $status);
    }

    public function toggle_status(Request $request)
    {
        $message = 'Author was not found';
        $status = 404;

        $this->validate($request, [ 'id' => 'required' ], ['id.required' => 'Author could not be found.']);

        $author_id = trim($this->escape_input($request['id']));

        $author = Author::find($author_id);

        if($author)
        {
            $author->status = $author->status == 1 ? 0 : 1;
            if($author->save())
            {
                $message = $author;
                $status = 200;
            }
            else
                $msg = 'Author status not updated.';
        }
        return Response::json(array('message' => $message), $status);
    }

}