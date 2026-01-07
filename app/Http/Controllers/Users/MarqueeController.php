<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Marquee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MarqueeController extends Controller
{
    public function create()
    {
        return view('users.marquees.create');
    }

    public function edit($id)
    {
        $data = Marquee::findOrFail($id);

        return view('users.marquees.edit', [
            'data' => $data
        ]);
    }

    public function index()
    {
        $data = Marquee::where('mosque_id',  Auth::user()->mosque->id)->get();

        return view('users.marquees.index', [
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data =  Marquee::findOrFail($id);

        return view('users.marquees.show', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $model = new Marquee();
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil menyimpan data.', null);

        return $this->sendError(500, 'Gagal menyimpan data.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'content' => 'required|string|min:1',
        ]);

        $model = Marquee::findOrFail($id);
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil merubah data.', null);

        return $this->sendError(500, 'Gagal merubah data.');
    }

    public function destroy($id)
    {
        if (Marquee::destroy($id))
            return $this->sendSuccess(200, 'Berhasil menghapus data.', null);

        return $this->sendError(500, 'Gagal menghapus data.');
    }

    public function truncate()
    {
        if (Marquee::truncate())
            return $this->sendSuccess(200, 'Berhasil menghapus semua data.', null);

        return $this->sendError(500, 'Gagal menghapus semua data.');
    }
}
