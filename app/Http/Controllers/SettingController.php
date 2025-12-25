<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.pages.setting.index', compact('setting'));
    }

    /**
     * Update the settings.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        try {
        $setting = Setting::first();
        if (! $setting) {
            $setting = new Setting();
        }

        $data = $request->only([
            'site_title', 'site_description', 'site_phone', 'site_address',
            'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_address', 'mail_from_name',
        ]);

        // Handle site_logo upload
        if ($request->hasFile('site_logo')) {
            $logoPath          = $request->file('site_logo')->store('logos', 'public');
            $data['site_logo'] = $logoPath;
        }

        // Handle site_favicon upload
        if ($request->hasFile('site_favicon')) {
            $faviconPath          = $request->file('site_favicon')->store('favicons', 'public');
            $data['site_favicon'] = $faviconPath;
        }

        $setting->fill($data);
        $setting->save();

        $envUpdates = [
            'APP_NAME'          => $request->get('site_title'),
            'MAIL_MAILER'       => $request->get('mail_mailer'),
            'MAIL_HOST'         => $request->get('mail_host'),
            'MAIL_PORT'         => $request->get('mail_port'),
            'MAIL_USERNAME'     => $request->get('mail_username'),
            'MAIL_PASSWORD'     => $request->get('mail_password'),
            'MAIL_ENCRYPTION'   => $request->get('mail_encryption'),
            'MAIL_FROM_ADDRESS' => $request->get('mail_from_address'),
            'MAIL_FROM_NAME'    => $request->get('mail_from_name'),
        ];
        $this->updateEnv($envUpdates);
        // Reload config
        // Artisan::call('config:cache');

        notify()->success('Settings updated successfully and .env updated.', 'Success');
        return redirect()->route('setting');

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            notify()->error('Settings Update Failed', 'Error');
            return back();
        }
    }

    /**
     * Update .env file with given key-value pairs.
     */
    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        if (! file_exists($envPath)) {
            return;
        }

        $env = file_get_contents($envPath);
        foreach ($data as $key => $value) {
            if ($value === null) {
                continue;
            }

            $pattern = "/^{$key}=.*$/m";
            $line    = $key . '=' . $this->escapeEnvValue($value);
            if (preg_match($pattern, $env)) {
                $env = preg_replace($pattern, $line, $env);
            } else {
                $env .= "\n" . $line;
            }
        }
        file_put_contents($envPath, $env);
    }

    protected function escapeEnvValue($value)
    {
        if (strpos($value, ' ') !== false) {
            return '"' . addslashes($value) . '"';
        }
        return $value;
    }
}
