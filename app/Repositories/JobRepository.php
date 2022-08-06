<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface
{
    public function getAllJobs(): \Illuminate\Database\Eloquent\Collection
    {
        return Job::all();
    }

    public function createJob(array $newJob)
    {
        return Job::create($newJob);
    }

    public function updateJob($id, array $updateJob)
    {
        return Job::whereId($id)->update($updateJob);
    }

}
