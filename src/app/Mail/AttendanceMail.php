<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AttendanceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    protected $student;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $student)
    {
        $this->data = $data;
        $this->student = $student;
    }

    public function build()
    {
        return $this->view('mail.attendance')->with(['student' => $this->student, 'data' => $this->data])->subject(
            'Thông báo điểm danh của bé'
        );
    }
}
