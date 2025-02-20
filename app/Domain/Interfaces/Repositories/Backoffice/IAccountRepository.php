<?php

namespace App\Domain\Interfaces\Repositories\Backoffice;

interface IAccountRepository
{
    public function fetch($id);
    
    public function findOrFail($id);
}
