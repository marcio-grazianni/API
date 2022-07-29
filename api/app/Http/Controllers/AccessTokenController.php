<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccessTokenRequest;
use App\Http\Requests\UpdateAccessTokenRequest;
use App\Models\AccessToken;

class AccessTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        AccessToken::query()->delete();
        $token = AccessToken::create(['token'=>uniqid()]);
        return response($token);
    }

 
}
