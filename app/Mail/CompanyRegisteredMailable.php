<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyRegisteredMailable extends Mailable
{

    use SerializesModels;

    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($company)
    {
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
        {
            $recipientAddress = config('mail.recieve_to.address');
            $recipientName = config('mail.recieve_to.name');
        
            return $this->to($recipientAddress, $recipientName)
                ->subject('İşveren/Şirket "' . $this->company->name . '" "' . config('app.name') . '" sitesine kayıt oldu')
                ->view('emails.company_registered_message')
                ->with([
                    'name' => $this->company->name,
                    'email' => $this->company->email,
                    'link' => route('company.detail', $this->company->slug),
                    'link_admin' => route('edit.company', ['id' => $this->company->id])
                ]);
        }


}
