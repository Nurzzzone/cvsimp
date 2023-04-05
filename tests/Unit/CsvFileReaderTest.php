<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\DiskWriter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Services\FileReaders\Csv\Reader;

class CsvFileReaderTest extends TestCase
{
   
    /** @test */
    public function it_can_read_file(): void
    {
        // arrange
        $storage = Storage::fake('local');

        $row0 = 'Header 1,Header 2,Header 3';
        $row1 = 'value 1,value 2,value 3';
        $row2 = 'value 1,value 2,value 3';
        $row3 = 'value 1,value 2,value 3';

        $content = implode("\n", [$row0, $row1, $row2, $row3]);

        $file = UploadedFile::fake()->createWithContent('test.csv', $content);

        $diskWriter = new DiskWriter($storage);
        $filepath = $diskWriter->write($file, true);

        // act
        $reader = new Reader($filepath);
        $reader->read();

        // assert
        $this->assertCount(4, $reader);
        $this->assertSame(explode(',', $row0), $reader[0]);
        $this->assertSame(explode(',', $row1), $reader[1]);
        $this->assertSame(explode(',', $row2), $reader[2]);
        $this->assertSame(explode(',', $row3), $reader[3]);
    }

    /** @test */
    public function it_can_get_headers(): void
    {
        // arrange
        $storage = Storage::fake('local');

        $row0 = 'Header 1,Header 2,Header 3';
        $row1 = 'value 1,value 2,value 3';
        $row2 = 'value 1,value 2,value 3';
        $row3 = 'value 1,value 2,value 3';

        $content = implode("\n", [$row0, $row1, $row2, $row3]);

        $file = UploadedFile::fake()->createWithContent('test.csv', $content);

        $diskWriter = new DiskWriter($storage);
        $filepath = $diskWriter->write($file, true);

        // act
        $reader = new Reader($filepath);
        $reader->read();

        $this->assertSame(explode(',', $row0), $reader->headers());
    }
}
