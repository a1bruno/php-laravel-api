<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = User::all();
            return response()->json($users, 200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "there are no users"
            ], 404);
        };
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        try {
            $user = new User();
            $user->fill($data);
            $user->password = Hash::make(123);
            $user->save();

            return response()->json([
                "message" => "user created successfully"
            ], 201);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "failed to create new user"
            ], 400);
        };

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (Exception $ex) {
            return response()->json([
                "message" => "user not found"
            ], 404);
        };
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $user = User::findOrFail($id);
            $user->update($data);
            return response()->json([
                "message" => "user updated"
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "message" => "user id not found"
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "failed to update user data"
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $removed = User::destroy($id);
            if (!$removed) {
                throw New Exception();
            }
            return response()->json([
                "message" => "user id {$id} deleted"
            ], 200);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "message" => "user with id {$id} was not found"
            ], 404);
        } catch (\Exception $ex) {
            return response()->json([
                "message" => "failed to delete user"
            ], 400);
        }
    }
}
