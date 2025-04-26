<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListView;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ListViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.list_view.index');
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
        $listView = ListView::updateOrCreate(['id' => $request->list_view_id], [
            'name' => $request->name,
        ]);
        return response()->json([
            'status' => true,
            'message' => __('admin.list_view.added'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $listView = ListView::find($id);
        return response()->json($listView);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listView = ListView::find($id);
        $listView->delete();
        return response()->json([
            'status' => true,
            'message' => __('admin.list_view.deleted'),
        ]);
    }

    public function listViewDatatable(Request $request)
    {
        $listViews = ListView::query();
        return DataTables::of($listViews)
            ->addColumn('actions', function ($listView) {
                return view('components.table-actions', ['id' => $listView->id, 'editClass' => 'editListView', 'deleteClass' => 'deleteListView']);
            })
            ->addColumn('name', function ($listView) {
                return collect(config('app.locales'))
                    ->map(fn($label, $key) => e($listView->getTranslation('name', $key)))
                    ->implode('<br>');
            })->rawColumns(['actions', 'name'])
            ->make(true);
    }
}
