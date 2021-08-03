<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendEmailNew extends Mailable
{
    use Queueable, SerializesModels;
    
    public $measuresAlerts = array(array());
    public $subject = "Notificacion Umbral  ";
    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($measuresAlerts)
    {
        $this->measuresAlerts = $measuresAlerts;
        // travels array measuresAlerts for send subject date and hour of the insert db
        if (is_array($this->measuresAlerts)) {
            for ($row = 1; $row < count($this->measuresAlerts); $row = $row + 6) { 

                $this->subject = $this->subject . $this->measuresAlerts[$row][2] . " - ". $this->measuresAlerts[$row][3];
            
            }
        }

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        

        return $this->view('email.sendemail')
                    ->with($this->measuresAlerts);
    }
}
