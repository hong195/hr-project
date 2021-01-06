<?php

namespace App\Notifications;

use App\Models\Rating;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RatingCreated extends Notification
{
    use Queueable;

    /**
     * @var string
     */
    private $url;

    /**
     * @var Rating
     */
    private $rating;

    /**
     * @var string
     */
    private $fromMailAddress;

    /**
     * @var string
     */
    private $senderName;

    public function __construct(Rating $rating)
    {
        $this->rating = $rating;
        $this->senderName = config('mail.from.name');
        $this->fromMailAddress = config('mail.from.address');
        $this->url = config('app.url') . "#/ratings-staff?rating_id={$this->rating->id}";
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getMailSubject())
            ->from($this->fromMailAddress, $this->senderName)
            ->line("Вы набрали {$this->rating->scored} из {$this->rating->out_of} баллов")
            ->line("Ознакомиться с рейтингом вы можете, кликнув по ссылке ниже.")
            ->action("Ознакомиться с рейтингом", $this->url)
            ->markdown('mail.rating-created', [
                'title' => $this->getMailSubject()
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }

    private function getRatingCreationDate(): string
    {
        $creationDate = Carbon::parse($this->rating->created_at);
        $creationYear = $creationDate->year;
        $creationMonth = ucfirst($creationDate->translatedFormat('F'));

        return "$creationMonth $creationYear";
    }

    private function getMailSubject() : string
    {
        return "Ваш рейтинг за {$this->getRatingCreationDate()}.";
    }
}
