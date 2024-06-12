<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Validator;


class PusherController extends Controller
{
    public function authenticate(Request $request)
    {
        //     // Validate the incoming request parameters
        //     $request->validate([
        //         'channel_name' => 'required|string',
        //         'socket_id' => 'required|string',
        //     ]);

        //     try {
        //         // Initialize Pusher instance
        //         $pusher = new Pusher(
        //             config('broadcasting.connections.pusher.key'),
        //             config('broadcasting.connections.pusher.secret'),
        //             config('broadcasting.connections.pusher.app_id'),
        //             [
        //                 'cluster' => config('broadcasting.connections.pusher.options.cluster'),
        //                 'useTLS' => config('broadcasting.connections.pusher.options.useTLS'),
        //             ]
        //         );

        //         // Generate authentication token
        //         $auth = $pusher->socket_auth($request->channel_name, $request->socket_id);

        //         // Return the authentication token as JSON response
        //         return response()->json(['auth' => $auth]);
        //     } catch (\Exception $e) {
        //         // Handle any errors that occur during authentication
        //         \Log::error('Pusher authentication error: ' . $e->getMessage());
        //         return response()->json(['error' => 'Unable to authenticate.'], 500);
        //     }
        // }
        $return_data['response_code'] = 0;
        $return_data['message'] = 'Something went wrong, Please try again later.';

        $rules = ['message' => 'required'];
        $messages = ['message.required' => 'Please enter message to communicate.'];
        //         $validator = Validator::make($request->all(), $rules, $messages);
        //         if ($validator->fails()) {
        //             $message = implode("
        // ", $validator->messages()->all());
        //             $return_data['message'] = $message;
        //             return $return_data;
        //         }

        try {
            $options = [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ];

            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

            $response = $pusher->trigger('proud-prize-879', 'MessageSent', ['message' => $request->message]);
            if ($response) {
                $return_data['response_code'] = 1;
                $return_data['message'] = 'Success.';
            }
        } catch (\Exception $e) {
            $return_data['message'] = $e->getMessage();
        }
        return $return_data;
    }
}
