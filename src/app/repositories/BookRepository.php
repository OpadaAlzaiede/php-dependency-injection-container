<?php


namespace App\Repositories;


class BookRepository
{
    public function getAllBooks(): array {

        return [
            'book1' => [
                'id' => 1,
                'title' => 'book1 title',
                'author' => 'book1 author'
            ],
            'book2' => [
                'id' => 2,
                'title' => 'book2 title',
                'author' => 'book2 author'
            ]
        ];
    }
}
