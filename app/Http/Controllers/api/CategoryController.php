<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return ResponseHelper::jsonResponse(true, 'category berhasil di fetch', CategoryResource::collection($categories), 200);
    }

    public function store(CategoryStoreRequest $request) {
        $request->validated();

        $categories = new Category();
        $categories->name = $request['name'];
        $categories->slug = $request['slug'];
        $categories->save();

        return ResponseHelper::jsonResponse(true, 'category berhasil di tambah', CategoryResource::make($categories), 201);
    }

    public function show(string $id) {
        $categories = Category::Find($id);

        if (!$categories) {
            return ResponseHelper::jsonResponse(false, 'category gagal di temukan', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'category berhasil di temukan', CategoryResource::make($categories), 200);
    }

    public function update(CategoryUpdateRequest $request, string $id) {
        $categories = Category::Find($id);

        if (!$categories) {
            return ResponseHelper::jsonResponse(false, 'category gagal di temukan', null, 404);
        }

        $categories->name = $request['name'];
        $categories->slug = $request['slug'];
        $categories->save();

        return ResponseHelper::jsonResponse(true, 'category berhasil di ubah', CategoryResource::make($categories), 200);
    }

    public function destroy(string $id) {
        $categories = Category::Find($id);

        if (!$categories) {
            return ResponseHelper::jsonResponse(false, 'category gagal di temukan', null, 404);
        }

        $categories->delete();

        return ResponseHelper::jsonResponse(true, 'category berhasil di hapus', CategoryResource::make($categories), 200);
    }
}
