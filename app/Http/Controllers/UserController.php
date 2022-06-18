<?php

namespace App\Http\Controllers;

use App\Services\MediaService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(
        protected UserService $user,
        protected MediaService $media,
    )
    {}

    /**
     * @param $id
     * @param $status
     * @return RedirectResponse|void
     */
    public function changeStatus($id, $status)
    {
        $user = $this->user->find($id);

        if($status == 0 || $status == 1 || $status == 2)
        {
            $user['status'] = $status;
            $user->update((array)$user);

            return redirect()->back()->with([
                'success' => 'Status updated successfully!'
            ]);
        }
    }

    public function edit($id)
    {
        $user = $this->user->find($id);

        if(!Auth::id() == $user->id && !Auth::user()->admin == 1)
        {
            return redirect()->back()->with([
                'error' => 'Your not authorized for this action!'
            ]);
        }
        return \view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|integer',
            'avatar' => 'nullable|image',
            'intake' => 'required|integer',
            'shift' => 'required',
            'lives' => 'nullable|string',
            'passing_year' => 'nullable',
            'university_id' => 'nullable',
            'current_job_designation' => 'nullable|string',
            'current_company' => 'nullable|string',
            'facebook' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'github' => 'nullable|url',
        ]);

        $user = $this->user->find($id);
//        dd($user);

        if(!Auth::id() == $user->id && !Auth::user()->admin == 1)
        {
            return redirect()->back()->with([
                'error' => 'Your not authorized for this action!'
            ]);
        }

        if($request?->avatar)
        {
            $data['avatar'] = $this->media->uploadImage($request->file('avatar'));
        }


        $this->user->updateUser($user, $data);
        $this->user->updateInformation($user, $data);

        return redirect()->back()->with([
            'success' => 'Profile updated successfully!'
        ]);
    }

}
