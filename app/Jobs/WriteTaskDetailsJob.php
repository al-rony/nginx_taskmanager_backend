<?php

namespace App\Jobs;

use App\Events\TaskCreatedEvent;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WriteTaskDetailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TaskCreatedEvent $event): void
    {
        sleep(5);

        $task=$event->task;

        $createdAt = Carbon::parse($task->created_at)->format('Y-m-d h:i:s A');
        $fileName = $this->getFileName($task->title);
        $fileContent = "Title: $task->title\nDescription: $task->description\nCreated At: $createdAt";

        Storage::disk('public')->put($fileName, $fileContent);
    }

    private function getFileName($title)
    {
        $slug = Str::slug($title);
        $timestamp = Carbon::now()->format('YmdHis');

        return "{$slug}_{$timestamp}.txt";
    }
}
