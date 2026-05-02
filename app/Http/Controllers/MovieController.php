<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Services\MovieService;
use App\Http\Requests\StoreMovieRequest;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index()
    {
        $movies = $this->movieService
            ->getAllMovies(request('search'));

        return view('homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = $this->movieService
            ->getMovieById($id);

        return view('detail', compact('movie'));
    }

    public function create()
    {
        $categories = $this->movieService
            ->getCategories();

        return view('input', compact('categories'));
    }

    public function store(StoreMovieRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('foto_sampul')) {
            $validated['foto_sampul'] = $request
                ->file('foto_sampul')
                ->store('movie_covers', 'public');
        }

        Movie::create($validated);

        return redirect('/')
            ->with('success', 'Film berhasil ditambahkan.');
    }

    public function data()
    {
        $movies = Movie::latest()->paginate(10);

        return view('data-movies', compact('movies'));
    }

    public function form_edit($id)
    {
        $movie = Movie::find($id);

        $categories = $this->movieService
            ->getCategories();

        return view('form-edit', compact('movie', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'sinopsis' => 'required|string',
            'tahun' => 'required|integer',
            'pemain' => 'required|string',
            'foto_sampul' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto_sampul')) {

            if (
                $movie->foto_sampul &&
                File::exists(public_path('images/' . $movie->foto_sampul))
            ) {
                File::delete(public_path('images/' . $movie->foto_sampul));
            }

            $fileName = Str::uuid() . '.' .
                $request->file('foto_sampul')->getClientOriginalExtension();

            $request->file('foto_sampul')
                ->move(public_path('images'), $fileName);

            $data['foto_sampul'] = $fileName;
        }

        $movie->update($data);

        return redirect('/movies/data')
            ->with('success', 'Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $movie = Movie::findOrFail($id);

        if (
            File::exists(public_path('images/' . $movie->foto_sampul))
        ) {
            File::delete(public_path('images/' . $movie->foto_sampul));
        }

        $movie->delete();

        return redirect('/movies/data')
            ->with('success', 'Data berhasil dihapus');
    }
}