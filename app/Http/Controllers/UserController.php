<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use App\User;

class UserController extends Controller
{
    public function admin_login(Request $request, $a='login')
    {
        if($a=='logout'){
            Auth::logout();
            return redirect()->route('entry_list');

        }

        $validator = $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt(['username' => $request['username'], 'password' => $request['password']] ))
        {
            $bag = new MessageBag();
            $bag->add('username', 'Invalid credentials');
            return redirect()->back()->with('errors', session()->get('errors', new ViewErrorBag)->put('default', $bag));
        }
        else
        {
            return redirect()->route('manage_entry_list');
        }
    }

    public function admin_logout()
    {
        return redirect()->route('entry_list');
    }

    public function escape_input( $input)
    {
        $input = addslashes(strip_tags($input));
        return trim($input);
    }
}