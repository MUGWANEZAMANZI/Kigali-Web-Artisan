<?php

namespace App\Services;

use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\PersistentModel;
use Rubix\ML\Datasets\Unlabeled;

class GreetingService
{
    protected $model;

    public function __construct()
    {
        $persister = new Filesystem(storage_path('app/greeting_model.rbx'));
        $this->model = PersistentModel::load($persister);
    }

    public function predict(string $greeting): string
    {
        $sample = [[crc32($greeting)]];
        $prediction = $this->model->predict(Unlabeled::build($sample));
        return $prediction[0];
    }
}
