<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Opinion;
use Illuminate\Http\Request;

class WriterArticleController extends Controller
{
    public function index(Author $writer)
    {
        $articles = Opinion::where('author_id', $writer->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.writers.articles', [
            'writer' => $writer,
            'articles' => $articles,
            'title' => 'مقالات الرأي - ' . $writer->name
        ]);
    }
}
