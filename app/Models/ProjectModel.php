<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class ProjectModel extends BaseModel
{
    public function getProjects($status = false)
    {
        $res = $this->raw("
SELECT pj.*,ps.name statusName, (SELECT count(id) FROM wabot_sent WHERE sender_id=sen.id) numberSent 

FROM wabot_project pj 
INNER JOIN wabot_project_status ps ON ps.id=pj.status_id
LEFT JOIN wabot_sender sen ON sen.project_id = pj.id and sen.active=1 and sen.status_id=1

ORDER BY pj.active desc
");
        $res = $this->rawAsArray($res);

        return $res;
    }
}