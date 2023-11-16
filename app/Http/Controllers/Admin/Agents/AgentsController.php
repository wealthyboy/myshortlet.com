<?php

namespace App\Http\Controllers\Admin\Agents;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AgentsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;


class AgentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    /* display all users in the database */
    public function index(Request $request)
    {
        $users = User::agents()->get();
        return view('admin.agents.Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
        ]);




        $input  = $request->all();

        $user  = new User;
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->type = "agent";
        $user->password = $request->has('password') ? bcrypt($request->password) : $user->password;
        $user->save();



        //Sedn email

        $user->notify(new AgentsNotification($input));


        return redirect('/admin/agents');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.agents.edit', compact('user'));
    }

    protected function update($id, Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ]);

        $user  = User::find($id);
        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = $request->has('password') ? bcrypt($request->password) : $user->password;
        $user->save();



        return redirect('/admin/agents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::canTakeAction(5);

        User::destroy($request->selected);
        $flash = app('App\Http\Flash');
        $flash->success("Success", "Users Deleted");
        return redirect()->back();
    }
}
