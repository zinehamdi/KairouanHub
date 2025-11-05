<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class TestEmail extends Command
{
    protected $signature = 'email:test {email}';
    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle()
    {
        $toEmail = $this->argument('email');
        
        $this->info('Sending test email to: ' . $toEmail);
        
        try {
            Mail::raw('This is a test email from KairouanHub. If you receive this, your email configuration is working correctly!', function (Message $message) use ($toEmail) {
                $message->to($toEmail)
                    ->subject('KairouanHub - Test Email');
            });
            
            $this->info('✅ Test email sent successfully!');
            $this->info('Check your inbox at: ' . $toEmail);
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send email: ' . $e->getMessage());
            $this->error('');
            $this->error('Troubleshooting tips:');
            $this->error('1. Check MAIL_USERNAME and MAIL_PASSWORD in .env');
            $this->error('2. Verify MAIL_HOST is correct (smtp.hostinger.com)');
            $this->error('3. Ensure MAIL_PORT is 465 with SSL or 587 with TLS');
            $this->error('4. Check if your email password needs to be an "App Password"');
            
            return Command::FAILURE;
        }
    }
}
