<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColumnRequest;
use App\Http\Requests\UpdateColumnRequest;
use App\Models\Column;
use Illuminate\Database\Eloquent\Collection;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(): Collection|array
    {
        return Column::with('cards')->get();
    }

   
}
