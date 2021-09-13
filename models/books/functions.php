<?php

function getBooks(){
    return executeQuery("SELECT * FROM books");
}

function getFeaturedBooks(){
    return executeQuery("SELECT * FROM books WHERE isFeatured=1");
}