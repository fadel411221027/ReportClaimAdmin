<?php

namespace App\Http\Controllers;

use App\Models\TaskCategory;
use Illuminate\Http\Request;
use App\Models\ReportTask;



class TaskCategoryController extends Controller
{
        public function index()
    {
        $categories = TaskCategory::all();
        return view('task-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('task-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
        ]);
        // Handle boolean fields with proper default values
        $validated['has_dor_date'] = $request->has('has_dor_date');
        $validated['has_batch'] = $request->has('has_batch');
        $validated['has_claim'] = $request->has('has_claim');
        $validated['has_time_range'] = $request->has('has_time_range');
        $validated['has_sheets'] = $request->has('has_sheets');
        $validated['has_email'] = $request->has('has_email');
        $validated['has_form'] = $request->has('has_form');

        TaskCategory::create($validated);
        return redirect()->route('task-categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }


public function edit(string $id)
{
    $category = TaskCategory::findOrFail($id);
    return view('task-categories.edit', compact('category'));
}

public function update(Request $request, string $id)
{
    $category = TaskCategory::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:50',
    ]);

    // Handle boolean fields with proper default values
    $validated['has_dor_date'] = $request->has('has_dor_date');
    $validated['has_batch'] = $request->has('has_batch');
    $validated['has_claim'] = $request->has('has_claim');
    $validated['has_time_range'] = $request->has('has_time_range');
    $validated['has_sheets'] = $request->has('has_sheets');
    $validated['has_email'] = $request->has('has_email');
    $validated['has_form'] = $request->has('has_form');

    $category->update($validated);
    return redirect()->route('task-categories.index')->with('success', 'Kategori berhasil diperbarui');
}


public function destroy(string $id)
{
    $category = TaskCategory::findOrFail($id);
    $tasksCount = ReportTask::where('task_category_id', $id)->count();

    if ($tasksCount > 0) {
        return response()->json([
            'needsConfirmation' => true,
            'tasksCount' => $tasksCount
        ]);
    }

    $category->delete();
    return redirect()->route('task-categories.index')
        ->with('success', 'Kategori berhasil dihapus');
}

public function forceDestroy(string $id) 
{
    $category = TaskCategory::findOrFail($id);
    ReportTask::where('task_category_id', $id)->delete();
    $category->delete();
    
    return redirect()->route('task-categories.index')
        ->with('success', 'Kategori dan semua tugas terkait berhasil dihapus');
}



}
