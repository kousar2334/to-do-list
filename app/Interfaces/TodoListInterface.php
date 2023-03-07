<?php

namespace App\Interfaces;

interface TodoListInterface
{

    public function store($data);

    public function lists($data);

    public function update($data);

    public function delete($id);
}
