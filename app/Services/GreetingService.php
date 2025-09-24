<?php

namespace App\Services;

class GreetingService
{
    protected array $legalData = [];
    protected array $keywordIndex = [];
    protected array $greetingData = [];

    public function __construct()
    {
        $legalDataPath = storage_path('app/legal_data.json');
        $keywordIndexPath = storage_path('app/keyword_index.json');
        $greetingDataPath = storage_path('app/greeting_data.json');
        if (file_exists($legalDataPath)) {
            $this->legalData = json_decode(file_get_contents($legalDataPath), true) ?? [];
        }
        if (file_exists($keywordIndexPath)) {
            $this->keywordIndex = json_decode(file_get_contents($keywordIndexPath), true) ?? [];
        }
        if (file_exists($greetingDataPath)) {
            $this->greetingData = json_decode(file_get_contents($greetingDataPath), true) ?? [];
        }
    }

    /**
     * Predicts the response for a given prompt.
     * @param string $prompt
     * @param string $lang 'rw'|'en'|'fr' (default 'rw')
     * @param string $type 'greeting'|'response'|'followup' (default 'greeting')
     */
    public function predict(string $prompt, string $lang = 'rw', string $type = 'greeting'): mixed
    {
        // Try to match as a legal question first
        $results = $this->findSimilarLaws($prompt, 3);
        if (!empty($results)) {
            return [
                'matches' => $results,
                'message' => count($results) > 0 ? null : "Ihangane, ntabwo mbonye icyo amategeko abivugaho."
            ];
        }
        // Otherwise, try to match as a greeting
        $greeting = $this->predictGreeting($prompt, $lang, $type);
        return [
            'greeting' => $greeting,
            'message' => $greeting ? null : "Sorry, I couldn't understand your request."
        ];
    }

    /**
     * Find similar laws using keyword matching and scoring.
     * @param string $prompt
     * @param int $topK
     * @return array
     */
    protected function findSimilarLaws(string $prompt, int $topK = 3): array
    {
        if (empty($this->legalData) || empty($this->keywordIndex)) {
            return [];
        }
        $similarities = [];
        foreach ($this->legalData as $index => $law) {
            $similarity = $this->calculateSimilarityScore($prompt, $law);
            if ($similarity > 0) {
                $similarities[] = [
                    'similarity' => round($similarity * 100, 1),
                    'law' => $law
                ];
            }
        }
        usort($similarities, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });
        return array_slice($similarities, 0, $topK);
    }

    /**
     * Calculate similarity score using keyword matching.
     */
    protected function calculateSimilarityScore(string $query, array $lawData): float
    {
        $queryWords = $this->cleanAndTokenize(strtolower($query));
        $lawText = strtolower($lawData['combined_text'] ?? '');
        $score = 0.0;
        $maxScore = 0.0;
        foreach ($queryWords as $word) {
            $maxScore += 1.0;
            if (strpos($lawText, $word) !== false) {
                $score += 1.0;
            }
        }
        // Optionally: add more advanced scoring here
        return $maxScore > 0 ? ($score / $maxScore) : 0.0;
    }

    /**
     * Clean and tokenize text (remove stopwords, normalize)
     */
    protected function cleanAndTokenize(string $text): array
    {
        $kinyarwandaStopwords = [
            'ni', 'na', 'ku', 'mu', 'nk', 'no', 'cyangwa', 'ariko', 'naho', 'none',
            'kandi', 'rero', 'ubwo', 'uko', 'ubu', 'aha', 'aho', 'iyo', 'ese',
            'nta', 'nti', 'nte', 'nto', 'ntu', 'ntw', 'aba', 'ari', 'hari',
            'kuri', 'muri', 'buri', 'abantu', 'umuntu', 'ibintu', 'ikintu'
        ];
        $text = preg_replace('/[^a-zA-Z\s]/', '', $text);
        $words = array_filter(explode(' ', $text));
        $cleanWords = [];
        foreach ($words as $word) {
            $word = trim(strtolower($word));
            if (strlen($word) > 2 && !in_array($word, $kinyarwandaStopwords)) {
                $cleanWords[] = $word;
            }
        }
        return $cleanWords;
    }

    /**
     * Predict greeting/response/followup in a specified language.
     */
    public function predictGreeting(string $greeting, string $lang = 'rw', string $type = 'greeting'): string
    {
        // Fallback: just return the first greeting in the dataset
        if (empty($this->greetingData)) {
            return '';
        }
        $header = $this->greetingData[0];
        $colMap = [
            'rw' => ['greeting' => 'greeting', 'response' => 'response', 'followup' => 'followup'],
            'en' => ['greeting' => 'greeting_en', 'response' => 'response_en', 'followup' => 'followup_en'],
            'fr' => ['greeting' => 'greeting_fr', 'response' => 'response_fr', 'followup' => 'followup_fr'],
        ];
        $targetCol = $colMap[$lang][$type] ?? 'greeting';
        $colIdx = array_search($targetCol, $header);
        $bestRow = null;
        $maxScore = 0;
        foreach (array_slice($this->greetingData, 1) as $row) {
            foreach ($row as $cell) {
                $score = similar_text(strtolower($greeting), strtolower($cell), $percent);
                if ($percent > $maxScore) {
                    $maxScore = $percent;
                    $bestRow = $row;
                }
            }
        }
        if ($bestRow && $colIdx !== false) {
            return $bestRow[$colIdx] ?? '';
        }
        return '';
    }
}
