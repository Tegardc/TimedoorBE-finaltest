<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductsController extends Controller
{


    public function index(Request $request)
    {
        $pagination = $request->query('page') ?? 10;
        $category = $request->query('category') ?? null;
        $size = $request->query('size') ?? null;
        $product = $request->query('product') ?? null;
        $query = Products::query();

        if ($product) {
            $query->where('name', 'like', "%$product%");
        }
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', 'like', "%$category%");
            });
        }
        if ($size) {
            $query->whereHas('size', function ($q) use ($size) {
                $q->where('name', 'like', "%$size%");
            });
        }
        $query->with(['category', 'size']);
        $products = $query->paginate($pagination);
        if ($products->isEmpty() && $products->currentPage() > $products->lastPage()) {
            $products = $query->paginate($pagination, ['*'], 'page', $products->lastPage());
        }
       
        return response()->json(['message' => 'Successfully Display Data', 'status' => true, 'data' => $products]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $validateData = $request->validate([
                'name' => 'required|unique:products,name',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'description' => 'required',
                'image' => 'required',
                'category_id' => 'required|exists:categories,id',
                'size_id' => 'required|exists:sizes,id'
            ], [
                'name.required' => 'Product Name is Empty',
                'price.required' => 'Product Price is Empty',
                'price.numeric' => 'Price is Numeric!!!',
                'quantity.required' => 'Quantity is Invalid',
                'quantity.integer' => 'Quantity must be integer',
                'description' => 'Description is Empty',

            ]);

            $newProduct = Products::create($validateData);

            return response()->json([
                'message' => 'Added Successfully',
                'status' => true,
                'data' => $newProduct,
            ], 201);

            //code...
        } catch (ValidationException $e) {
            return response()->json(
                ['message' => $e->errors(), 'status' => false],
                422
            );
            //throw $th;
        } catch (\Exception $e) {
            return response()->json(
                ['message' => 'Error Create Data', 'status' => false, 'errors' => $e->getMessage()],
                500
            );
            //throw $th;
        }
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Products::find($id);
        if ($product) {
            return response()->json(['message' => 'Successfully ', 'status' => true, 'data' => $product,]);
        } else {
            return response()->json(['Message' => 'Product Tidak ditemukan', 'status' => false], 404);
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
    public function update(Request $request,  $id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk Not Found', 'status' => false], 404);
        }
        try {
            $validateData = $request->validate([
                'name' => 'required|unique:products,name',
                'price' => 'required|numeric|min:1',
                'quantity' => 'required|integer|min:1',
                'description' => 'required',
                'image' => 'required',
                'category_id' => 'required|exists:categories,id',
                'size_id' => 'required|exists:sizes,id'

            ]);
            $product->update($validateData);
            return response()->json(['message' => 'Product Updated Successfully', 'status' => true, 'product' => $product], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors(), 'status' => false], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error Update Data', 'status' => false], 500);
            //throw $th;
        }
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Products::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product Not Found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Produk Deleted']);

        //
        //
    }
    public function uploadFile(Request $request)
    {
        try {
            $request->validate(['file' => ['required', 'file']]);
            $file = $request->file('file');
            if (!$file->isValid()) {
                return response()->json([
                    'message' => 'File tidak Valid',
                    'status' => 'error',
                    'data' => 'null'
                ], 422);
            }
            $fileName = time();
            $resultFile = $file->storeAs('photos', "{$fileName}.{$file->extension()}");
            $baseUrl = Storage::url($resultFile);
            return response()->json(['message' => 'Upload File Success ', 'status' => true, 'data' => ['url' => $baseUrl]], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'status' => false], 500);
            //throw $th;
        }
    }
}
