<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;

class BaseRepository
{
    const PER_PAGE = 10;

    protected $model;

    public function save(array $inputs, array $conditions = ['id' => null])
    {
        return $this->model->updateOrCreate($conditions, $inputs);
    }

    public function paginate($limit = self::PER_PAGE, array $withRelation = null)
    {
        $query = $this->model->query();

        if ($withRelation) {
            $query->with($withRelation);
        }

        return $query->latest()->paginate($limit);
    }

    public function getAll(array $withRelation = null)
    {
        $query = $this->model->query();

        if ($withRelation) {
            $query->with($withRelation);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function deleteById($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $columnName
     * return bool | $columnName
     */
    protected function isValidSortColumn($columnName)
    {
        if (empty($columnName)) {
            return false;
        }

        if (!Schema::hasColumn($this->model->getTable(), trim($columnName))) {
            return false;
        }

        return trim($columnName);
    }

    /**
     * @param $columnName
     * return bool | $columnName
     */
    protected function isValidSortType($sortType)
    {
        if (empty($sortType)) {
            return false;
        }

        if (!in_array(strtolower(trim($sortType)), ['desc', 'asc'])) {
            return false;
        }

        return strtolower(trim($sortType));
    }
}