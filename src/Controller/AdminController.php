<?php

namespace App\Controller;


use App\Entity\Admin;
use App\Entity\Report;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController

{
    /**
     * @var ObjectManager
     */
    private $em;


    public function __construct(ObjectManager $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("/api/admin/create", name="admin.create", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return JsonResponse
     */

    public function addAdmin(Request $request): JsonResponse
    {

        $datas = json_decode($request->getContent(), true);
        $admin = new Admin();
        $admin
            ->setLogin($datas[0]['login'])
            ->setPassword(password_hash($datas[0]['password'], PASSWORD_BCRYPT))
            ->setRole($datas[0]['role'])
            ->setToken($datas[0]['token']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($admin);
        $em->flush();
        return new JsonResponse(['status' => 'Administrator created.'], Response::HTTP_CREATED);
    }



    /**
     * @Route("/api/admin/all", name="admin.all", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function allAdmin()
    {

        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAllAdmin();
        if (empty($admin)) {
            return new Response('No element was found.');
        } else {
            $response = new Response(json_encode($admin));
            $response->headers->set('Content-type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin','*');
            return $response;
        }

    }

    /**
     * @Route("/api/admin/getone/{id}", name="admin.one", methods={"GET"})
     * @param $id
     * @return Response
     */

    public function oneAdmin($id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAdmin($id);

        if (empty($admin)) {
            return new Response('No element containing this ID was found.');
        } else {
            $res = new Response(json_encode($admin));
            $res->headers->set('Content-type', 'application/json');
            $res->headers->set('Access-Control-Allow-Origin','*');
            return $res;
        }

    }

    /**
     * @Route("/api/admin/remove-admin/{id}", name="admin.remove.admin", methods={"DELETE"})
     * @param $id
     * @return Response
     * @throws DBALException
     */
    public function removeAdmin($id)
    {
        $admin = $this->getDoctrine()
            ->getRepository(Admin::class)
            ->findAdmin($id);

        if (!$admin) {
            return new Response("Processing cannot be performed because no element has been found.");
        } else {
            $this->getDoctrine()->getRepository(Admin::class)->removeAdmin($id);
            return new Response("Administrator successfully deleted.");
        }


    }

    /**
     * @Route("/api/admin/remove-report/{id}", name="admin.remove.report", methods={"DELETE"})
     * @param $id
     * @return Response
     */

    public function moveReport($id)
    {
        $report = $this->getDoctrine()
            ->getRepository(Report::class)
            ->findReport($id);

        if (!$report) {
            return new Response("Processing cannot be performed because no element has been found.");

        } else {
            $this->getDoctrine()->getRepository(Report::class)->removeReport($id);
            return new Response("Report successfully deleted");
        }

    }

    /**
     * @Route("/api/admin/update/{id}", name="admin.update", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */

    public function updateAdmin($id, Request $request): JsonResponse
    {
        $admin = $this->getDoctrine()->getRepository(Admin::class)->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        /*
         * Personal content of admin.
         */

        empty($data['example']) ? true :
            $admin->setExample($data['example']);

        $updateAdmin = $this->getDoctrine()->getRepository(Admin::class)->updateAdmin($id);

        return new JsonResponse($updateAdmin->toArray(), Response::HTTP_OK);
    }

}