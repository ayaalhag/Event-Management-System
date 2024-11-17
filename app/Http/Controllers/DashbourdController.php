<?php

namespace App\Http\Controllers;
use App\Models\Status;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Requests\DashbourdRequest;
use App\Http\Requests\DashbourdLoginRequest;
use App\Http\Requests\CkeckUserID;
use App\Http\Resources\OrganizedResource;
Use App\Http\Requests\DeleteEventRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;

use Carbon\Carbon;

class DashbourdController extends BaseController
{
    public function register(DashbourdRequest $request)
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
        $data['user'] = new OrganizedResource($user);
        return $this->sendResponse($data, "Registration Done");
    }


    public function login(DashbourdLoginRequest $request)
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

    public function editeStatuse(DeleteEventRequest $request)
    {
        $event=Event::find($request->event_id);
        $parts = $event->parts()->get();
        $totalPrice = 0;
        foreach ($parts as $part) {
            $part_price = $part->price;
            $part_number = $part->pivot->number;
            $totalPrice += $part_price * $part_number;
        }

        $status = Status::where('id',$event->status_id )->first();
        $event_status= $status ? $status->name : null;
        if($request->status=='In Preparation'&& $event_status=='Sent')
        {
            $user= User::find($event->user_id);
            if($user->balance>=$totalPrice){
                $user->balance-=$totalPrice;
                $status_id=Status::where('name','In Preparation')->value('id');
                $event->status_id=$status_id;
                $user->save();
                $event->save();
                $data['user']=$user;
                $data['event']=$event;
                return $this->sendResponse($data, "status now is In Preparation");
            }
            else
            {
            return $this->sendError("Insufficient balance");
            }
        }
        else if($request->status=='Ongoing'&& $event_status=='In Preparation')
        {
            $status_id=Status::where('name','Ongoing')->value('id');
            $event->status_id=$status_id;
            $event->save();
            return $this->sendResponse($event, "status now is Ongoing");
        }
        else if($request->status=='Completed'&& $event_status=='Ongoingn')
        {
            $status_id=Status::where('name','Completed')->value('id');
            $event->status_id=$status_id;
            $event->save();

            return $this->sendResponse($event, "status now is Completed");
        }
        return $this->sendResponse($event,'The status has not been changed');
    }
    public function addBalance(EditUserRequest $request)
    {
        if($request->balance &&$request->balance>0){
            $user = User::find($request->user_id);
            $balance=$user->balance + $request->balance;
            $user->balance =$balance;
            $user->save();
            return $this->sendResponse($user, "Edited successfully");
        }
        else
        return $this->sendError(" erorr value");
    }
    public function showall()
    {
        $user = User::all();
        return $this->sendResponse($user, "users:");

    }
    public function ShowById(CkeckUserID $request)
    {
         $user =User::where('id', $request->user_id)->get();
        return $this->sendResponse($user, "users");
    }
}
