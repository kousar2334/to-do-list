<?php

namespace App\Interfaces;

interface TaskInterface
{
    public function store($data);

    public function lists($data);

    public function deleteTask($id);
}
