<?php

use Illuminate\Support\Facades\Route;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;

Route::get('/test-email', function () {
    try {
        Mail::to('test@example.com')->send(new TestMail([
            'title' => 'Test Email from Ecommerce App',
            'body' => 'This is a test email sent to Mailtrap. If you received this, your Mailtrap configuration is working correctly!'
        ]));
        return '✅ Email sent successfully to Mailtrap! Check your Mailtrap inbox.';
    } catch (\Exception $e) {
        return '❌ Error sending email: ' . $e->getMessage();
    }
});
