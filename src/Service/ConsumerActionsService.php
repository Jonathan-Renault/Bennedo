<?php


namespace App\Service;

use App\Entity\ConsumerHasBin;


class ConsumerActionsService
{
    public function createConsumerAction($id_report, $id_bin, $id_consumer, $action, $entityManager)
    {
        $consumerAction = new ConsumerHasBin();
        $consumerAction->setIdBin($id_bin)
            ->setIdConsumer($id_consumer)
            ->setIdReport($id_report)
            ->setAction($action);

        $entityManager->persist($consumerAction);
        $entityManager->flush();
    }

    public function verifyReportIsResolved($id_report, $repository): bool {
        $reports = $repository->findSomeConsumerActions($id_report);
        $reports = json_encode($reports);
        $reports = json_decode($reports, true);
        $validateProblemCount = 0;
        $refuteProblemCount = 0;

        foreach ($reports as $report) {
            if ($report['action'] == 'validate')
                $validateProblemCount++;
        }

        if($validateProblemCount == 7)
            return true;
        else
            return false;
    }

    public function resolveReport($id_report, $repository) {

    }
}