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
        $res = $this->raw("
SELECT res.*,
       proj.label projectName,
       (SELECT TIMESTAMPDIFF(SECOND, st.datetime, res.datetime)
        FROM wabot_sent st
        WHERE st.license_id = res.license_id
          AND st.appointment_id = res.appointment_id
          AND st.datetime < res.datetime
        ORDER BY st.datetime
        LIMIT 1)delayTime

FROM wabot_response res
       INNER JOIN wabot_project proj ON proj.license_id = res.license_id

WHERE res.from_me = 0

ORDER BY res.datetime DESC
LIMIT ?", [$limit]);
        $res = $this->rawAsArray($res);

        return $res;
    }


    public function getPeopleThatRespond($interval = 24)
    {
        $res = $this->raw("SELECT DISTINCT res.license_id, res.appointment_id, res.phone
FROM wabot_response res

INNER JOIN wabot_sent s ON s.license_id=res.license_id and s.appointment_id=res.appointment_id

WHERE res.from_me = 0
  AND s.datetime >= date_sub(CURDATE(), INTERVAL ? HOUR)", [$interval]);
        $res = $this->rawAsArray($res);

        return $res ? count($res) : 0;
    }


}