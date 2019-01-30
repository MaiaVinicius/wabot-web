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
       0 delayTime

FROM wabot_response res
       INNER JOIN wabot_project proj ON proj.license_id = res.license_id

WHERE res.from_me = 0

ORDER BY res.datetime DESC
LIMIT ?", [$limit]);
        $res = $this->rawAsArray($res);

        return $res;
    }


    public function getQuantityRespond($hoursInterval = 24, $today = false)
    {
        $sqlToday = "";

        if ($today) {
            $sqlToday = " AND date(datetime) = curdate()";
            $hoursInterval = 24;
        }

        $res = $this->raw("SELECT count(id) Qtd FROM wabot_response WHERE from_me=0 AND datetime >= date_sub(curdate(), INTERVAL ? HOUR) {$sqlToday}", [$hoursInterval]);
        $sent = $this->rawAsArray($res, true);

        return $sent["Qtd"];
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


    public function getPhoneMessages($phone)
    {
        $res = $this->raw("
        
        SELECT res.*, proj.label projectName FROM wabot_response res 
        left join wabot_project proj on proj.license_id=res.license_id
        WHERE phone=? 
        
        ORDER BY IF(res.from_me=1,res.datetime,date_sub(res.datetime, interval 2 second )) asc
        
        ", [$phone]);

        if(!$res){
//            nao inseriu como uma resposta from_me = 1

            $res = $this->raw("
        
        SELECT res.*, 1 from_me, proj.label projectName FROM wabot_sent res 
        left join wabot_project proj on proj.license_id=res.license_id
        WHERE phone=? 
        
        ORDER BY res.datetime asc
        
        ", [$phone]);
        }

        return $this->rawAsArray($res);
    }
}