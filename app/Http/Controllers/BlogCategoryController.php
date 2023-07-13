<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Resources\BlogCategoryResource;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = BlogCategory::orderByDesc('id')->paginate($perPage);
            $pages_count = ceil($data->total()/$perPage);
            $labels = [];
            for ($i=1; $i <= $pages_count; $i++){
                (array_push($labels,$i));
            }
            return response([
                "data"=>BlogCategoryResource::collection($data),
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
            $data = BlogCategory::orderBy('id')->where('active',1)->get();
            return response(BlogCategoryResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function show(BlogCategory $blogCategory)
    {
        try {
            return response(new BlogCategoryResource($blogCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:blog_categories',
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
            $data = BlogCategory::create($request->except('image'));
            if ($request['image']) {
                $name = 'Blog_' . $data['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/Blogs/');
                $data->update(['image' => '/' . $image_path]);
            }

            return response(new BlogCategoryResource($data), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request,BlogCategory $blogCategory)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:blog_categories,title,' . $blogCategory['id'],
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
            $blogCategory->update($request->except('image'));
            if ($request['image']) {
                $name = 'Blog_' . $blogCategory['id'] . '_' . uniqid() . '.png';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/Blogs/');
                $blogCategory->update(['image' => '/' . $image_path]);
            }

            return response(new BlogCategoryResource($blogCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $data = BlogCategory::where('id',$request['id'])->first();
            $data->Blogs->each->delete();
            $data->delete();
            return response("category and it's subsets deleted", 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function activeToggle(BlogCategory $blogCategory)
    {
        try {
            $blogCategory->update(['active' => !$blogCategory['active']]);
            return response(new BlogCategoryResource($blogCategory), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }
}
