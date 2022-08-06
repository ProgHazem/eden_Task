<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\JobRTO;
use App\Repositories\JobRepository;

class JobController extends Controller
{
    private JobRepository $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json(["data" => JobRTO::collection($this->jobRepository->getAllJobs())], 200);
    }
}
