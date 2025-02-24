<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoanStoreRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index() {
        $loans = Loan::all();
        return ResponseHelper::jsonResponse(true, 'Buku berhasil di fetch', LoanResource::collection($loans), 200);
    }
    public function store(LoanStoreRequest $request) {
        $books = Book::find($request->book_id);

        if ($books->stock < 1) {
            return ResponseHelper::jsonResponse(false, 'stock buku ini habis', null, 400);
        }

        $existingLoan = Loan::where('user_id', $request->user_id)
        ->where('book_id', $request->book_id)
        ->where('status', 'borrowed')->first();

        if ($existingLoan) {
            return ResponseHelper::jsonResponse(false, 'kamu sudah meminjam buku ini', null, 400);
        }

        $loanDate = Carbon::now();
        $dueDate = $loanDate->copy()->addDay(7);
        $loans = new Loan();
        $loans->user_id = $request['user_id'];
        $loans->book_id = $request['book_id'];
        $loans->loan_date = $loanDate;
        $loans->due_date = $dueDate;
        $loans->status = 'borrowed';
        $loans->save();

        $books->decrement('stock');

        return ResponseHelper::jsonResponse(true, 'Buku berhasil di sewa', LoanResource::make($loans), 201);
    }
}
