<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LectureController extends Controller
{
    public function create()
    {
        return view('users.lectures.create');
    }

    public function edit($id)
    {
        $data =  Lecture::findOrFail($id);

        return view('users.lectures.edit', [
            'data' => $data,
        ]);
    }

    public function index()
    {
        $limit = 5;
        $data =  Lecture::where('mosque_id',  Auth::user()->mosque->id)->get();

        return view('users.lectures.index', [
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data =  Lecture::findOrFail($id);

        return view('users.lectures.show', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic' => 'required|string',
            'description' => 'nullable|string',
            'speaker' => 'required|string',
            'time' => 'required|date|date_format:Y-m-d H:i',
        ]);

        $model = new Lecture();
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil menyimpan data.', null);

        return $this->sendError(500, 'Gagal menyimpan data.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'topic' => 'required|string',
            'description' => 'nullable|string',
            'speaker' => 'required|string',
            'time' => 'required|date|date_format:Y-m-d H:i',
        ]);

        $model = Lecture::findOrFail($id);
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil merubah data.', null);

        return $this->sendError(500, 'Gagal merubah data.');
    }

    public function destroy($id)
    {
        if (Lecture::destroy($id))
            return $this->sendSuccess(200, 'Berhasil menghapus data.', null);

        return $this->sendError(500, 'Gagal menghapus data.');
    }

    public function truncate()
    {
        if (Lecture::truncate())
            return $this->sendSuccess(200, 'Berhasil menghapus semua data.', null);

        return $this->sendError(500, 'Gagal menghapus semua data.');
    }
}
