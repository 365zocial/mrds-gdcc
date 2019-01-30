<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactLoanSpecimen extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $condition;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $condition)
    {
        $this->data = $data;
        $this->condition = $condition;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $condition = $this->condition;

        if ( $condition == "admin" ) {
            $file_mail = "emails.loan_specimen_2019.contact_mail_admin";
        } elseif ( $condition == "th" ) {
            $file_mail = "emails.loan_specimen_2019.contact_mail_sender_th";
        } else {
            $file_mail = "emails.loan_specimen_2019.contact_mail_sender_en";
        }

        return $this->view( $file_mail )
            ->subject('[MRDS] Loan Specimen')
            ->from('rc_pmbc@yahoo.com')
            ->with([
                'from_email' => $this->data['from_email'],
                'name' => $this->data['name'],
                'info' => $this->data['info']
            ]);
    }

}
