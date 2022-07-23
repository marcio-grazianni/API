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
     * @param \App\Http\Requests\StoreColumnRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreColumnRequest $request)
    {
        $column = Column::create($request->validated());
        return response($column);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Column $column
     * @return \Illuminate\Http\Response
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Column $column
     * @return \Illuminate\Http\Response
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateColumnRequest $request
     * @param \App\Models\Column $column
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateColumnRequest $request, Column $column)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Column $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Column $column)
    {
        $column->delete();
        return response()->noContent();
    }
}
