<?php

namespace App\Observers;

use App\Models\Job;
use App\Models\User;
use App\Notifications\NewJobNotification;
use Illuminate\Support\Facades\Notification;

class JobObserver
{
    /**
     * Handle the Job "created" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function created(Job $job)
    {
        $managers = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();
        Notification::send($managers, new NewJobNotification($job));
    }

    /**
     * Handle the Job "updated" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function updated(Job $job)
    {
        $managers = User::whereHas('roles', function ($query) {
            $query->where('id', 1);
        })->get();
        Notification::send($managers, new NewJobNotification($job));
    }

    /**
     * Handle the Job "deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function deleted(Job $job)
    {
        //
    }

    /**
     * Handle the Job "restored" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function restored(Job $job)
    {
        //
    }

    /**
     * Handle the Job "force deleted" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function forceDeleted(Job $job)
    {
        //
    }
}
