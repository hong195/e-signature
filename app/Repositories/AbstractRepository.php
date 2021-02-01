<?php


namespace App\Repositories;


use App\Repositories\Contracts\BaseEloquentRepositoryContract;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository implements BaseEloquentRepositoryContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $this->model = $this->findById($id);
        return $this->model->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->findBy('id', $id)->firstOrFail();
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findBy(string $field, $value)
    {
        return $this->model->where($field, $value);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function with(array $relations)
    {
        return $this->model->with($relations)->get();
    }

    public function setModel(Model $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }
}
