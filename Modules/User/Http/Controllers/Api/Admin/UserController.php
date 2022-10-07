<?php

namespace Modules\User\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Resources\UserResource;
use App\Models\User;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Illuminate\Auth\Events\Registered;
use Modules\Investment\Models\Investment;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::with('investments')->paginate(20);

        return UserResource::collection($users)->additional([
            "status" => "success",
            "message" => "Users retrieved successfully"
        ]);
    }

   
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateUserRequest $request)
    {
        $params = $request->all();
        $user = User::create( $params );

        // create investment profile
        if($request->investable_cash){
            $user->investments()->create([
                'investable_cash' => $request->investable_cash,
            ]);
        }
        event(new Registered($user) );

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successfull',
            'data' => $user->load('investments'),
        ], 200);
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User retreived successfull',
            'data' => $user->load('investments'),
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated() );
        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfull',
            'data' => $user->with('investments')->get(),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ], 204);
    }
}
