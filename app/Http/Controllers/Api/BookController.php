<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        
        if(!$books) {
            return response()->json([
                'message' => 'Book not found'
            ]);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $books
        ]);

    }

    public function getById($id)
    {
        $books = Book::find($id);

        if(!$books) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Success',
            'data' => $books
        ], 200);
    }

    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'title' => 'required|string',
            'author' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $book = Book::create([
            'title' => request('title'),
            'author' => request('author')
        ]);

        return response()->json([
            'message' => 'Book created',
            'data' => $book
        ], 201);
    }

    public function update($id)
    {
        $book = Book::find($id);

        if(!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $validator = Validator::make(request()->all(), [
            'title' => 'nullable|string',
            'author' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 400);
        }

        $book->title = request('title');
        $book->author = request('author');
        $book->save();

        return response()->json([
            'message' => 'Book updated',
            'data' => $book
        ], 200);


    }

    public function destroy($id)
    {
        $books = Book::find($id);

        if(!$books) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        $books->delete();

        return response()->json([
            'message' => 'Book deleted'
        ], 200);
    }
}
