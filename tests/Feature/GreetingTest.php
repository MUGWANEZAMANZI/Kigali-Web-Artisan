<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Classifiers\SoftmaxClassifier;
use Rubix\ML\Transformers\TextNormalizer;
use Rubix\ML\Transformers\StopWordFilter;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Pipeline;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\PersistentModel;

class GreetingTest extends TestCase
{
    public function test_prompt_category_training_and_saving(): void
    {
        // Load greetings and legal data manually, pad/truncate rows to match header count
        $greetingsPath = public_path('kinyarwanda_greetings.csv');
        $legalPath = public_path('dataset-all.csv');

    $samples = [];
    $labels = [];
    $greetingSamples = [];
    $greetingLabels = [];
    $legalRows = [];
        // Read greetings CSV (all languages: Kinyarwanda, English, French)
        if (file_exists($greetingsPath)) {
            $greetingFile = fopen($greetingsPath, 'r');
            $greetingHeader = fgetcsv($greetingFile);
            $greetingColCount = count($greetingHeader);
            // Get column indexes for all greeting/response/followup columns
            $greetingCols = [];
            $responseCols = [];
            $followupCols = [];
            foreach ($greetingHeader as $i => $col) {
                if (str_contains($col, 'greeting')) { $greetingCols[] = $i; }
                if (str_contains($col, 'response')) { $responseCols[] = $i; }
                if (str_contains($col, 'followup')) { $followupCols[] = $i; }
            }
            while (($row = fgetcsv($greetingFile)) !== false) {
                $row = array_pad($row, $greetingColCount, '');
                $row = array_slice($row, 0, $greetingColCount);
                // For each language, add greeting/response/followup as samples
                foreach ($greetingCols as $i) {
                    $prompt = $row[$i] ?? '';
                    if ($prompt) {
                        $samples[] = $prompt;
                        $labels[] = 'greeting';
                        $greetingSamples[] = $prompt;
                        // Try to find matching response in same language
                        $respIdx = $responseCols[$greetingCols ? array_search($i, $greetingCols) : 0] ?? null;
                        if ($respIdx !== null && ($row[$respIdx] ?? '')) {
                            $greetingLabels[] = $row[$respIdx];
                        } else {
                            $greetingLabels[] = '';
                        }
                    }
                }
                foreach ($responseCols as $i) {
                    $prompt = $row[$i] ?? '';
                    if ($prompt) {
                        $samples[] = $prompt;
                        $labels[] = 'greeting';
                        $greetingSamples[] = $prompt;
                        // Try to find matching followup in same language
                        $followIdx = $followupCols[$responseCols ? array_search($i, $responseCols) : 0] ?? null;
                        if ($followIdx !== null && ($row[$followIdx] ?? '')) {
                            $greetingLabels[] = $row[$followIdx];
                        } else {
                            $greetingLabels[] = '';
                        }
                    }
                }
            }
            fclose($greetingFile);
        }

        // Read legal CSV (Law-Name,Category,Chapter,Article-Category,Article-Number,Article-Description,Punishment,...)
        if (file_exists($legalPath)) {
            $legalFile = fopen($legalPath, 'r');
            $legalHeader = fgetcsv($legalFile);
            $legalColCount = count($legalHeader);
            while (($row = fgetcsv($legalFile)) !== false) {
                $row = array_pad($row, $legalColCount, '');
                $row = array_slice($row, 0, $legalColCount);
                $offence = trim($row[0] ?? '');
                $article = trim($row[1] ?? '');
                $desc = trim($row[5] ?? ''); // Article-Description
                // Use all columns as label, joined by a separator
                $rowLabel = implode('|||', $row);
                // Add each column as a sample for matching
                foreach ([$offence, $article, $desc] as $sample) {
                    if ($sample) {
                        $samples[] = $sample;
                        $labels[] = $rowLabel;
                    }
                }
                $legalRows[] = $row;
            }
            fclose($legalFile);
        }


        // Train prompt category classifier using text pipeline
        $dataset = new Labeled($samples, $labels);
        $pipeline = new Pipeline([
            new TextNormalizer(),
            new StopWordFilter(),
            new WordCountVectorizer(10000),
        ], new SoftmaxClassifier());
        $promptModel = new PersistentModel($pipeline, new Filesystem(storage_path('app/prompt_classifier.rbx'), true));
        $promptModel->train($dataset);
        $promptModel->save();

        // Train greeting response model (for emotional/sentiment response) using KNN on vectorized greetings
        if (count($greetingSamples) > 0 && count($greetingLabels) > 0) {
            // Use the same pipeline for vectorization
            $greetingDataset = new Labeled($greetingSamples, $greetingLabels);
            $greetingPipeline = new Pipeline([
                new TextNormalizer(),
                new StopWordFilter(),
                new WordCountVectorizer(10000),
            ], new KNearestNeighbors(3));
            $greetingModel = new PersistentModel($greetingPipeline, new Filesystem(storage_path('app/greeting_model.rbx'), true));
            $greetingModel->train($greetingDataset);
            $greetingModel->save();
        }

        $this->assertTrue(true);
    }

    public function test_greeting_response_training_and_saving(): void
    {
        $greetingsPath = public_path('kinyarwanda_greetings.csv');
        $samples = [];
        $labels = [];

        if (file_exists($greetingsPath)) {
            $file = fopen($greetingsPath, 'r');
            $header = fgetcsv($file);
            $colCount = count($header);
            // Find greeting/response columns by language
            $greetingCols = [];
            $responseCols = [];
            foreach ($header as $i => $col) {
                if (str_starts_with($col, 'greeting')) { $greetingCols[] = $i; }
                if (str_starts_with($col, 'response')) { $responseCols[] = $i; }
            }
            while (($row = fgetcsv($file)) !== false) {
                $row = array_pad($row, $colCount, '');
                $row = array_slice($row, 0, $colCount);
                // For each language, pair greeting with its response
                foreach ($greetingCols as $idx => $greetIdx) {
                    $greeting = trim($row[$greetIdx] ?? '');
                    $response = trim($row[$responseCols[$idx] ?? -1] ?? '');
                    if ($greeting && $response) {
                        $samples[] = $greeting;
                        $labels[] = $response;
                    }
                }
            }
            fclose($file);
        }

        // Train greeting response model using pipeline (vectorizer + classifier)
        if (count($samples) > 0 && count($labels) > 0) {
            $dataset = new Labeled($samples, $labels);
            $pipeline = new Pipeline([
                new TextNormalizer(),
                new StopWordFilter(),
                new WordCountVectorizer(10000),
            ], new KNearestNeighbors(3));
            $model = new PersistentModel($pipeline, new Filesystem(storage_path('app/greeting_response.rbx'), true));
            $model->train($dataset);
            $model->save();
        }

        $this->assertTrue(true);
    }
}
