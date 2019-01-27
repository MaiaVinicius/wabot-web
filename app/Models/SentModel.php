<?php

namespace App\Models;

use App\Support\Model\BaseModel;

/**
 * Created by PhpStorm.
 * User: maiavinicius
 * Date: 27/01/19
 * Time: 15:06
 */
class SentModel extends BaseModel
{
    public function getQuantitySent($hoursInterval = 24, $today = false)
    {
        $sqlToday = "";

        if ($today) {
            $sqlToday = " AND date(datetime) = curdate()";
            $hoursInterval = 24;
        }

        $res = $this->raw("SELECT count(id) Qtd, sum(price) amount FROM wabot_sent WHERE datetime >= date_sub(curdate(), INTERVAL ? HOUR) {$sqlToday}", [$hoursInterval]);
        $sent = $this->rawAsArray($res, true);

        return [
            "quantity" => $sent["Qtd"],
            "amount" => $sent["amount"]
        ];
    }

    public function getLastSent($limit = 4)
    {
        $res = $this->raw("SELECT s.*, pj.label projectName FROM wabot_sent s INNER JOIN wabot_sender sen on sen.id=s.sender_id INNER JOIN wabot_project pj ON pj.id=sen.project_id ORDER BY s.datetime DESC LIMIT ?", [$limit]);
        $res = $this->rawAsArray($res);

        return $res;
    }
}