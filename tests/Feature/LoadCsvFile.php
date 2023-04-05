<?php

namespace Tests\Unit;

use App\Jobs\LoadCsvFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class LoadCsvFileTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_load_csv_file(): void
    {
        // arrange
        Storage::fake('local');
        
        Queue::fake()->except([
            LoadCsvFile::class
        ]);

        $row0 = 'Header 1,Header 2,Header 3';
        $row1 = 'value 1,value 2,value 3';
        $row2 = 'value 1,value 2,value 3';
        $row3 = 'value 1,value 2,value 3';

        $content = implode("\n", [$row0, $row1, $row2, $row3]);

        $file = UploadedFile::fake()->createWithContent('test.csv', $content);

        // act
        $response = $this->post('api/v1/favorite-category', ['file' => $file]);

        // assert
        $response->assertStatus(200);

        $response->assertExactJson([
            'success' => true
        ]);

        Storage::disk('local')->assertExists('tmp/test.csv');
    }
}
