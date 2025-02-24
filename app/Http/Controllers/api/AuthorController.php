<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index() {
        $authors = Author::all();
        return ResponseHelper::jsonResponse(true, 'Fetch berhasil', AuthorResource::collection($authors), 200);
    }

    public function store(AuthorStoreRequest $request) {
        $request = $request->validated();

        $authors = new Author();
        $authors->name = $request['name'];
        $authors->bio = $request['bio'];
        $authors->save();

        return ResponseHelper::jsonResponse(true, 'author berhasil di tambahkan', AuthorResource::make($authors), 201);
    }

    public function show(string $id) {
        $authors = Author::Find($id);

        if (!$authors) {
            return ResponseHelper::jsonResponse(false, 'Author tidak ditemukan', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'author berhasil di temukan', AuthorResource::make($authors), 200);
    }

    public function update(AuthorUpdateRequest $request, string $id) {
        $authors = Author::Find($id);

        if (!$authors) {
            return ResponseHelper::jsonResponse(false, 'Author tidak ditemukan', null, 404);
        }

        $authors->name = $request['name'];
        $authors->bio = $request['bio'];
        $authors->save();

        return ResponseHelper::jsonResponse(true, 'author berhasil di update', AuthorResource::make($authors), 200);
    }

    public function destroy($id) {
        $authors = Author::Find($id);

        if (!$authors) {
            return ResponseHelper::jsonResponse(false, 'Author tidak ditemukan', null, 404);
        }

        $authors->delete();

        return ResponseHelper::jsonResponse(true, 'author berhasil di delete', AuthorResource::make($authors), 200);
    }
}
