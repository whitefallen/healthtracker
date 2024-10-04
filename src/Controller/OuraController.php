<?php

namespace App\Controller;


use App\ApiClient\Api\Oura\OuraClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class OuraController extends AbstractController
{
    private OuraClient $ouraClient;

    public function __construct(OuraClient $ouraClient)
    {
        $this->ouraClient = $ouraClient;
    }

    #[Route('/oura/userinfo', name: 'oura_user_info')]
    public function getUserInfo(): JsonResponse
    {
        try {
            $userInfo = $this->ouraClient->getUserInfo();
            return $this->json($userInfo);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/oura/sleep', name: 'oura_sleep_data')]
    public function getSleepData(): JsonResponse
    {
        try {
            $sleepData = $this->ouraClient->getSleepData('2023-01-01', '2023-01-31');
            return $this->json($sleepData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/oura/activity', name: 'oura_activity_data')]
    public function getActivityData(): JsonResponse
    {
        try {
            $activityData = $this->ouraClient->getActivityData('2023-01-01', '2023-01-31');
            return $this->json($activityData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }

    #[Route('/oura/readiness', name: 'oura_readiness_data')]
    public function getReadinessData(): JsonResponse
    {
        try {
            $readinessData = $this->ouraClient->getReadinessData('2023-01-01', '2023-01-31');
            return $this->json($readinessData);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 500);
        }
    }
}
