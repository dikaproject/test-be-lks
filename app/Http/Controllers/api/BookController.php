<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index() {
        $books = Book::all();
        return ResponseHelper::jsonResponse(true, 'data book berhasil di fetch', BookResource::collection($books), 200);
    }

    public function store(BookStoreRequest $request) {
        $request->validated();

        $books = new Book();
        $books->title = $request['title'];
        $books->cover = $request['cover']->store('assets/books', 'public');
        $books->category_id = $request['category_id'];
        $books->author_id = $request['author_id'];
        $books->publisher_id = $request['publisher_id'];
        $books->isbn = $request['isbn'];
        $books->publication_year = $request['publication_year'];
        $books->stock = $request['stock'];
        $books->save();

        return ResponseHelper::jsonResponse(true, 'buku berhasil di tambahkan', BookResource::make($books), 201);
    }
}
