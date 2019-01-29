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
    public function index(QueueModel $queueModel, SentModel $sentModel,
                          ResponseModel $responseModel,
                          ProjectModel $projectModel,
                          LogsModel $logsModel
    )
    {
        $numberInQueue = $queueModel->getNumberInQueue();

        $quantitySentInterval = 72;

        $sentsToday = $sentModel->getQuantitySent($quantitySentInterval, true);


        $responses = $responseModel->getQuantityRespond($quantitySentInterval);

        $sent = $sentModel->getQuantitySent($quantitySentInterval);

        $quantitySent24hours = $sent["quantity"];


        $lastResponses = $responseModel->getLastResponses();
        $lastSent = $sentModel->getLastSent();

        $peopleThatRespond = $responseModel->getPeopleThatRespond($quantitySentInterval);

        $projects = $projectModel->getProjects();

        return view("dashboard", [
            "numberInQueue" => $numberInQueue,
            "quantitySent24hours" => $quantitySent24hours,
            "amountProfit" => round($sent["amount"], 2),
            "quantitySentInterval" => $quantitySentInterval,
            "quantityRespond" => $responses,
            "lastSent" => $lastSent,
            "projects" => $projects,
            "peopleThatRespond" => $peopleThatRespond,
            "avgRespond" => round(($peopleThatRespond / $quantitySent24hours * 100), 2),
            "totalSentToday" => $sentsToday["quantity"],
            "totalQueueToday" => $sentsToday["quantity"] + $numberInQueue,

            "lastErrors" => $logsModel->getRecentErrors(24),
            "exec" => $this->isExecuting(),
        ]);
    }

    public function sent(SentModel $sentModel)
    {
        $lastSent = $sentModel->getLastSent(100);

        return view("sent", [
            "lastSent" => $lastSent,
            "exec" => $this->isExecuting(),
        ]);
    }

    public function logs(LogsModel $logsModel)
    {
        $dateStart = date("Y-m-d", strtotime("-1 day"));
        $dateEnd = date("Y-m-d", strtotime("+1 day"));

        $logs = $logsModel->getLogs($dateStart, $dateEnd);

        return view("logs", [
            "logs" => $logs,
            "exec" => $this->isExecuting(),
        ]);
    }

    public function queue(QueueModel $queueModel)
    {
        $dateStart = date("Y-m-d");

        $logs = $queueModel->getQueue($dateStart);

        return view("queue", [
            "queue" => $logs,
            "exec" => $this->isExecuting(),
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

    public function listInteractions(ResponseModel $responseModel, Request $request)
    {
        $phone = $request->input("phone");

        $messages = $responseModel->getPhoneMessages($phone);

        return view("interaction", [
            "messages" => $messages,
            "phone" => $phone,
            "exec" => $this->isExecuting(),
        ]);
    }

    private function isExecuting()
    {

        $isExecuting = false;
        $execution = $this->getExecution();

        if ($execution) {
            $datetimeLastExec = $execution->datetime;
            $timestampLastExecution = strtotime($datetimeLastExec);
            $timestampNow = strtotime("-1 minute", strtotime(date("Y-m-d H:i:s")));
            $timestampNow = strtotime("-2 hour", $timestampNow); // estou tendo q subtrair 2 hrs


            if ($timestampLastExecution > $timestampNow) {
                $isExecuting = true;
            }
        }
        return $isExecuting;
    }

    private function getExecution()
    {
        try {
            $f = json_decode(file_get_contents(storage_path("logs/execution.json")));
            return $f;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function exec()
    {
        exec('sudo node ../run-bot.js /dev/null 2>&1 &');
//        var_dump($out);

    }
}
