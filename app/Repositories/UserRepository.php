<?php
/**
 * Created by PhpStorm.
 * User: alamin899
 * Date: 9/11/2020
 * Time: 12:08 PM
 */

namespace App\Repositories;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function index()
    {
        return User::latest()->get()->except(Auth::id());
    }

    public function search()
    {

    }

    public function store()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function restore()
    {

    }

    public function status()
    {

    }

}