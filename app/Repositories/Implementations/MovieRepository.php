<?php

namespace App\Repositories\Implementations;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieRepository implements MovieRepositoryInterface
{
    public function getAllMovies($search = null)
    {
        $query = Movie::latest();

        if ($search) {
            $query->where('judul', 'like', '%' . $search . '%')
                ->orWhere('sinopsis', 'like', '%' . $search . '%');
        }

        return $query->paginate(6)->withQueryString();
    }

    public function getMovieById($id)
    {
        return Movie::findOrFail($id);
    }
}