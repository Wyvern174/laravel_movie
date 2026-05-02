<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieService
{
    protected $movieRepository;

    public function __construct(MovieRepositoryInterface $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAllMovies($search = null)
    {
        return $this->movieRepository
            ->getAllMovies($search);
    }

    public function getMovieById($id)
    {
        return $this->movieRepository
            ->getMovieById($id);
    }

    public function getCategories()
    {
        return Category::all();
    }
}