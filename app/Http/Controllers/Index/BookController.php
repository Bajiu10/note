<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\BaseController;
use App\Model\Entities\Book;
use App\Model\Entities\Note;
use Max\Di\Exceptions\NotFoundException;
use Max\Http\Annotations\Controller;
use Max\Http\Annotations\GetMapping;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Swoole\Exception;
use Throwable;
use function view;

#[Controller(prefix: 'book')]
class BookController extends BaseController
{
    /**
     * @throws NotFoundException
     * @throws Throwable
     * @throws Exception
     * @throws ReflectionException
     */
    #[GetMapping(path: '/')]
    public function index(): ResponseInterface
    {
        $books = Book::all();
        return view('book.index', compact('books'));
    }

    /**
     * @throws Throwable
     * @throws Exception
     */
    #[GetMapping(path: '/<link_name>.html')]
    public function show($linkName): ResponseInterface
    {
        $book  = Book::where('link_name', $linkName)->firstOrFail();
        $notes = Note::where('book_id', $book->id)
                     ->order('chapter')
                     ->order('section')
                     ->get(['id', 'title']);

        return view('book.show', compact('book', 'notes'));
    }
}
