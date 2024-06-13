<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use Validator;

class PusherController extends Controller
{
    public function authenticate(Request $request)
    {
        // Example of channel and socket_id validation
        $validator = Validator::make($request->all(), [
            'channel_name' => 'required|string',
            'socket_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid request.'], 400);
        }

        try {
            // Initialize Pusher instance
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                    'useTLS' => config('broadcasting.connections.pusher.options.useTLS'),
                ]
            );

            // Generate authentication token
            $auth = $pusher->socket_auth($request->channel_name, $request->socket_id);

            // Return the authentication token as JSON response
            return response()->json(['auth' => $auth]);
        } catch (\Exception $e) {
            // Handle any errors that occur during authentication
            \Log::error('Pusher authentication error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to authenticate.'], 500);
        }
    }

    public function sendMessage(Request $request)
    {
        $return_data['response_code'] = 0;
        $return_data['message'] = 'Something went wrong. Please try again later.';

        // Validate the request
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return response()->json(['error' => $errors], 400);
        }

        try {
            // Initialize Pusher instance
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                [
                    'cluster' => env('PUSHER_APP_CLUSTER'),
                    'useTLS' => true
                ]
            );

            // Trigger the event
            $response = $pusher->trigger('channel_name', 'MessageSent', ['message' => $request->message]);

            if ($response) {
                $return_data['response_code'] = 1;
                $return_data['message'] = 'Message sent successfully.';
            } else {
                $return_data['message'] = 'Failed to send message.';
            }
        } catch (\Exception $e) {
            \Log::error('Pusher message sending error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send message.'], 500);
        }

        return response()->json($return_data);
    }
}
