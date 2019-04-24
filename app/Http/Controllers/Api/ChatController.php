<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Friend;
use App\Events\NewMessage;
class ChatController extends Controller
{
    function get_message(Request $re) {
        if($re->has('chat_id')) {
            $found = Friend::find($re->chat_id)->toArray();
            if($found) {
                if($found['status'] == 1) {
                    return [
                        'status' => 'success',
                        'data' => $found
                    ];
                }
            }
        }
        return [
            'status' => 'error',
            'message' => 'Unable to get message for these users'
        ];
    }

    function submit_message(Request $re) {
        if($re->has('chat_id')) {
            $found = Friend::find($re->chat_id);
            if($found) {
                if($found->status == 1) {
                    $found->message = json_encode($re->message);
                    if($found->save()) {
                        event(new NewMessage($found));
                        return [
                            'status'  => 'success',
                            'message' => 'Message Sent successfully.'
                        ];
                    }
                }
            }
        }
        return [
            'status' => 'error',
            'message' => 'Unable to send message for these users'
        ];
    }
}
