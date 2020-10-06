<?php

namespace App\Http\Controllers;

use App\Models\UserLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserLocationController extends Controller
{

    public function show($user_id)
    {

        $location = Redis::get($user_id);

        if ($location) {
            return $location;
        } else {
            $location = UserLocation::where('user_id', $user_id)->first();
            if ($location) {
                Redis::set($user_id, json_encode($location));
                return $location;
            } else {
                abort(404);
            }
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response(null, 400);
        } else {
            $location = UserLocation::updateOrCreate(
                ['user_id' => $request['user_id']],
                ['latitude' => $request['latitude'], 'longitude' => $request['longitude']]
            );
            Redis::set($request['user_id'], json_encode($request->all()));
            return response(null, 201);
        }

    }
}
