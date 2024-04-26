<?php

namespace App\Repositories;

use App\Models\AntreanTask;

class AntreanTaskRepository
{
    public function getByID($id)
    {
        return AntreanTask::where('id_antrean', $id)->first();
    }

    public function getOneByField($field, $value)
    {
        return AntreanTask::where($field, $value)->first();
    }

    public function getList(array $conditions = null, array $orders = null, array $selects = null)
    {
        return AntreanTask::when(
                ($selects != null),
                function ($select) use ($selects) {
                    $select->select($selects);
                }
            )
            ->when(
                ($conditions != null),
                function ($condition) use ($conditions) {
                    for ($i=0; $i < count($conditions); $i++) {
                        $condition->where(
                            $conditions[$i]["field"],
                            $conditions[$i]["operation"],
                            $conditions[$i]["value"]
                        );
                    }
                }
            )
            ->when(
                ($orders != null),
                function ($order) use ($orders) {
                    for ($i=0; $i < count($orders); $i++) {
                        $order->orderBy(
                            $orders[$i]["field"],
                            $orders[$i]["operation"]
                        );
                    }
                }
            )->get();
    }

    public function update($field, $value, $data)
    {
        return AntreanTask::where($field, $value)
            ->update($data);
    }

    public function delete($field, $value)
    {
        return AntreanTask::where($field, $value)->delete();
    }
}
