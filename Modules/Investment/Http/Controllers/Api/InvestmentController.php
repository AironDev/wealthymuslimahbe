<?php

namespace Modules\Investment\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;

class InvestmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if(!$user = User::find(request()->user_id) ){
            
            return response()->json([
                "status" => "error",
                "message" => "User does not exists"
            ]);
        }

        return response()->json([
            "status" => "success",
            "message" => "Investments fetched successfully",
            "data" => $user->investments
        ]);
    }

   
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        if(!$user = User::find($request->user_id) ){
            
            return response()->json([
                "status" => "error",
                "message" => "User does not exists"
            ]);
        }

       $investment = $user->investments()->create([
            "investable_cash" => $request->investable_cash
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Investment created successfully",
            "data" => $investment
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        //not required
    }

    

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //not allowed for user
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //not required
    }
}
