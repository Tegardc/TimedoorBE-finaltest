<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SizesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sizes = Size::orderBy('name', 'asc')->get();
        return response()->json(['message' => 'Successfully Display Data', 'status' => true, 'data' => $sizes]);
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
            $validateData = $request->validate(['name' => 'required|unique:sizes,name'], [
                'name.required' => 'Size Name is Empty'
            ]);
            $newData = Size::create($validateData);

            return response()->json(['message' => 'Successfully Added Size', 'status' => true, 'data' => $newData], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors(), 'status' => false], 422);
            //throw $th;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Create Data', 'status' => false, 'errors' => $e->getMessage()], 500);
            //throw $th;
        }
        //
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Size::find($id);
        if ($category) {
            return response()->json(['message' => 'Successfully Display Data', 'status' => true, 'data' => $category]);
        } else {
            return response()->json(['Message' => 'Size Not Found', 'status' => false], 404);
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
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message' => 'Size Not Found', 'status' => false], 404);
        }
        try {
            $validateData = $request->validate(['name' => 'required']);
            $size->update($validateData);
            return response()->json(['message' => 'Successfully Updated Data', 'status' => true], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors(), 'status' => false], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Updated Data', 'status' => false], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $size = Size::find($id);
        if (!$size) {
            return response()->json(['message ' => 'Sizes Not Found', 'status' => false], 404);
        }
        $size->delete();
        return response()->json(['message' => 'Deleted Sizes Successfully']);

        //
    }
}
