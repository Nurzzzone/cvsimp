<?php

namespace App\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;

 // this actually should be abstract (just keeping short)
class DiskWriter
{
    private Filesystem $storage;

    public function __construct(Filesystem $storage)
    {
        $this->storage = $storage;
    }

    public function write(UploadedFile $file, bool $tmp = false)
    {
        $filaname = $file->getClientOriginalName();

        if ($tmp) {
            $filename = 'tmp/' . $filaname;
        }

        $saved = $this->storage->put($filename, $file->getContent());

        if (! $saved) {
            throw new \RuntimeException('File not saved.');
        }

        // method actually should return void bc SRP (just keeping short)
        return $this->storage->path($filename);
    }
}