<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploaderController extends Controller
{
    public function image(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:png,jpg,gif,jpeg',
        ]);

        $imageName = time() .'-'. Str::random(16) . '.' . $request->file('image')->extension();
        $request->file('image')->move(public_path('uploads/pictures'), $imageName);

        return json_encode(['/uploads/pictures/' . $imageName]);
    }

    public function pdf(Request $request)
    {
        $validated = $request->validate([
            'pdf_file' => 'required|file|mimes:pdf',
            'fileId' => 'required|string',
        ]);

        $pdfName = time() .'-'. Str::random(16) . $request->fileId;
        $request->pdf_file->move(public_path('uploads/pdfs'), $pdfName);

        return json_encode(['/uploads/pdfs/' . $pdfName]);
    }
}
