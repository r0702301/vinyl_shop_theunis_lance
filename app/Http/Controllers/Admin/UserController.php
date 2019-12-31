<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $naam = '%' . $request->input('name') . '%';
       // $selectvalue = $request->input('sorteren');
       // $selectvalue = explode(' ', $selectvalue);
        //$veld = $sorteringarray[0];
       // $volgorde = $sorteringarray[1];



        $users = User::orderBy('name','asc')
        ->where('name', 'like', $naam)
        ->orWhere('email', 'like', $naam)
        ->paginate(10)
        ->appends(['name'=> $request->input('name')]);
        $result = compact('users');
        $count = count($result);
        Json::dump($result);
        return view('admin.users.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact('user');
        Json::dump($result);
        return view('admin.users.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'active' => 'required|boolean|nullable'
        ]);
        if($request->admin == null){
            $admin = 0;
        } else {
            $admin = $request->admin;
        }
        if($request->active == null){
            $active = 0;
        } else {
            $active = $request->active;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->active = $active;
        $user->admin = $admin;
        $user->save();
        session()->flash('success', "The user <b>$user->name</b> has been updated");
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->validate($request,[
            'userid' => 'not_in:' . auth()->id()
        ]);

        $user->delete();
        return response()->json([
            'type' => 'success',
            'text' => "The user <b>$user->name</b> has been deleted"
        ]);
    }
}
