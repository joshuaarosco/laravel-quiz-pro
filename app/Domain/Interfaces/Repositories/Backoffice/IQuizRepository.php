<?php

namespace App\Domain\Interfaces\Repositories\Backoffice;

interface IQuizRepository
{
    public function fetch();

    public function saveData($request);

    public function findOrFail($id);

    public function deleteData($id);
}
