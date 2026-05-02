<?php

namespace App\Repositories\Interfaces;

interface MovieRepositoryInterface
{
    public function getAllMovies($search = null);

    public function getMovieById($id);
}