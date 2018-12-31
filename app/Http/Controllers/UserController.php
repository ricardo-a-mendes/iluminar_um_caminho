<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdate;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use ResetsPasswords;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::id() != $id) {
            return redirect()->route('home');
        }
        $user = Auth::user();

        //session(['success' => 'aew']);

        return view('user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdate $request, $id)
    {
        if (Auth::id() != $id) {
            return redirect()->route('home');
        }

        $validated = $request->validated();

        $user = Auth::user();
        //Personal info
        $user->name = $request->post('name');
        $user->cpf = $request->post('cpf');

        //Address
        $user->street_number = $request->post('street_number');
        $user->street_name = $request->post('street_name');
        $user->district = $request->post('district');
        $user->postal_code = $request->post('postal_code');
        $user->city = $request->post('city');
        $user->state = $request->post('state');
        $user->complement = $request->post('complement');

        //Contact
        $user->area_code = $request->post('area_code');
        $user->phone_number = $request->post('phone_number');

        //Finally
        $user->registration_completed = 1;

        $user->save();

        $password = $request->post('password', null);
        if (isset($password)) {
            $this->resetPassword($user, $password);
        }

        $success = 'Dados alterados com sucesso!';

        return view('user', compact('user', 'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
