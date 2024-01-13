<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArchiveApiService;

class ArchiveController extends Controller
{
    protected $archive;

    public function __construct(ArchiveApiService $archive)
    {
        $this->archive = $archive;
    }

    public function index()
    {
        return view('pages.archive.index');
    }

    public function getList(Request $request)
    {
        $title = $request->input('title');
        if($title == null)
            return redirect()->back();
        $submit = $request->input('submit');

        if($submit == 'Books') {
            $books = $this->archive->searchBooks($title);
            return view('pages.archive.index', ['books' => $books, 'title' => $title, 'sub' => 'book']);
        } elseif ($submit == 'Movies') {
            $movies = $this->archive->searchMovies($title);
            return view('pages.archive.index', ['movies' => $movies, 'title' => $title, 'sub' => 'movie']);
        } elseif ($submit == 'Images')
        {
            $images = $this->archive->searchImages($title);
            return view('pages.archive.index', ['images' => $images, 'title' => $title, 'sub' => 'image']);
        }
    }
}
