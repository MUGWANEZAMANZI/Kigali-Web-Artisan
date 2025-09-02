<?php

namespace App\Services;

use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\PersistentModel;
use Rubix\ML\Datasets\Unlabeled;

class GreetingService
{
    protected $promptModel;
    protected $greetingModel;

    public function __construct()
    {
        $promptPersister = new Filesystem(storage_path('app/prompt_classifier.rbx'));
        $this->promptModel = PersistentModel::load($promptPersister);

        $greetingPersister = new Filesystem(storage_path('app/greeting_model.rbx'));
        $this->greetingModel = PersistentModel::load($greetingPersister);
    }

    /**
     * Predicts the response for a given prompt.
     * @param string $prompt
     * @param string $lang 'rw'|'en'|'fr' (default 'rw')
     * @param string $type 'greeting'|'response'|'followup' (default 'greeting')
     */
    public function predict(string $prompt, string $lang = 'rw', string $type = 'greeting'): string
    {
        $category = $this->promptModel->predict(\Rubix\ML\Datasets\Unlabeled::build([$prompt]))[0];

        // If the category is a full row (contains '|||'), return it directly
        if (str_contains($category, '|||')) {
            return $category;
        }

        if ($category === 'greeting') {
            return $this->predictGreeting($prompt, $lang, $type);
        } elseif ($category === 'legal_question') {
            return $this->answerLegalQuestion($prompt);
        } elseif ($category === 'article') {
            return $this->summarizeArticle($prompt);
        }
        return "Sorry, I couldn't understand your request.";
    }

    /**
     * Predict greeting/response/followup in a specified language.
     * @param string $greeting
     * @param string $lang 'rw'|'en'|'fr'
     * @param string $type 'greeting'|'response'|'followup'
     */
    public function predictGreeting(string $greeting, string $lang = 'rw', string $type = 'greeting'): string
    {
        // Predict using the trained model (returns the closest match from all greetings/responses/followups)
        $predicted = $this->greetingModel->predict(\Rubix\ML\Datasets\Unlabeled::build([$greeting]))[0];

        // Try to extract the correct column from the CSV for the requested language/type
        $csvPath = public_path('kinyarwanda_greetings.csv');
        if (!file_exists($csvPath)) {
            return $predicted;
        }
        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);
        $colMap = [
            'rw' => ['greeting' => 'greeting', 'response' => 'response', 'followup' => 'followup'],
            'en' => ['greeting' => 'greeting_en', 'response' => 'response_en', 'followup' => 'followup_en'],
            'fr' => ['greeting' => 'greeting_fr', 'response' => 'response_fr', 'followup' => 'followup_fr'],
        ];
        $targetCol = $colMap[$lang][$type] ?? 'greeting';
        $colIdx = array_search($targetCol, $header);
        $result = $predicted;
        if ($colIdx !== false) {
            // Find the row where any greeting/response/followup column matches the predicted value
            while (($row = fgetcsv($handle)) !== false) {
                if (in_array($predicted, $row, true)) {
                    $result = $row[$colIdx] ?? $predicted;
                    break;
                }
            }
        }
        fclose($handle);
        return $result;
    }

    public function answerLegalQuestion(string $prompt): string
    {
        // Load dataset-all.csv and search for the most relevant description
        $csvPath = public_path('dataset-all.csv');
        if (!file_exists($csvPath)) {
            return 'Legal dataset not found.';
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);
        $bestScore = 0;
        $bestRow = null;
        while (($row = fgetcsv($handle)) !== false) {
            $description = $row[3] ?? '';
            similar_text(strtolower($prompt), strtolower($description), $percent);
            if ($percent > $bestScore) {
                $bestScore = $percent;
                $bestRow = $row;
            }
        }
        fclose($handle);

        if ($bestRow && $bestScore > 30) { // threshold for relevance
            $offence = $bestRow[0] ?? '';
            $article = $bestRow[1] ?? '';
            $category = $bestRow[2] ?? '';
            $description = $bestRow[3] ?? '';
            $punishment = $bestRow[4] ?? '';
            return "Icyo amategeko avuga:\nIcyaha: $offence\nIngingo: $article\nKategori: $category\nUbusobanuro: $description\nIgihano: $punishment";
        }
        return 'Ihangane, ntabwo mbonye icyo amategeko abivugaho.';
    }

    public function summarizeArticle(string $prompt): string
    {
        // Load dataset-all.csv and search for the most relevant article by offence or article name
        $csvPath = public_path('dataset-all.csv');
        if (!file_exists($csvPath)) {
            return 'Legal dataset not found.';
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);
        $bestScore = 0;
        $bestRow = null;
        while (($row = fgetcsv($handle)) !== false) {
            $offence = $row[0] ?? '';
            $article = $row[1] ?? '';
            $searchString = strtolower($offence . ' ' . $article);
            similar_text(strtolower($prompt), $searchString, $percent);
            if ($percent > $bestScore) {
                $bestScore = $percent;
                $bestRow = $row;
            }
        }
        fclose($handle);

        if ($bestRow && $bestScore > 30) { // threshold for relevance
            $offence = $bestRow[0] ?? '';
            $article = $bestRow[1] ?? '';
            $category = $bestRow[2] ?? '';
            $description = $bestRow[3] ?? '';
            $punishment = $bestRow[4] ?? '';
            return "Inshamake:\nIcyaha: $offence\nIngingo: $article\nKategori: $category\nUbusobanuro: $description\nIgihano: $punishment";
        }
        return 'Ihangane, ntabwo mbonye ingingo ijyanye n\'icyo wabajije.';
    }
}
