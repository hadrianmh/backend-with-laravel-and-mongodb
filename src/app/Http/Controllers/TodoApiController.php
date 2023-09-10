<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class TodoApiController extends Controller
{
    public function index()
    {
        $todo = Todo::all();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Get data successfully',
            'data'      => $todo
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error', 'message' => implode(', ', $validator->messages()->all())], 400);
        }
        
        $todo = Todo::Create([
            'uuid'      => Str::uuid()->toString(),
            'title'     => $request['title'],
            'description' => $request['description']
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Create successfully'
        ], 201);
    }

    public function show($id)
    {
        $todo = Todo::findOrFail($id);
        return response()->json([
            'status'    => 'success',
            'message'   => 'Get ID successfully',
            'data' => $todo
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);
        $todo->update($request->all());
        return response()->json([
            'status'    => 'success',
            'message'   => 'Update successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return response()->json([
            'status'    => 'success',
            'message'   => 'Delete successfully'
        ], 200);
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $token =  JWTAuth::getToken();
        try {
            $user = JWTAuth::authenticate($token);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token expired',
            ], 410);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token Invalid',
            ], 500);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
        return $next($request);
    }
}
