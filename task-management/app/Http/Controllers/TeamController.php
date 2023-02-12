<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * TeamController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * get all teams data
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $teams = Team::paginate();
        return response()->json([
            'status' => 'success',
            'teams' => $teams,
        ]);
    }

    /**
     * save team in database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $team = Team::create([
            'name' => $request->name
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Member Team created successfully',
            'team' => $team,
        ],200);
    }

    /**
     * find detail for a specific team
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $team = Team::find($id);
        return response()->json([
            'status' => 'success',
            'team' => $team,
        ],200);
    }

    /**
     * update detail for a specific team
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $team = Team::find($id);
        $team->name = $request->name;
        $team->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Memeber Team updated successfully',
            'team' => $team,
        ],200);
    }

    /**
     * delete a specific team
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $team = Team::find($id);
        $team->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Member team deleted successfully',
            'team' => $team,
        ]);
    }
}
