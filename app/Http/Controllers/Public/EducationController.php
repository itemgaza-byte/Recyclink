<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\EducationContent;

class EducationController extends Controller
{
    // ponytail: list all published articles, videos, and guides
    public function index()
    {
        $articles = EducationContent::published()->where('content_type', 'article')->latest()->get();
        $videos = EducationContent::published()->where('content_type', 'video')->latest()->get();
        $guides = EducationContent::published()->where('content_type', 'guide')->latest()->get();

        return view('pages.edukasi.index', compact('articles', 'videos', 'guides'));
    }

    // ponytail: view article detail page
    public function show(EducationContent $educationContent)
    {
        if ($educationContent->status !== 'published') {
            abort(404);
        }

        $educationContent->increment('view_count');

        return view('public.education.show', compact('educationContent'));
    }
}
