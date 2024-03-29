<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
      $validatedData = $request->validate(['title' => 'required']); //$request->title ko pl validate htae pyy htr tar.

      $task = Task::create([
        'title' => $validatedData['title'],
        'project_id' => $request->project_id,
      ]);

      return $task->toJson();
    }

    public function markAsCompleted(Task $task)
    {
      $task->is_completed = true;
      $task->update();

      return response()->json('Task updated!');
    }
}
