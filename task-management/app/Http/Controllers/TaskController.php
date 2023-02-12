<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get all tasks data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Task::paginate();
        return response()->json([
            'status' => 'success',
            'tasks' => $tasks,
        ]);
    }

    /**
     * save task in database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'project_id' => 'required|int',
            'team_id' => 'required|int',
        ]);

        $project = Project::find($request->project_id);
        $team = Team::find($request->team_id);

        if(!$team || !$project){
            return response()->json([
                'status' => 'error',
                'message' => 'can not create the task, project or team member not found',
            ],401);
        }

        $project = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'project_id' => $project->id,
            'team_id' => $team->id
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Task created successfully',
            'project' => $project,
        ],200);
    }

    /**
     * find detail for a specific task
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $task = Task::find($id);
        return response()->json([
            'status' => 'success',
            'task' => $task,
        ],200);
    }

    /**
     * update details for a specific task
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'project_id' => 'required|int',
            'team_id' => 'required|int',
        ]);

        $project = Project::find($request->project);
        $team = Team::find($request->team);

        if(!$team || !$project){
            return response()->json([
                'status' => 'error',
                'message' => 'can not update the task, project or team member not found',
            ],401);
        }

        $task = Task::find($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->project_id = $request->project_id;
        $task->team_id = $request->team_id;
        $task->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Task updated successfully',
            'task' => $task,
        ],200);
    }

    /**
     * delete a specific task
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully',
            'task' => $task,
        ]);
    }
}
