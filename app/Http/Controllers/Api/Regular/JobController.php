<?php

namespace App\Http\Controllers\Api\Regular;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Regular\JobRequest;
use App\Repositories\JobRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    private JobRepository $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function create(JobRequest $newJob): \Illuminate\Http\JsonResponse
    {
        $job = $newJob->all();
        $job["user_id"] = Auth::id();
        return response()->json(
            [
                'data' => $this->jobRepository->createJob($job)
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    public function update(Request $request, JobRequest $updateJob): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $this->jobRepository->updateJob((int) $request->id, $updateJob->all())
        ], JsonResponse::HTTP_ACCEPTED);
    }
}
