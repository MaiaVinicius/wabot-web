<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use App\Models\ProjectModel;
use App\Models\QueueModel;
use App\Models\ResponseModel;
use App\Models\SentModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(QueueModel $queueModel, SentModel $sentModel, ResponseModel $responseModel, ProjectModel $projectModel)
    {
        $numberInQueue = $queueModel->getNumberInQueue();
        $sentsToday = $sentModel->getQuantitySent(24, true);

        $quantitySentInterval = 96;

        $sent = $sentModel->getQuantitySent($quantitySentInterval);

        $quantitySent24hours = $sent["quantity"];

        $lastResponses = $responseModel->getLastResponses();
        $lastSent = $sentModel->getLastSent();

        $peopleThatRespond = $responseModel->getPeopleThatRespond($quantitySentInterval);

        $projects = $projectModel->getProjects();

        return view("dashboard", [
            "numberInQueue" => $numberInQueue,
            "quantitySent24hours" => $quantitySent24hours,
            "amountProfit" => $sent["amount"],
            "quantitySentInterval" => $quantitySentInterval,
            "lastSent" => $lastSent,
            "projects" => $projects,
            "peopleThatRespond" => $peopleThatRespond,
            "avgRespond" => round($peopleThatRespond / $quantitySent24hours, 2) * 100,
            "totalSentToday" => $sentsToday["quantity"],
            "totalQueueToday" => $sentsToday["quantity"] + $numberInQueue,
        ]);
    }

    public function sent(SentModel $sentModel)
    {
        $lastSent = $sentModel->getLastSent(100);

        return view("sent", [
            "lastSent" => $lastSent,
        ]);
    }
    public function logs(LogsModel $logsModel)
    {
        $dateStart = date("Y-m-d");
        $dateEnd = date("Y-m-d", strtotime("+1 day"));

        $logs = $logsModel->getLogs($dateStart, $dateEnd);

        return view("logs", [
            "logs" => $logs,
        ]);
    }

    public function reply(ResponseModel $responseModel)
    {
        $lastReplies = $responseModel->getLastResponses(100);

        return view("reply", [
            "lastReplies" => $lastReplies,
            "formatDelay" => function ($seconds) {
                if ($seconds <= 0) {
                    return null;
                }

                if ($seconds < 60) {
                    return $seconds . " segundo(s)";
                } elseif ($seconds < 3600) {
                    return round($seconds / 60, 2) . " minutos";
                } elseif ($seconds) {
                    return round($seconds / 3600, 2) . " horas";
                }

                return null;
            }
        ]);
    }
}
