<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * get all projects
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = Project::paginate();
        return response()->json([
            'status' => 'success',
            'projects' => $projects,
        ]);
    }

    /**
     * save project in database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project created successfully',
            'project' => $project,
        ],200);
    }

    /**
     * find detail for a specific project
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $project = Project::find($id);

        if(!$project){
            return response()->json([
                'status' => 'error',
                'message' => 'project not found',
            ],401);

        }

        return response()->json([
            'status' => 'success',
            'project' => $project,
        ],200);
    }

    /**
     * update details for a specific project
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $project = Project::find($id);

        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'project' => $project,
        ],200);
    }

    /**
     * delete specific project
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if(!$project){
            return response()->json([
                'status' => 'error',
                'message' => 'project not found',
            ],401);

        }

        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully',
            'project' => $project,
        ]);
    }
}
