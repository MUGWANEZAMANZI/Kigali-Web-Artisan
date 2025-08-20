<?php

namespace Tests\Feature;

use Tests\TestCase;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\PersistentModel;
use Rubix\ML\Datasets\Unlabeled;

class PredictTest extends TestCase
{
    public function test_prompt_classifier_and_routing(): void
    {
        $persister = new Filesystem(storage_path('app/prompt_classifier.rbx'));
        $model = PersistentModel::load($persister);

    // Test greeting
    $greeting = 'Mwaramutse'; 
    $category = $model->predict(\Rubix\ML\Datasets\Unlabeled::build([$greeting]))[0];
    $this->assertEquals('greeting', $category);

    // Test legal question (using a description from dataset)
    $legalQuestion = 'Forced sexual intercourse or penetration by force, threats, trickery, authority, or victim\'s vulnerability.';
    $legalCategory = $model->predict(\Rubix\ML\Datasets\Unlabeled::build([$legalQuestion]))[0];
    $this->assertEquals('legal_question', $legalCategory);

    // Test article (using an offence name from dataset)
    $articlePrompt = 'Sexual offence: Child Defilement';
    $articleCategory = $model->predict(\Rubix\ML\Datasets\Unlabeled::build([$articlePrompt]))[0];
    $this->assertEquals('article', $articleCategory);
    }
}
