<?php

namespace App\Interfaces;

interface JobRepositoryInterface
{
    public function getAllJobs();
    public function createJob(array $newJob);
    public function updateJob($id, array $updateJob);
}
