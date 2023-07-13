<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductCategoryController extends Controller
{


    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = ProductCategory::orderByDesc('id')->paginate($perPage);
            $pages_count = ceil($data->total()/$perPage);
            $labels = [];
            for ($i=1; $i <= $pages_count; $i++){
                (array_push($labels,$i));
            }
            return response([
                "data"=>ProductCategoryResource::collection($data),
                "pages"=>$pages_count,
                "total"=> $data->total(),
                "labels"=> $labels,
            ], 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
    public function indexSite()
    {
        try {
            $data = ProductCategory::orderBy('id')->where('active',1)->get();
            return response(ProductCategoryResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(ProductCategory $productCategory)
    {
        try {
            return response(new ProductCategoryResource($productCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:product_categories',
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $data = ProductCategory::create($request->except('image'));
            if ($request['image']) {
                $name = 'Product_' . $data['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/products/');
                $data->update(['image' => '/' . $image_path]);
            }

            return response(new ProductCategoryResource($data), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request,ProductCategory $productCategory)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:product_categories,title,' . $productCategory['id'],
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $productCategory->update($request->except('image'));
            if ($request['image']) {
                $name = 'Product_' . $productCategory['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/products/');
                $productCategory->update(['image' => '/' . $image_path]);
            }

            return response(new ProductCategoryResource($productCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = ProductCategory::where('id',$request['id'])->first();
            $data->Products->each->delete();
            $data->delete();
            return response("category and it's subsets deleted", 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(ProductCategory $productCategory)
    {
        try {
            $productCategory->update(['active' => !$productCategory['active']]);
            return response(new ProductCategoryResource($productCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

}
