<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TrainLawModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:train-law-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train legal prediction system using keyword matching and confidence scoring (Python-inspired approach)';

    // Kinyarwanda legal keywords - same logic as Python system
    private array $legalKeywords = [
        'sexual_offense' => ['gusambanya', 'gukoresha', 'imibonano', 'igitsina', 'sexual', 'rape', 'umwana'],
        'theft' => ['kwiba', 'gufata', 'theft', 'steal', 'rob', 'amafaranga'],
        'violence' => ['gukubita', 'kwica', 'imbaraga', 'violence', 'murder', 'kill'],
        'privacy' => ['kwinjira', 'rugo', 'privacy', 'domicile', 'enter'],
        'fraud' => ['uburiganya', 'kwigana', 'fraud', 'cheat'],
    ];

    // Kinyarwanda stopwords for text cleaning
    private array $kinyarwandaStopwords = [
        'ni', 'na', 'ku', 'mu', 'nk', 'no', 'cyangwa', 'ariko', 'naho', 'none',
        'kandi', 'rero', 'ubwo', 'uko', 'ubu', 'aha', 'aho', 'iyo', 'ese',
        'nta', 'nti', 'nte', 'nto', 'ntu', 'ntw', 'aba', 'ari', 'hari',
        'kuri', 'muri', 'buri', 'abantu', 'umuntu', 'ibintu', 'ikintu'
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🏛️ TRAINING RWANDA LEGAL PREDICTION SYSTEM');
        $this->info('=========================================');
        $this->info('Using keyword matching and confidence scoring (Python-inspired approach)');

        // Use direct paths since Laravel helpers may not be available
        $greetingsPath = __DIR__ . '/../../../public/kinyarwanda_greetings.csv';
        $legalPath = __DIR__ . '/../../../public/dataset-all.csv';

        // Process legal dataset
        $legalData = $this->loadLegalDataset($legalPath);
        
        if (empty($legalData)) {
            $this->error('❌ Legal dataset not found or empty');
            return 1; // Command::FAILURE
        }

        $this->info("📊 Dataset loaded: " . count($legalData) . " legal provisions");

        // Create keyword index for fast searching
        $keywordIndex = $this->buildKeywordIndex($legalData);
        $this->info('🔍 Keyword index built with ' . count($keywordIndex) . ' unique terms');

        // Process greetings dataset  
        $greetingData = $this->loadGreetingDataset($greetingsPath);
        $this->info("💬 Greeting data loaded: " . count($greetingData) . " entries");

        // Save the processed data as JSON (replacing Rubix ML models)
        $this->saveLegalIndex($legalData, $keywordIndex);
        $this->saveGreetingData($greetingData);

        $this->info('✅ Training completed successfully!');
        $this->info('📝 Models saved as JSON for fast keyword-based predictions');
        
        // Test the system
        $this->testPredictionSystem($legalData, $keywordIndex);

        return 0; // Command::SUCCESS
    }

    /**
     * Load and parse legal dataset CSV
     */
    private function loadLegalDataset(string $filepath): array
    {
        if (!file_exists($filepath)) {
            return [];
        }

        $legalData = [];
        $file = fopen($filepath, 'r');
        
        // Skip header
        $header = fgetcsv($file);
        
        while (($row = fgetcsv($file)) !== false) {
            // Pad row to ensure all columns exist
            $row = array_pad($row, 6, '');
            
            $legalData[] = [
                'offence' => trim($row[0] ?? ''),
                'article' => trim($row[1] ?? ''),
                'punishment' => trim($row[2] ?? ''),
                'fine_min' => trim($row[3] ?? ''),
                'fine_max' => trim($row[4] ?? ''),
                'description' => trim($row[5] ?? ''),
                'combined_text' => trim($row[0] . ' ' . $row[1] . ' ' . $row[5])
            ];
        }
        
        fclose($file);
        return $legalData;
    }

    /**
     * Load greeting dataset CSV 
     */
    private function loadGreetingDataset(string $filepath): array
    {
        if (!file_exists($filepath)) {
            return [];
        }

        $greetingData = [];
        $file = fopen($filepath, 'r');
        $header = fgetcsv($file);
        
        while (($row = fgetcsv($file)) !== false) {
            $greetingData[] = $row;
        }
        
        fclose($file);
        return $greetingData;
    }

    /**
     * Build keyword index for fast searching (Python-inspired)
     */
    private function buildKeywordIndex(array $legalData): array
    {
        $keywordIndex = [];
        
        foreach ($legalData as $index => $law) {
            $text = strtolower($law['combined_text']);
            $words = $this->cleanAndTokenize($text);
            
            foreach ($words as $word) {
                if (!isset($keywordIndex[$word])) {
                    $keywordIndex[$word] = [];
                }
                $keywordIndex[$word][] = $index;
            }
        }
        
        return $keywordIndex;
    }

    /**
     * Clean and tokenize text (remove stopwords, normalize)
     */
    private function cleanAndTokenize(string $text): array
    {
        // Basic text cleaning
        $text = preg_replace('/[^a-zA-Z\s]/', '', $text);
        $words = array_filter(explode(' ', $text));
        
        // Remove stopwords
        $cleanWords = [];
        foreach ($words as $word) {
            $word = trim(strtolower($word));
            if (strlen($word) > 2 && !in_array($word, $this->kinyarwandaStopwords)) {
                $cleanWords[] = $word;
            }
        }
        
        return $cleanWords;
    }

    /**
     * Calculate similarity score using keyword matching (Python logic port)
     */
    private function calculateSimilarityScore(string $query, array $lawData): float
    {
        $queryWords = $this->cleanAndTokenize(strtolower($query));
        $lawText = strtolower($lawData['combined_text']);
        
        $score = 0.0;
        $maxScore = 0.0;
        
        // Check for direct keyword matches
        foreach ($queryWords as $word) {
            $maxScore += 1.0;
            if (strpos($lawText, $word) !== false) {
                $score += 1.0;
            }
        }
        
        // Check for category-specific keywords
        foreach ($this->legalKeywords as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($query, $keyword) !== false || strpos($lawText, $keyword) !== false) {
                    $score += 2.0; // Higher weight for category keywords
                    $maxScore += 2.0;
                }
            }
        }
        
        return $maxScore > 0 ? ($score / $maxScore) : 0.0;
    }

    /**
     * Find similar laws using keyword matching (Python port)
     */
    private function findSimilarLaws(string $query, array $legalData, int $topK = 3): array
    {
        $similarities = [];
        
        foreach ($legalData as $index => $law) {
            $similarity = $this->calculateSimilarityScore($query, $law);
            if ($similarity > 0) {
                $similarities[] = [
                    'index' => $index,
                    'similarity' => $similarity,
                    'law' => $law
                ];
            }
        }
        
        // Sort by similarity descending
        usort($similarities, function($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });
        
        return array_slice($similarities, 0, $topK);
    }

    /**
     * Save legal index as JSON (replaces Rubix ML models)
     */
    private function saveLegalIndex(array $legalData, array $keywordIndex): void
    {
        $storageDir = __DIR__ . '/../../../storage/app';
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        file_put_contents(
            $storageDir . '/legal_data.json',
            json_encode($legalData, JSON_PRETTY_PRINT)
        );
        
        file_put_contents(
            $storageDir . '/keyword_index.json', 
            json_encode($keywordIndex, JSON_PRETTY_PRINT)
        );
        
        $this->info('💾 Legal data and keyword index saved to storage/app/');
    }

    /**
     * Save greeting data as JSON
     */
    private function saveGreetingData(array $greetingData): void
    {
        $storageDir = __DIR__ . '/../../../storage/app';
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        file_put_contents(
            $storageDir . '/greeting_data.json',
            json_encode($greetingData, JSON_PRETTY_PRINT)
        );
        
        $this->info('💾 Greeting data saved to storage/app/');
    }

    /**
     * Test the prediction system with sample queries
     */
    private function testPredictionSystem(array $legalData, array $keywordIndex): void
    {
        $this->info('');
        $this->info('🧪 TESTING PREDICTION SYSTEM');
        $this->info('============================');
        
        $testQueries = [
            'Umuntu yashinje umukobwa we',
            'Yafashe amafaranga y\'ikigo',
            'Yica umuntu',
            'Yinjiye mu rugo rw\'undi'
        ];
        
        foreach ($testQueries as $query) {
            $this->info("Query: '$query'");
            $results = $this->findSimilarLaws($query, $legalData, 2);
            
            if (empty($results)) {
                $this->line('  ❌ No matches found');
            } else {
                foreach ($results as $result) {
                    $confidence = round($result['similarity'] * 100, 1);
                    $offence = substr($result['law']['offence'], 0, 50);
                    $this->line("  ✅ [{$confidence}%] {$offence}...");
                }
            }
            $this->line('');
        }
    }
}
