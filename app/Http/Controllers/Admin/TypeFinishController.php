<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeFinish;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TypeFinishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.type_finish.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
        ]);
        $typeFinish = TypeFinish::updateOrCreate(['id' => $request->finish_type_id], [
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'message' => __('admin.type_finish.added'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypeFinish::find($id);
        return response()->json($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeFinish::find($id);
        $type->delete();
        return response()->json([
            'status' => true,
            'message' => __('admin.type_finish.deleted'),
        ]);
    }

    public function typeFinishDatatable(Request $request)
    {
        $typeFinishes = TypeFinish::query();
        return DataTables::of($typeFinishes)
            ->addColumn('actions', function ($typeFinish) {
                return view('components.table-actions', ['id' => $typeFinish->id, 'editClass' => 'editTypeFinish', 'deleteClass' => 'deleteTypeFinish']);
            })
            ->addColumn('name', function ($typeFinish) {
                return collect(config('app.locales'))
                    ->map(fn($label, $key) => e($typeFinish->getTranslation('name', $key)))
                    ->implode('<br>');
            })->rawColumns(['actions', 'name'])
            ->make(true);
    }
}
