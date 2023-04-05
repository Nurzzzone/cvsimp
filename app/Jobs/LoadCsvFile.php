<?php

namespace App\Jobs;

use App\Services\FileReaders\Csv\Reader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LoadCsvFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private string $filepath)
    {
    }

    public function handle()
    {
        $reader = new Reader($this->filepath);
        
        $reader->read();

        $columns = $reader->headers();
        
        foreach($reader as $line) {
            $record = array_combine($columns, $line);

            DB::table('favorite_categories')->insert($record);
        }
    }
}
