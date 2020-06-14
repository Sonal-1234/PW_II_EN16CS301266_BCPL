<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Authority;
use App\Http\Requests\StoreAgentRequest;
use App\Product;
use App\User;
use App\UserAuthority;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller {

    public function index() {
        return view('backend.user-lists');
    }

    public function add() {
        return view('backend.user');
    }

    public function store(StoreAgentRequest $agentRequest) {
        $agentRequest->validated();

        try {
            $user = new User();
            $user->name = $agentRequest->name;
            $user->email = $agentRequest->email;
            $user->password = Hash::make($agentRequest->password);
            $user->phone1 = $agentRequest->phone1;
            $user->phone2 = $agentRequest->phone2;
            $user->save();

            #set Authority of user
            $userAuthority = new UserAuthority();
            $userAuthority->user_id = $user->id;
            $userAuthority->authority_name = $agentRequest->role;
            $userAuthority->save();

            if ($agentRequest->role == 'AGENT'):
                $agent = new Agent();
                $agent->user_id = $user->id;
                $agent->name = $agentRequest->name;
                $agent->phone1 = $agentRequest->phone1;
                $agent->phone2 = $agentRequest->phone2;
                $agent->email = $agentRequest->email;
                $agent->save();
            endif;
        } catch (Exception $e) {
            return self::errorResponse((string)$e->getMessage());
        }

        return self::successResponse('User Data Successfully Saved.');
    }

    public function edit($id) {
        $user = User::findOrFail($id);
        return view('backend.user-edit', compact('user'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone1 = $request->phone1;
        $user->phone2 = $request->phone2;
        $user->save();
        return self::successResponse('User Update Successfully done.');
    }

    public function delete($id) {
        try {
            $UserDetails = User::destroy($id);
            return response()->json(['error' => false, 'data' => $UserDetails]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => true, 'data' => $e->getMessage()]);
        }
    }

    public function lists() {
        $users = User::whereHas('authority', function ($q) {
            $q->where('authority_name', 'ADMIN')->orWhere('authority_name', 'AGENT');
        })->get();
        return DataTables::of($users)->addColumn('action', function ($user) {
            $auth = auth();
            if($auth->user()->authority->authority_name !== 'AGENT'):
            $btn = '<a href="javascript:void(0)" class="btn btn-xs btn-danger userDelete" data-id="' . $user->id . '"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
            $btn .= '<a href="' . url("users/edit/{$user->id}") . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
            return $btn;
            endif;
            return '';
        })->toJson();
    }
}
