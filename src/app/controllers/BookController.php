<?php

namespace App\Controllers;

use App\Repositories\BookRepository;
use App\Services\BookService;

class BookController {

    public function __construct(protected BookService $bookService)
    {
    }

    public function index() {

        return $this->bookService->getAll();
    }
}
