<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendWeeklyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;

    protected $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf,$name)
    {
        $this->pdf = $pdf;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Weekly Homeschool Minutes Report for '.$this->name;
        return $this->from(env('MAIL_FROM_ADDRESS'))
               ->subject($subject)
               ->view('mail.weekly-report')
               ->with(['name' => $this->name])
               ->attachData($this->pdf->output(), 'homeschool_weekly_report.pdf');
    }
}
