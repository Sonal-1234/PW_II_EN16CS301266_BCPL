<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Authority;
use App\Http\Requests\StoreAgentRequest;
use App\User;
use App\UserAuthority;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class AgentController extends Controller {

    public function index() {
        return view('backend.agent-lists');
    }

    public function add() {
        return view('backend.agent');
    }

    public function store(StoreAgentRequest $agentRequest) {
        $agentRequest->validated();

        DB::transaction(function () use ($agentRequest) {
            $password = uniqid();
            Log::info('password', [$password]);
            $user = new User();
            $user->name = $agentRequest->first_name . ' ' . $agentRequest->last_name;
            $user->email = $agentRequest->email;
            $user->password = Hash::make($password);
            $user->save();

            #set Authority of user
            $userAuthority = new UserAuthority();
            $userAuthority->user_id = $user->id;
            $userAuthority->authority_name = Authority::AGENT;
            $userAuthority->save();

            $agent = new Agent();
            $agent->user_id = $user->id;
            $agent->first_name = $agentRequest->first_name;
            $agent->last_name = $agentRequest->last_name;
            $agent->phone1 = $agentRequest->phone1;
            $agent->phone2 = $agentRequest->phone2;
            $agent->email = $agentRequest->email;
            $agent->save();
        });

        return self::successResponse('Organization Data Successfully Saved.');
    }

    public function lists() {
        $users = Agent::select(['id', 'first_name', 'last_name', 'phone1', 'phone2', 'email'])->get();
        return DataTables::of($users)->addColumn('action', function ($user) {
            return '<a href="' . url("agent-edit/" . $user->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })->toJson();
    }
}
