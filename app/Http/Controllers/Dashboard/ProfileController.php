<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfileController extends Controller
{
    public function editProfile()
    {
        $id = auth('admin')->user()->id;
        $admin = Admin::find($id);
        return view('dashboard.profile.edit', compact('admin'));
    }
    public function updateProfile(ProfileRequest $request)
    {

        try {

            $admin = Admin::find(auth('admin')->user()->id);


            if ($request->filled('password')) {
                $request->merge(['password' => bcrypt($request->password)]);
            }

            unset($request['id']);
            unset($request['password']);
            unset($request['password_confirmation']);

            $admin->update($request->all());

            return redirect()->back()->with([
                'success' => __('translation.success_massage'),
            ]);
        } catch (Exception $ex) {
           // return $ex;
            return redirect()->back()->with(['error' => __('translation.failed_massage')]);
        }
    }
}
