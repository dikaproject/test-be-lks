<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PublisherStoreRequest;
use App\Http\Requests\PublisherUpdateRequest;
use App\Http\Resources\PublisherResource;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index() {
        $publishers = Publisher::all();
        return ResponseHelper::jsonResponse(true, 'Fetch berhasil', PublisherResource::collection($publishers), 200);
    }

    public function store(PublisherStoreRequest $request) {
        $request = $request->validated();

        $publishers = new Publisher();
        $publishers->name = $request['name'];
        $publishers->bio = $request['bio'];
        $publishers->save();

        return ResponseHelper::jsonResponse(true, 'Publisher berhasil di tambahkan', PublisherResource::make($publishers), 201);
    }

    public function show(string $id) {
        $publishers = Publisher::Find($id);

        if (!$publishers) {
            return ResponseHelper::jsonResponse(false, 'Publisher tidak ditemukan', null, 404);
        }

        return ResponseHelper::jsonResponse(true, 'Publisher berhasil di temukan', PublisherResource::make($publishers), 200);
    }

    public function update(PublisherUpdateRequest $request, string $id) {
        $publishers = Publisher::Find($id);

        if (!$publishers) {
            return ResponseHelper::jsonResponse(false, 'Publisher tidak ditemukan', null, 404);
        }

        $publishers->name = $request['name'];
        $publishers->bio = $request['bio'];
        $publishers->save();

        return ResponseHelper::jsonResponse(true, 'Publisher berhasil di update', PublisherResource::make($publishers), 200);
    }

    public function destroy($id) {
        $publishers = Publisher::Find($id);

        if (!$publishers) {
            return ResponseHelper::jsonResponse(false, 'Publisher tidak ditemukan', null, 404);
        }

        $publishers->delete();

        return ResponseHelper::jsonResponse(true, 'Publisher berhasil di delete', PublisherResource::make($publishers), 200);
    }
}
