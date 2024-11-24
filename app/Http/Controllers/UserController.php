<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users()
    {
        $res = User::all();

        $u = [];

        foreach ($res as $value) {
            $u[] = ["name" => $value['name'], "id" => $value['id']];
        }

        return response()->json($u);
    }
}
