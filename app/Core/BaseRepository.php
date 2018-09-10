<?php

namespace App\Core;


/**
 * @property Registrar model
 */
class BaseRepository
{

    protected $model;


    public function getAll()
    {
        return $this->model->all();
    }


    public function getById($id)
    {
        $model = $this->model->findOrFail($id);
        return $model;
    }

    public function create(array $attr)
    {
        return $this->model->create($attr);
    }

    public function update($id, array $attr)
    {
        $model = $this->model->findOrFail($id);

        $model->update($attr);

        return $model;
    }

    public function delete($id)
    {
        $this->model->getById($id)->delete();

        return true;
    }
}