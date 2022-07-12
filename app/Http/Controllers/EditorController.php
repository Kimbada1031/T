<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditorController extends Controller
{
    public function upload(Request $request)
    {
        if (!$request->hasFile('upload')) {
            return response()->json([
                'message' => '파일이 정상적으로 업로드되지 않았습니다'
            ], 400);
        }
        $uploadFile = $request->file('upload');

        // 파일이 한개일때 배열에 담아줌 (아래 코드를 여러개일때도 같이 쓰게)
        if (!is_array($uploadFile)) {
            $uploadFile = [$uploadFile];
        }

        $urls = [];
        foreach ($uploadFile as $file) {
            $ext = $file->getClientOriginalExtension();
            $file_name = uniqid(rand(), false).'.'.$ext;

            $dirpath = 'editor/upload/';

            Storage::disk('local')->put('public/'.$dirpath.$file_name, file_get_contents($file));

            //$urls[] = config('app.url').'/storage/'.$dirpath.$file_name;
            $urls[] = Storage::url('public/'.$dirpath.$file_name);
        }

        return response()->json([
            'url' => $urls,
        ]);
    }
}
