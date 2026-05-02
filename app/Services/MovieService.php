<?php

namespace App\Services;

use App\Models\Movie;
use App\Models\Category;

class MovieService
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

    public function getCategories()
    {
        return Category::all();
    }
}