<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class LogsModel extends BaseModel
{

    public function getLogs($dateStart, $dateEnd)
    {
        $res = $this->raw("
        SELECT l.*, p.label projectName, lt.name type from wabot_log l 
        left join wabot_project p ON p.id = l.project_id 
        inner join wabot_log_type lt on lt.id=l.log_type_id
        where L.datetime between ? and ?
        ", [$dateStart, $dateEnd]);
        $res = $this->rawAsArray($res);

        return $res;
    }
}