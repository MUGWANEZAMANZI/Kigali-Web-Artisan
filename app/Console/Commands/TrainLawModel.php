<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Classifiers\SoftmaxClassifier;
use Rubix\ML\Transformers\TextNormalizer;
use Rubix\ML\Transformers\StopWordFilter;
use Rubix\ML\Transformers\WordCountVectorizer;
use Rubix\ML\Pipeline;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\PersistentModel;

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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $greetingsPath = public_path('kinyarwanda_greetings.csv');
        $legalPath = public_path('dataset-all.csv');

        $samples = [];
        $labels = [];
        $greetingSamples = [];
        $greetingLabels = [];
        $legalRows = [];

        // Read greetings CSV
        if (file_exists($greetingsPath)) {
            $greetingFile = fopen($greetingsPath, 'r');
            $greetingHeader = fgetcsv($greetingFile);
            $greetingColCount = count($greetingHeader);
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
                foreach ($greetingCols as $i) {
                    $prompt = $row[$i] ?? '';
                    if ($prompt) {
                        $samples[] = $prompt;
                        $labels[] = 'greeting';
                        $greetingSamples[] = $prompt;
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

        // Read legal CSV
        if (file_exists($legalPath)) {
            $legalFile = fopen($legalPath, 'r');
            $legalHeader = fgetcsv($legalFile);
            $legalColCount = count($legalHeader);
            while (($row = fgetcsv($legalFile)) !== false) {
                $row = array_pad($row, $legalColCount, '');
                $row = array_slice($row, 0, $legalColCount);
                $offence = trim($row[0] ?? '');
                $article = trim($row[1] ?? '');
                $desc = trim($row[5] ?? '');
                $rowLabel = implode('|||', $row);
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

        // Train prompt category classifier
        $dataset = new Labeled($samples, $labels);
        $pipeline = new Pipeline([
            new TextNormalizer(),
            new StopWordFilter(),
            new WordCountVectorizer(10000),
        ], new SoftmaxClassifier());
        $promptModel = new PersistentModel($pipeline, new Filesystem(storage_path('app/prompt_classifier.rbx'), true));
        $promptModel->train($dataset);
        $promptModel->save();
        $this->info('Prompt category model trained and saved.');

        // Train greeting response model
        if (count($greetingSamples) > 0 && count($greetingLabels) > 0) {
            $greetingDataset = new Labeled($greetingSamples, $greetingLabels);
            $greetingPipeline = new Pipeline([
                new TextNormalizer(),
                new StopWordFilter(),
                new WordCountVectorizer(10000),
            ], new KNearestNeighbors(3));
            $greetingModel = new PersistentModel($greetingPipeline, new Filesystem(storage_path('app/greeting_model.rbx'), true));
            $greetingModel->train($greetingDataset);
            $greetingModel->save();
            $this->info('Greeting response model trained and saved.');
        }

        return self::SUCCESS;
    }
}
