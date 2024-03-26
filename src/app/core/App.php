<?php


namespace App\Core;


use App\Controllers\BookController;
use App\Repositories\BookRepository;
use App\Services\BookService;

class App
{
    private static Container $container;

    public function __construct()
    {
        static::$container = new Container();

        static::$container->set(BookController::class, function(Container $c) {

            $bookService = $c->get(BookService::class);

            return new BookController($bookService);
        });

        static::$container->set(BookService::class, function(Container $c) {

            $bookRepository = $c->get(BookRepository::class);

            return new BookService($bookRepository);
        });

        static::$container->set(BookRepository::class, function(Container $c) {

            return new BookRepository();
        });

    }

    public function getContainer(): Container {

        return static::$container;
    }
}
