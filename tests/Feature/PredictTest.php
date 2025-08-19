<?php

namespace Tests\Feature;

use Tests\TestCase;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\PersistentModel;
use Rubix\ML\Datasets\Unlabeled;

class PredictTest extends TestCase
{
    public function test_kinyarwanda_greeting_prediction(): void
    {
        $persister = new Filesystem(storage_path('app/greeting_model.rbx'));
        $model = PersistentModel::load($persister);

        // Acceptable responses for 'Mwaramutse'
        $possibleResponses = [
            'Mwaramutse neza, amakuru yawe?',
            'Wiriwe neza, tugire umunsi mwiza.',
            // Add other possible close responses if needed
        ];

        $greeting = 'Mwaramutse';
        $sample = [[crc32($greeting)]];
        $prediction = $model->predict(Unlabeled::build($sample));
        $this->assertContains($prediction[0], $possibleResponses);

        // Test 2: Known follow-up as greeting
        $followupGreeting = 'Ndishimye ko umeze neza, mbwira icyo ngufasha mu mategeko cg urubanza witegura.';
        $followupSample = [[crc32($followupGreeting)]];
        $followupPrediction = $model->predict(Unlabeled::build($followupSample));
        $this->assertNotEmpty($followupPrediction[0]);

        // Test 3: Unknown greeting
        $unknownGreeting = 'Muraho neza';
        $unknownSample = [[crc32($unknownGreeting)]];
        $unknownPrediction = $model->predict(Unlabeled::build($unknownSample));
        $this->assertNotEmpty($unknownPrediction[0]);
    }
}
