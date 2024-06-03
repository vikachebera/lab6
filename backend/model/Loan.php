<?php

namespace backend\model;
class Loan
{
    private $book;
    private $user;
    private $loanDate;
    private $returnDate;

    public function __construct($book, $user, $loanDate, $returnDate = null)
    {
        $this->book = $book;
        $this->user = $user;
        $this->loanDate = $loanDate;
        $this->returnDate = $returnDate;

    }

    // Геттери та сеттери для управління позиками
    public function getBook()
    {
        return $this->book;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getLoanDate()
    {
        return $this->loanDate;
    }

    public function getReturnDate()
    {
        return $this->returnDate;
    }


}