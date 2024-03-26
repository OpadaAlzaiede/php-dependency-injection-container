<?php

namespace App\Services;

use App\Repositories\BookRepository;

class BookService
{

    public function __construct(protected BookRepository $bookRepository)
    {
    }

    public function getAll(): array {

        return $this->bookRepository->getAllBooks();
    }
}
