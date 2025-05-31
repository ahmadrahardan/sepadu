<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DokumenController extends Controller
{
    public function download($filename)
    {
        $fullPath = storage_path('app/public/dokumen_pengajuan/' . $filename);

        if (!file_exists($fullPath)) {
            abort(404, 'File tidak ditemukan.');
        }

        return response()->download($fullPath);
    }
}

