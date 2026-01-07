<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        return view('users.profiles.index');
    }

    public function information(Request $request, MessageBag $messageBag)
    {
        $validated = $request->validate([
            'logo' => 'required_without:logo_url|image|mimes:png,jpg,gif,jpeg,webp,svg',
            'name' => 'required|string|min:1|max:255',
            'email' => 'required|string|email|max:255',
        ], [
            'required_without' => 'The :attribute field is required.',
        ]);

        if (User::where('email', $validated['email'])->whereNot('id', Auth::id())->count()) {
            $messageBag->add('email', 'The email has already been taken.');

            return redirect()->back()->withErrors($messageBag);
        }

        $user = User::find(Auth::id());
        $mosque = $user->mosque;

        if ($request->file('logo')) {
            $image = $request->file('logo');
            $path = $mosque->storage_path . '/logo/';
            $filename = 'IMG-' . Str::random(8) . '_' . date('Ymd') . '.' . $image->extension();
            $validated['logo_url'] = $filename;
            Storage::disk('public')->putFileAs($path, $image, $filename);

            if ($mosque->logo_url)
                Storage::disk('public')->delete($mosque->logo_url);
        }

        $user->update($validated);
        $mosque->update($validated);

        return redirect()->back();
    }

    public function additional(Request $request, MessageBag $messageBag)
    {
        $validated = $request->validate([
            'phone' => 'required|numeric|digits_between:7,15',
            'manager' => 'required|string|min:1|max:255',
            'address' => 'required|string|min:1|max:255',
        ]);

        if (Mosque::where('phone', $validated['phone'])->whereNot('user_id', Auth::id())->count()) {
            $messageBag->add('phone', 'The email has already been taken.');

            return redirect()->back()->withErrors($messageBag);
        }

        $user = User::find(Auth::id());
        $mosque = $user->mosque;
        $mosque->update($validated);

        return redirect()->back();
    }


    public function password(Request $request, MessageBag $messageBag)
    {
        $validated = $request->validate([
            'current_password' => 'required|string|min:8|max:255',
            'password' => 'required|string|min:8|max:255|different:current_password|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->getAuthPassword())) {
            $messageBag->add('current_password', 'The provided password does not match your current password.');

            return redirect()->back()->withErrors($messageBag);
        }

        $user = User::find(Auth::id());
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back();
    }
}
