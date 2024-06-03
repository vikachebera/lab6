<?php

namespace backend\model;
class Book
{
    private $id;
    private $title;
    private $author;
    private $isbn;

    public function __construct($id, $author, $title, $isbn)
    {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->isbn = $isbn;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getISBN()
    {
        return $this->isbn;
    }

}