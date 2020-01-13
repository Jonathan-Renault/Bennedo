<?php


namespace App\Service;

use App\Entity\AdminHasReport;
use App\Entity\ConsumerHasBin;


class ActionsService
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

    public function createAdminAction($id_report, $id_admin, $entityManager) {
        $adminAction = new AdminHasReport();
        $adminAction->setIdReport($id_report)
            ->setIdAdmin($id_admin);

        $entityManager->persist($adminAction);
        $entityManager->flush();
    }

    public function verifyReportIsResolved($id_report, $repository): bool {
        $reports = $repository->findSomeConsumerActions($id_report);
        $reports = json_encode($reports);
        $reports = json_decode($reports, true);
        $refuteProblemCount = 0;

        foreach ($reports as $report) {
            if ($report['action'] == 'refute')
                $refuteProblemCount++;
        }

        if($refuteProblemCount == 7)
            return true;
        else
            return false;
    }
}