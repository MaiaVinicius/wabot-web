<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class ResponseModel extends BaseModel
{
    public function getLastResponses($limit = 4)
    {
        $res = $this->raw("SELECT * FROM wabot_response ORDER BY datetime DESC LIMIT ?", [$limit]);
        $res = $this->rawAsArray($res);

        return $res;
    }
}