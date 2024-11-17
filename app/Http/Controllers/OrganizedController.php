<?php

namespace App\Http\Controllers;

use App\Http\Requests\CkeckUserID;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\OrganizedLoginRequest;
use App\Http\Requests\OrganizedRequest;
use App\Http\Resources\OrganizedResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrganizedController extends BaseController
{
    public function register(OrganizedRequest $request)
    {
        $user = new User($request->all());
        $user->save();
        $expiresIn = $request->has('remember') ? Carbon::now()->addWeeks(1) : Carbon::now()->addHours(2);
        $accessToken = $user->createToken('MyApp')->accessToken;
        $token = $user->tokens->last();
        $token->expires_at = $expiresIn;
        $token->save();
        $data['token'] = $accessToken;
        $data['token_type'] = 'Bearer';
        $data['user'] =OrganizedResource::make($user);
        return $this->sendResponse($data, "Registration Done");
    }

    public function login(OrganizedLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return $this->sendError("this email is false");
        }
        if ($request->password != $user->password) {
            return $this->sendError("this password is false");
        }
        $accessToken = $user->createToken('authToken')->accessToken;
        $data['token'] = $accessToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = new OrganizedResource($user);
        return $this->sendResponse($data, "Login successfully");
    }

    public function editImg(CkeckUserID $request)
    {
        if ($request->hasFile('picture_url')) {
            $ext = $request->file('picture_url')->getClientOriginalExtension();
            $path = 'picture_url/users/';
            $name = time() . '.' . $ext;
            $request->file('picture_url')->move(public_path($path), $name);
            $picture_url = $path . $name;

            User::where('id', $request->user_id)->update([
                'picture_url' => $picture_url,
            ]);
            $user = User::find($request->user_id);
            $data['user'] = new OrganizedResource($user);
            return $this->sendResponse($data, "Edited successfully");
        } else {
            return $this->sendError("not found img");
        }

        // if ($request->hasFile("picture_url")) {
        //     $image = $request->file('picture_url');
        //     $imgpath = $image->store('images', 'public');
        //     User::where('id', $request->user_id)->update([
        //         'picture_url' => $imgpath,
        //     ]);
        //     $user = User::find($request->user_id);
        //     $data['user'] = new OrganizedResource($user);
        //     return $this->sendResponse($data, "Edited successfully");
        // } else {
        //     return $this->sendError("not found img");
        // }

    }

    //edit just name/bio/email/phone
    public function editProfile(EditUserRequest $request)
    {
        $user = Auth::user();
        $validait = $request->validated();
        $user->update($validait);
        $data['user'] = new OrganizedResource($user);
        return $this->sendResponse($data, "Edited successfully");
    }

    public function delete(CkeckUserID $request)
    {
        $user = User::where('id', $request->user_id)->first()->delete();
        if (!$user) {
            return $this->sendError(null, "delete done");
        } else {
            return $this->sendResponse(null, "delete done");
        }

    }
}
