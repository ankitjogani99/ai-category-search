<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use OpenAI;
use App\Models\Category;

class ImportCategories extends Command {
    protected $signature = 'import:categories';
    protected $description = 'Import categories from Excel and generate embeddings';

    public function handle() {
        $file = storage_path('app/public/Lynx_Keyword_Enhanced_Services.xlsx');
        $rows = Excel::toArray([], $file)[0];
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                continue;
            }

            $categoryName = trim($row[0] ?? '');
            if (!$categoryName || Category::where('name', $categoryName)->exists()) {
                continue;
            }

            $response = $client->embeddings()->create([
                'model' => 'text-embedding-ada-002',
                'input' => $categoryName,
            ]);

            Category::create([
                'name' => $categoryName,
                'embedding' => $response['data'][0]['embedding'],
            ]);
        }

        $this->info('Import completed.');
    }
}
