<?php

namespace App\Http\Controllers;

use App\Jobs\LoadCsvFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv'
        ]);

        $file = $request->file('file');
        $filepath = 'tmp/' . $file->getClientOriginalName();

        Storage::put($filepath, $file->getContent());

        LoadCsvFile::dispatch(Storage::path($filepath));

        return response()->json(['success' => true]);
    }
}