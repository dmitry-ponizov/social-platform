<?php

namespace App\Notifications;

use App\Components\Main\Models\Statement;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class StatementCreate extends Notification
{
    use Queueable;
    use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;

    public $statement;

    /**
     * Create a new notification instance.
     *
     * @param Statement $statement
     */
    public function __construct(Statement $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'title' => $this->statement->title,
            'description' => $this->statement->description,
            'id' => $this->statement->id,
            'uuid' => $this->statement->uuid,
            'created_at' =>  Carbon::parse($this->statement->created_at)->format('Y.m.d h:i:s'),
            'user' => $notifiable
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->statement->title,
            'description' => $this->statement->description,
            'created_at' =>  Carbon::parse($this->statement->created_at)->format('Y.m.d h:i:s'),
            'statement_id' => $this->statement->id,
            'uuid' => $this->statement->uuid,
            'user' => $notifiable
        ]);
    }
}
