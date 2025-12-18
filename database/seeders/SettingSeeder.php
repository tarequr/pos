<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                'site_title'        => 'My Application',
                'site_description'  => 'Default site description',
                'site_phone'        => '+1234567890',
                'site_address'      => '123 Main St, City, Country',
                'site_logo'         => null,
                'site_favicon'      => null,
                'mail_mailer'       => 'smtp',
                'mail_host'         => 'smtp.example.com',
                'mail_port'         => '587',
                'mail_username'     => 'user@example.com',
                'mail_password'     => 'password',
                'mail_encryption'   => 'tls',
                'mail_from_address' => 'noreply@example.com',
                'mail_from_name'    => 'My Application',
            ]
        );
    }
}
