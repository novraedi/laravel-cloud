<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    // Fungsi untuk tampilan Upload
    public function upload()
    {
        $endpoint = "https://s3-jak01.storageraya.com/bucket-laravel";
        return view('upload', compact('endpoint'));
    }
    // Fungsi untuk proses Upload
    public function proses_upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        // menyimpan data file yang diupload ke variabel $file
        $file = $request->file('file');

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'laravel';

        // Proses Upload File ke Object Storage
        $result = Storage::disk('s3')->putFileAs($tujuan_upload, $file, $file->getClientOriginalName());
        // Proses merubah visibility file agar bisa di akses secara public
        Storage::disk('s3')->setVisibility($tujuan_upload . "/" . $file->getClientOriginalName(), "public");
        // Proses mengambil URL hasil upload
        echo Storage::disk('s3')->url($tujuan_upload . "/" . $file->getClientOriginalName());
        echo '<br>';

        print_r($result);
        die;
    }
}
