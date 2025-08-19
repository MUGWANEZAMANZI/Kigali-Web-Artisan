<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Transformers\MinMaxNormalizer;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\PersistentModel;

class GreetingTest extends TestCase
{
    public function test_kinyarwanda_greeting_training_and_saving(): void
    {
        // Load greetings from CSV with greeting, response, followup columns
        $path = public_path('kinyarwanda_greetings.csv');
        $rows = array_map('str_getcsv', file($path));
        $header = array_shift($rows);

        $samples = [];
        $labels = [];

        foreach ($rows as $row) {
            // $row[0] = greeting, $row[1] = response, $row[2] = followup
            $samples[] = [$row[0]];
            $labels[] = $row[1]; // Use response as label
        }

        // Convert greeting text to numeric feature
        $samples = array_map(fn($sample) => [crc32($sample[0])], $samples);

        // Normalize features
        $normalizer = new MinMaxNormalizer();
        $dataset = Labeled::build($samples, $labels);
        $normalizer->fit($dataset);
        $dataset->apply($normalizer);

        // Train model
        $estimator = new KNearestNeighbors(3);
        $estimator->train($dataset);

        // Save model
        $persister = new Filesystem(storage_path('app/greeting_model.rbx'), true);
        $model = new PersistentModel($estimator, $persister);
        $model->save();

        $this->assertTrue(true);
    }
}
