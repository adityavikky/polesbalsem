<?php

namespace App\Services;

use Exception;
use App\Http\Traits\BpjsAntrolTraits;
use App\BpjsSep;
use App\Models\Antrean;
use App\Models\AntreanTask;
use App\Repositories\AntreanTaskRepository;


class AntreanTaskService
{
    protected $antreanTaskRepository;

    public function __construct(AntreanTaskRepository $antreanTaskRepository)
    {
        $this->antreanTaskRepository = new $antreanTaskRepository;
    }

    public function update($idAntrian, $taskId)
    {
        $conditions = array(
            array(
                "field"     => "id_antrean",
                "value"     => $idAntrian,
                "operation" => "="
            ),
            // array(
            //     "field"     => "taskId",
            //     "value"     => $taskId,
            //     "operation" => "="
            // )
        );
        $orders = array(
            array(
                "field"     => "id_antrean",
                "operation" => "asc"
            )
        );
        $selects = array("id_antrean", "kodebooking", "taskid", "waktu");
        $check = $this->antreanTaskRepository->getList($conditions, $orders, $selects);
        dd($check);
    }
}
