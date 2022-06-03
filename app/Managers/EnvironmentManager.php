<?php

namespace App\Managers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager extends \RachidLaasri\LaravelInstaller\Helpers\EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
            'APP_NAME=\''.$request->app_name."'\n".
            'APP_ENV='.$request->environment."\n".
            'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
            'APP_DEBUG='.$request->app_debug."\n".
            'APP_LOG_LEVEL='.$request->app_log_level."\n".
            'APP_URL='.$request->app_url."\n\n".
            'DB_CONNECTION='.$request->database_connection."\n".
            'DB_HOST='.$request->database_hostname."\n".
            'DB_PORT='.$request->database_port."\n".
            'DB_DATABASE='.$request->database_name."\n".
            'DB_USERNAME='.$request->database_username."\n".
            'DB_PASSWORD='.$request->database_password."\n\n".
            'BROADCAST_DRIVER=log'."\n".
            'CACHE_DRIVER=file'."\n".
            'QUEUE_CONNECTION=sync'."\n".
            'SESSION_DRIVER=file'."\n\n".
            'REDIS_HOST=127.0.0.1'."\n".
            'REDIS_PASSWORD=null'."\n".
            'REDIS_PORT=6379'."\n\n".
            'MAIL_DRIVER=smtp'."\n".
            'MAIL_HOST='."\n".
            'MAIL_PORT='."\n".
            'MAIL_USERNAME='."\n".
            'MAIL_PASSWORD='."\n".
            'MAIL_ENCRYPTION='."\n\n".
            'APP_TIMEZONE='.'GMT'."\n\n".
            'PUSHER_APP_ID='."\n".
            'PUSHER_APP_KEY='."\n".
            'PUSHER_APP_SECRET=';

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
