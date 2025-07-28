<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();

        if ($todos->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No records found.',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Todo list fetched successfully.',
            'data' => $todos
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_completed' => 'boolean'
            ]);

            $todo = Todo::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Todo created successfully.',
                'data' => $todo
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create Todo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Todo fetched successfully.',
            'data' => $todo
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo not found.'
            ], 404);
        }

        try {
            $data = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'is_completed' => 'boolean'
            ]);

            $todo->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Todo updated successfully.',
                'data' => $todo
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update Todo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Todo not found.'
            ], 404);
        }

        try {
            $todo->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Todo deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete Todo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
