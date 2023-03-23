<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\UploadFileSuccess;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Auth\Listeners\AssignAttachmentToTask;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Task;
use App\Models\Attachment;
use App\Models\Discussion;
use App\Observers\TaskObserver;
use App\Models\UserTask;
use App\Observers\AttachmentObserver;
use App\Observers\DiscussionObserver;
use App\Observers\UserTaskObserver;
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        Event::listen(
            UploadFileSuccess::class,
            [AssignAttachmentToTask::class, 'handle']
        );

        Task::observe(TaskObserver::class);
        Attachment::observe(AttachmentObserver::class);
        Discussion::observe(DiscussionObserver::class);
        UserTask::observe(UserTaskObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
