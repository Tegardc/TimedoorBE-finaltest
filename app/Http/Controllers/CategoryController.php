<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderBy('name', 'asc')->get();
        return response()->json(['message' => 'Successfully Display Data', 'status' => true, 'data' => $category]);
        //
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
            $validateData = $request->validate(['name' => 'required|unique:categories,name'], [
                'name.required' => 'Category Name is Empty'
            ]);
            $newData = Category::create($validateData);

            return response()->json(['message' => 'Successfully Added Category', 'status' => true, 'data' => $newData], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors(), 'status' => false], 422);
            //throw $th;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Create Data', 'status' => false, 'errors' => $e->getMessage()], 500);
            //throw $th;
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $category = Category::find($id);
        if ($category) {
            return response()->json(['message' => 'Successfully Display Data', 'status' => true, 'data' => $category]);
        } else {
            return response()->json(['Message' => 'Category Not Found', 'status' => false], 404);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category Not Found', 'status' => false], 404);
        }
        try {
            $validateData = $request->validate(['name' => 'required']);
            $category->update($validateData);
            return response()->json(['message' => 'Successfully Updated Data', 'status' => true], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors(), 'status' => false], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Updated Data', 'status' => false], 500);
            //throw $th;
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message ' => 'Category Not Found', 'status' => false], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Deleted Category Successfully']);
        //
    }
}
