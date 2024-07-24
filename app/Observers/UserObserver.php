<?php

namespace App\Observers;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserObserver
{
    /**
     * Handle the user "created" event.
     */
    public function creating(User $user) : void
    {
        $isAssistant = $user->role == UserRole::Assistant;
        $isStudent = $user->role == UserRole::Student;

        $existingUserWithEmail = User::where('email', $user->email)
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUserWithEmail) {
            $validator = Validator::make([], []);
            $validator->errors()->add('email', "The email {$user->email} is already taken.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        // Check if npm is unique for the same role
        $existingUserWithNpm = User::where('npm', $user->npm)
            ->where('role', $user->role)
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUserWithNpm) {
            $validator = Validator::make([], []);
            $validator->errors()->add('npm', "The npm {$user->npm} is already taken for the same role.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        if ($isStudent) {
            $user->email = "{$user->npm}@iflab.gunadarma.ac.id";
        }

        if ($isAssistant) {
            $user->email = "{$user->npm}-assisten@iflab.gunadarma.ac.id";
        }
    }

    /**
     * Handle the user "updated" event.
     */
    public function updating(User $user) : void
    {
        $isAssistant = $user->role == UserRole::Assistant;
        $isStudent = $user->role == UserRole::Student;

        $existingUserWithEmail = User::where('email', $user->email)
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUserWithEmail) {
            $validator = Validator::make([], []);
            $validator->errors()->add('email', "The email {$user->email} is already taken.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        $existingUserWithNpm = User::where('npm', $user->npm)
            ->where('role', $user->role)
            ->where('id', '!=', $user->id)
            ->first();

        if ($existingUserWithNpm) {
            $validator = Validator::make([], []);
            $validator->errors()->add('npm', "The npm {$user->npm} is already taken for the same role.");
            throw new ValidationException($validator, redirect()->back()->withErrors($validator)->withInput());
        }

        if ($isStudent) {
            $user->email = "{$user->npm}@iflab.gunadarma.ac.id";
        }

        if ($isAssistant) {
            $user->email = "{$user->npm}-assisten@iflab.gunadarma.ac.id";
        }
    }
}
