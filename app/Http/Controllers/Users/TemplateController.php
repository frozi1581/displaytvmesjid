<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function create()
    {
        return view('users.templates.create');
    }

    public function edit($id)
    {
        $data =  Template::findOrFail($id);

        return view('users.templates.edit', [
            'data' => $data,
        ]);
    }

    public function index()
    {
        $limit = 5;
        $data =  Template::all();

        return view('users.templates.index', [
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data =  Template::findOrFail($id);

        return view('users.templates.show', [
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'direction' => 'required|in:debit,credit',
            'exchange' => 'required|in:nonmonetary,monetary',
            'description' => 'required|string',
            'time' => 'required|date|date_format:Y-m-d H:i',
        ]);

        $model = new Template();
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil menyimpan data.', null);

        return $this->sendError(500, 'Gagal menyimpan data.');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'direction' => 'required|in:debit,credit',
            'exchange' => 'required|in:nonmonetary,monetary',
            'description' => 'required|string',
            'time' => 'required|date|date_format:Y-m-d H:i',
        ]);

        $model = Template::findOrFail($id);
        $model->fill($data);
        $model->mosque_id = Auth::user()->mosque->id;

        if ($model->saveOrFail())
            return $this->sendSuccess(200, 'Berhasil merubah data.', null);

        return $this->sendError(500, 'Gagal merubah data.');
    }

    public function destroy($id)
    {
        if (Template::destroy($id))
            return $this->sendSuccess(200, 'Berhasil menghapus data.', null);

        return $this->sendError(500, 'Gagal menghapus data.');
    }

    public function truncate()
    {
        if (Template::truncate())
            return $this->sendSuccess(200, 'Berhasil menghapus semua data.', null);

        return $this->sendError(500, 'Gagal menghapus semua data.');
    }
}
