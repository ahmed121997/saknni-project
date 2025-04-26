<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeProperty;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TypePropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.type_property.index');
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
        $typeProperty = TypeProperty::updateOrCreate(['id' => $request->property_type_id], [
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'message' => __('admin.type_property.added'),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypeProperty::find($id);
        return response()->json($type);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeProperty::find($id);
        $type->delete();
        return response()->json([
            'status' => true,
            'message' => __('admin.type_property.deleted'),
        ]);
    }

    public function typePropertyDatatable(Request $request)
    {
        $typeProperties = TypeProperty::query();
        return DataTables::of($typeProperties)
            ->addColumn('actions', function ($typeProperty) {
                return view('components.table-actions', ['id' => $typeProperty->id, 'editClass' => 'editTypeProperty', 'deleteClass' => 'deleteTypeProperty']);
            })
            ->addColumn('name', function ($typeProperty) {
                return collect(config('app.locales'))
                    ->map(fn($label, $key) => e($typeProperty->getTranslation('name', $key)))
                    ->implode('<br>');
            })->rawColumns(['actions', 'name'])
            ->make(true);
    }
}
