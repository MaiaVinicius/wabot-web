<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class QueueModel extends BaseModel
{
    public function getNumberInQueue()
    {
        $res = $this->raw("SELECT count(id) Qtd FROM wabot_queue WHERE active=1");
        return $this->rawAsArray($res, true)["Qtd"];
    }
}