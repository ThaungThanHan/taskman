<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
      $projects = Project::where('is_completed', false)         // choose only incomplete tasks
                          ->orderBy('created_at', 'desc')
                          ->withCount(['tasks' => function ($query) {       //gets amount of related records
                            $query->where('is_completed', false);
                          }])
                          ->get();

      return $projects->toJson();
    }
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'name' => 'required',
        'description' => 'required',
      ]);

      $project = Project::create([
        'name' => $validatedData['name'],
        'description' => $validatedData['description'],
      ]);

      return response()->json('Project created!');
    }

    public function show($id)
    {
      $project = Project::with(['tasks' => function ($query) {
        $query->where('is_completed', false);
      }])->find($id);

      return $project->toJson();
    }

    public function markAsCompleted(Project $project)
    {
      $project->is_completed = true;
      $project->update();

      return response()->json('Project updated!');
    }
}