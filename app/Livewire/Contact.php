<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;

class Contact extends Component
{
    public bool $showForm = false;

    public string $name;
    public string $email;
    public string $company;
    public string $phone;
    public string  $message;
    public string $email_received = '';

    public function submitForm()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if($validated){
            Inquiry::create($validated);
            Log::info('New inquiry created', $validated);
            $this->email_received = 'Thank you for your inquiry. We will get back to you soon.';
            $this->dispatch('close-contact-modal');

            $this->sendEmail($validated);
        }



    }

    protected function sendEmail(array $data)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST', 'smtp.gmail.com');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = env('MAIL_PORT', 587);

            //Recipients
            $mail->setFrom('mmaudace@gmail.com', 'Kigali Web Artisans');
            $mail->addAddress('lilianemuneza8@gmail.com', 'MUNEZERO Liliane');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Inquiry';
            $mail->Body    = 'You have received a new inquiry: ' . 
                '<br>Name: ' . $data['name'] .
                '<br>Email: ' . $data['email'] .
                '<br>Phone: ' . $data['phone'] .
                '<br>Company: ' . $data['company'] .
                '<br>Message: ' . nl2br($data['message']);

            $mail->send();
            Log::info('Email sent successfully');
        } catch (\Exception $e) {
            Log::error('Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function render()
    {
        return view('livewire.contact');
    }
}
