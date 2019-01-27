<?php

namespace App\Http\Controllers;

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
        $quantitySentInterval = 24;

        $sent = $sentModel->getQuantitySent($quantitySentInterval);

        $lastResponses = $responseModel->getLastResponses();
        $lastSent = $sentModel->getLastSent();

        $projects = $projectModel->getProjects();

        return view("dashboard", [
            "numberInQueue" => $numberInQueue,
            "quantitySent" => $sent["quantity"],
            "amountProfit" => $sent["amount"],
            "quantitySentInterval" => $quantitySentInterval,
            "lastSent" => $lastSent,
            "projects" => $projects,
        ]);
    }
}
