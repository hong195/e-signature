<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateUserSignatureJob;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class UserSignatureController extends Controller
{
    public function store(Request $request)
    {
        $id = $request->get('id');

        $user = User::where('id', $id)->with('contacts')->firstOrFail();
        $company = Company::where('id', $user->department->company_id)->firstOrFail();

        GenerateUserSignatureJob::dispatchNow($user, $company);

        $user->has_signature = true;
        $user->save();
    }
}
