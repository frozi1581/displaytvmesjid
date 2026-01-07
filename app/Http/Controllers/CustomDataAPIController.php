<?php

namespace App\Http\Controllers;

use App\Models\Mosque;
use Illuminate\Http\Request;

class CustomDataAPIController extends Controller
{
    public function index(Request $request)
    {
        // Inisialisasi is_refresh sebagai false
        $is_refresh = 0;

        // Membuat query builder
        $query = Mosque::query();

        // Memeriksa apakah token diberikan sebagai parameter
        if ($request->has('token')) {
            // Mencari mosque dengan player_token yang sesuai
           // $mosque = $query->where('player_token', $request->input('token'))->first(['id_mosque']);
            //dd($request->input('token'));

            $mosque = $query->where('player_token',$request->input('token'))->get();

            // Jika mosque ditemukan, set is_refresh menjadi true
            if ($mosque) {
                $is_refresh = $mosque[0]->is_refresh;
            }

            // Mengembalikan response sebagai JSON
            return response()->json(['is_refresh' => $is_refresh]);
        }

        // Jika token tidak disertakan, berikan response error
        return response()->json(['error' => 'Token is required'], 400);
    }

    public function updateRefreshStatus(Request $request)
    {
        // Pastikan token dan is_refresh diberikan sebagai parameter query
        $player_token = $request->query('player_token');
        $vIsRefresh = $request->query('vIsRefresh');

        if (!$player_token || $vIsRefresh === null) {
            return response()->json([
                'error' => 'Missing required parameters.'
            ], 400);
        }

        // Lakukan validasi nilai is_refresh apakah boolean
        if (!in_array($vIsRefresh, ['true', 'false', '1', '0'], true)) {
            return response()->json([
                'error' => 'Invalid parameter for vIsRefresh.'
            ], 400);
        }

        // Konversi vIsRefresh ke boolean
        $vIsRefresh = filter_var($vIsRefresh, FILTER_VALIDATE_BOOLEAN);

        // Cari dan perbarui mosque dengan player_token yang diberikan
        $mosque = Mosque::where('player_token', $player_token)->first();

        if ($mosque) {
            $mosque->is_refresh = $vIsRefresh;
            $mosque->save();

            return response()->json([
                'message' => 'Refresh status updated successfully.',
                'is_refresh' => $mosque->is_refresh,
            ]);
        } else {
            return response()->json([
                'message' => 'Mosque not found.'
            ], 404);
        }
    }



}
