<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        // Todos los usuarios pueden listar libros, solo se muestra el título
        return response()->json(Book::all(['id', 'title']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'secret' => 'nullable|string',
        ]);
       // $request->auth = $user; // Guarda el usuario autenticado en la solicitud
       //  dd($request->auth);
        $book = Book::create([
            'title' => $request->title,
            'secret' => $request->secret,
            'user_id' => Auth::id(),
        ]);

        return response()->json($book, 201);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($book);
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
