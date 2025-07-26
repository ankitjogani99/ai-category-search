<?php

namespace App\Services;

use App\Models\Category;
use OpenAI;

class SemanticSearchService {

    /**
     * Perform semantic search and return top matching categories.
     *
     * @param string $query
     * @return array
     */
    public function search(string $query): array {
        $client = OpenAI::client(env('OPENAI_API_KEY'));

        // Generate embedding for user query
        $inputEmbedding = $client->embeddings()->create([
            'model' => 'text-embedding-ada-002',
            'input' => $query,
        ])['data'][0]['embedding'];

        // Compare query with all stored categories
        $results = [];
        $categories = Category::all();
        foreach ($categories as $category) {
            $score = $this->cosineSimilarity($inputEmbedding, $category->embedding);
            $results[] = [
                'name' => $category->name,
                'score' => $score,
            ];
        }

        usort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        return array_slice($results, 0, 5);
    }

    /**
     * Calculate cosine similarity between two embedding vectors.
     *
     * @param  array $a
     * @param  array $b
     * @return float
     */
    private function cosineSimilarity(array $a, array $b): float {
        $dot = $normA = $normB = 0.0;
        for ($i = 0; $i < count($a); $i++) {
            $dot += $a[$i] * $b[$i];
            $normA += $a[$i] ** 2;
            $normB += $b[$i] ** 2;
        }

        return ($normA && $normB) ? $dot / (sqrt($normA) * sqrt($normB)) : 0.0;
    }
}
