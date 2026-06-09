<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactUsModel;
use App\Models\User;

class ContactUsSeeder extends Seeder
{
    public function run()
    {
        $admin = User::first();

        $contacts = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1-234-567-8900',
                'subject' => 'Question about Product Quality',
                'message' => 'Hi, I would like to know more about the quality standards of your products.',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@example.com',
                'phone' => '+1-987-654-3210',
                'subject' => 'Feedback on My Recent Purchase',
                'message' => 'I wanted to share my positive experience with your store. The product arrived quickly and is of excellent quality.',
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@example.com',
                'phone' => '+1-555-123-4567',
                'subject' => 'Shipping and Return Policy',
                'message' => 'Could you please clarify your shipping and return policy?',
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emily.brown@example.com',
                'phone' => '+1-666-789-0123',
                'subject' => 'Bulk Order Inquiry',
                'message' => 'I am interested in placing a bulk order for my business. Please let me know about wholesale pricing.',
            ],
            [
                'name' => 'David Lee',
                'email' => 'david.lee@example.com',
                'phone' => '+1-777-456-1234',
                'subject' => 'Technical Support',
                'message' => 'I am having trouble accessing my account. Can you help me reset my password?',
            ],
        ];

        foreach ($contacts as $contact) {
            ContactUsModel::firstOrCreate(
                ['email' => $contact['email'], 'subject' => $contact['subject']],
                [
                    'user_id' => $admin ? $admin->id : null,
                    'name' => $contact['name'],
                    'phone' => $contact['phone'],
                    'message' => $contact['message'],
                ]
            );
        }
    }
}
