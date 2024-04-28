<?php

namespace App\Domain\Interfaces\Repositories\Backoffice;

interface IStudentRepository
{
    public function fetch();

    public function saveData($request);

    public function findOrFail($id);

    public function deleteData($id);
}
