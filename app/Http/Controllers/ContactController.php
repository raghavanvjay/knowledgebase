<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function query_submit(Request $request)
    {
        $this->validate($request, [
            'query' => 'required',
            'full_name'  => 'required|alpha',
            'email_id' => 'required|email'
        ]);
        return view('contact.acknowledge', [ 'query' => $request['query'] ]);
    }
}
