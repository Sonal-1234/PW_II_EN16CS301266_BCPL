<?php

namespace App\Http\Controllers;

use App\Address;
use App\Authority;
use App\Http\Requests\StoreOrganizationRequest;
use App\Organization;
use App\OrganizationAddress;
use App\User;
use App\UserAuthority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class OrganizationController extends Controller {

    public function index() {
        $organizationCount = Organization::select(['id'])->get()->count();
        return view('backend.organization-lists', compact('organizationCount'));
    }

    public function add() {
        return view('backend.organization');
    }

    public function store(StoreOrganizationRequest $storeOrganizationRequest) {
        $storeOrganizationRequest->validated();

        $logo = $storeOrganizationRequest->file('logo');
        $logoName = time() . '.' . $logo->getClientOriginalExtension();
        $logo->move(public_path('upload'), $logoName);

        DB::transaction(function () use ($storeOrganizationRequest, $logoName) {
            $organization = new Organization();
            $organization->name = $storeOrganizationRequest->name;
            $organization->email = $storeOrganizationRequest->email;
            $organization->owner_name = $storeOrganizationRequest->owner_name;
            $organization->pan_no = $storeOrganizationRequest->pan_no;
            $organization->registration_no = $storeOrganizationRequest->registration_no;
            $organization->organization_code = $storeOrganizationRequest->organization_code;
            $organization->logo = public_path('upload') . '/' . $logoName;
            $organization->gstin_no = $storeOrganizationRequest->gstin_no;
            $organization->is_default = $storeOrganizationRequest->is_default;
            $organization->save();

            $address = new OrganizationAddress();
            $address->organization_id = $organization->id;
            $address->type = OrganizationAddress::RESIDENCE;
            $address->phone1 = $storeOrganizationRequest->phone1;
            $address->phone2 = $storeOrganizationRequest->phone2;
            $address->address1 = $storeOrganizationRequest->address1;
            $address->address2 = $storeOrganizationRequest->address2;
            $address->address3 = $storeOrganizationRequest->address3;
            $address->city = $storeOrganizationRequest->city;
            $address->state = $storeOrganizationRequest->state;
            $address->postal_code = $storeOrganizationRequest->postal_code;
            $address->save();
        });

        return self::successResponse('Organization Data Successfully Saved.');
    }

    public function edit($id) {
        $organization = Organization::findOrFail($id);
        return view('backend.organization-edit', compact('organization'));
    }

    public function update(Request $request, $id) {
        $logoName = null;
        if (!empty($request->file('logo'))):
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('upload'), $logoName);
        endif;

        $organization = Organization::findOrFail($id);
        $organization->name = $request->name;
        $organization->email = $request->email;
        $organization->owner_name = $request->owner_name;
        $organization->pan_no = $request->pan_no;
        $organization->registration_no = $request->registration_no;
        $organization->organization_code = $request->organization_code;
        if (!empty($logoName)):
            $organization->logo = public_path('upload') . '/' . $logoName;
        endif;
        $organization->gstin_no = $request->gstin_no;
        $organization->is_default = $request->is_default;
        $organization->save();

        if (!empty($organization->address)):
            $address = OrganizationAddress::findOrFail($organization->address->id);
        else:
            $address = new OrganizationAddress();
        endif;
        $address->organization_id = $organization->id;
        $address->type = OrganizationAddress::RESIDENCE;
        $address->phone1 = $request->phone1;
        $address->phone2 = $request->phone2;
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->address3 = $request->address3;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->postal_code = $request->postal_code;
        $address->save();

        return self::successResponse('Organization Detail update successfully done.');
    }

    public function destroy($id) {

    }

    public function lists() {
        $users = Organization::select(['id', 'name', 'email', 'owner_name', 'organization_code', 'pan_no', 'gstin_no', 'registration_no', 'is_default'])->get();
        return DataTables::of($users)->addColumn('action', function ($user) {
            return '<a href="' . url("organizations/edit/" . $user->id) . '" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })->toJson();
    }
}
