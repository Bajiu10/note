<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Model\Entities\Book;
use Max\Routing\Annotations\GetMapping;

#[\Max\Routing\Annotations\Controller(prefix: 'book')]
class BookController extends Controller
{
    #[GetMapping(path: '/')]
    public function index()
    {
        $books = Book::all();
        return view('book.index', compact('books'));
    }

    #[GetMapping(path: '/<id>.html')]
    public function show($id)
    {
        $book  = Book::findOrFail($id);
        $notes = \App\Model\Entities\Note::where('book_id', $id)->get(['id', 'title']);

        return view('book.show', compact('book', 'notes'));
    }
}
