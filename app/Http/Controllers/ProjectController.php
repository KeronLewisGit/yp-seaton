<?php

namespace App\Http\Controllers;

use App\Support\Portfolio;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $sectors = Portfolio::sectors();
        $sector = input_string($request->query('sector'));
        $sector = array_key_exists($sector, $sectors) ? $sector : null;

        return view('pages.projects.index', [
            'projects' => Portfolio::inSector($sector),
            'sectors' => $sectors,
            'sector' => $sector,
            'counts' => Portfolio::all()->countBy('sector'),
        ]);
    }

    public function show(string $slug): View
    {
        $project = Portfolio::find($slug);
        abort_if($project === null, 404);

        return view('pages.projects.show', [
            'project' => $project,
            'related' => Portfolio::related($slug),
        ]);
    }
}
