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
        SELECT l.*, p.label projectName, lt.name type, lt.color from wabot_log l 
        left join wabot_project p ON p.id = l.project_id 
        inner join wabot_log_type lt on lt.id=l.log_type_id
        where L.datetime between ? and ?
        order by l.datetime desc
        limit 200
        ", [$dateStart, $dateEnd]);
        $res = $this->rawAsArray($res);

        return $res;
    }

    public function getRecentErrors($interval = 24)
    {
        $res = $this->raw("
        SELECT count(l.id) i FROM wabot_log l 
        WHERE l.log_type_id=3
        and l.datetime > date_sub(curdate(), interval ? HOUR) and verified=0
        ", [$interval]);
        $res = $this->rawAsArray($res, true, "i");

        return $res;
    }

    public function verifyError()
    {

    }
}