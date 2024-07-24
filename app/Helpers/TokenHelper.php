<?php

namespace App\Helpers;

use Carbon\Carbon;

class TokenHelper
{
    public static function generateToken()
    {
        $secret = config('app.token_secret'); // Ensure you have a secret key in your .env file
        $timestamp = Carbon::now()->timestamp;
        $interval = 60; // Token changes every 60 seconds
        $timeSlot = floor($timestamp / $interval);

        return hash_hmac('sha256', $timeSlot, $secret);
    }

    public static function validateToken($token)
    {
        $secret = config('app.token_secret');
        $timestamp = Carbon::now()->timestamp;
        $interval = 60;

        // Check current and previous time slots to allow for some clock drift
        $currentSlot = floor($timestamp / $interval);
        $previousSlot = $currentSlot - 1;

        $expectedTokenCurrent = hash_hmac('sha256', $currentSlot, $secret);
        $expectedTokenPrevious = hash_hmac('sha256', $previousSlot, $secret);

        return hash_equals($expectedTokenCurrent, $token) || hash_equals($expectedTokenPrevious, $token);
    }
}
