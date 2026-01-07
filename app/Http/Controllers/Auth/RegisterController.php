<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        //dd($request);
        $datakirim['name'] = $request->name;
        $datakirim['email'] = $request->email;
        $datakirim['password'] = $request->password;
        $datakirim['password_confirmation'] = $request->password_confirmation;
        $datakirim['manager'] = $request->manager;
        $datakirim['phone'] = $request->phone;
        $datakirim['address'] = $request->address;
        $datakirim['city'] = $request->city;
        $datakirim['province'] = $request->province;
        $datakirim['postal_code'] = $request->postal_code;

        $this->create($datakirim);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'numeric'],
            'manager' => ['required', 'alpha', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'numeric'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->mosque()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'player_token' => Str::random(),
            'phone' => $data['phone'],
            'manager' => $data['manager'],
            'address' => $data['address'],
            'city' => $data['city'],
            'province' => $data['province'],
            'postal_code' => $data['postal_code'],
            'storage_path' => preg_replace('/\s+/', '', Str::uuid()) .'-'. sprintf("%04d", $user->id),
            'logo_url' => 'https://www.freepnglogos.com/uploads/logo-masjid-png/masjid-logo-design-free-download-20.png',
        ]);

        $user->mosque->configPlayers()->create([
            'background_before_adzan' => 'https://quotefancy.com/media/wallpaper/3840x2160/160684-George-Bernard-Shaw-Quote-Islam-is-the-best-religion-and-Muslims.jpg',
            'background_iqama_time' => 'https://quotefancy.com/media/wallpaper/3840x2160/160684-George-Bernard-Shaw-Quote-Islam-is-the-best-religion-and-Muslims.jpg',
            'background_player_silent' => 'https://cdn.britannica.com/75/130675-050-2A7B1B2D/pilgrims-Muslim-Great-Mosque-of-Mecca-Saudi.jpg',
            'calculation_method' => '3',
        ]);

        $user->mosque->configPrayers()->createMany([
            [
                'name' => 'imsak',
                'key' => 'Imsak',
                'box_background_class' => 'bg-grad-6',
                'order' => 0,
                'is_prayer_time' => 0,
            ],
            [
                'name' => 'subuh',
                'key' => 'Fajr',
                'box_background_class' => 'bg-grad-1',
                'order' => 1,
            ],
            [
                'name' => 'syuruq',
                'key' => 'Sunrise',
                'box_background_class' => 'bg-grad-7',
                'order' => 2,
                'is_prayer_time' => 0,
            ],
            [
                'name' => 'dzuhur',
                'key' => 'Dhuhr',
                'box_background_class' => 'bg-grad-2',
                'order' => 3,
            ],
            [
                'name' => 'ashar',
                'key' => 'Asr',
                'box_background_class' => 'bg-grad-3',
                'order' => 4,
            ],
            [
                'name' => 'maghrib',
                'key' => 'Maghrib',
                'box_background_class' => 'bg-grad-4',
                'order' => 5,
            ],
            [
                'name' => 'isya',
                'key' => 'Isha',
                'box_background_class' => 'bg-grad-5',
                'order' => 6,
            ],
        ]);

        $user->mosque->configPlayerIntervals()->create();
        $user->mosque->configPlayerShows()->create();

        //return $user;
        return redirect()->route('login')->with(['success' => 'Data Berhasil Tambahkan']);
    }
}
