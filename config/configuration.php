<?php 

return [
     'super_admin_credentials' => [
          'name' => 'admin',
          'email' => 'admin@admin.com',
          'password' => '568842',
     ],
     'super_admin_roles' =>[
          'role_id' => 1,
          'name' => 'Super Admin',
     ],
     'software_exception_code' => [
          'emergency' => 404,
          'alert' => 420,
          'critical' => 500,
          'error' => 406,
          'warning' => 405,
          'notice' => 402,
          'info' => 100,
          'debug' => 200,
          'success' => 100,
          'fail' => 420,
          'server_error' => 500,
     ],
     'server_exception_code' => [
          'validation_fail' => 422,
     ],
     'admin_login_redirect_url' => 'dashboard',
     'titel_bar_text' => env('APP_NAME', 'MyDailyExpence'),
     'app_version' => env('APP_VERSION', 'Version 2.0'),
     'app_developer' => env('APP_DEVELOPER', 'Ataul Galib'),
     'system_sencetive_request_parameter' => [
          '_token',
          'password',
          'password_confirmation',
          'current_password',
          'new_password',
          'new_password_confirmation',
          'old_password',
     ],
     'application_defult_password' => 'Nop@ssword',
     'APP_ADMIN_URL_PREFIX' => env('APP_ADMIN_URL_PREFIX', 'admin'),
     'APP_CORE_URL_PREFIX' => env('APP_CORE_URL_PREFIX', 'core'),
     'image_mime_types' => [
          'image/jpeg', 
          'image/gif', 
          'image/png', 
          'image/bmp', 
          'image/svg+xml',
          'image/x-icon',
          'image/jpg',
     ],
     'encryption_method' => env('ENCRYPTION_METHOD','AES-256-CBC'),
     'encryption_secret_key' => env('ENCRYPTION_SECRET_KEY', 'QFYrb(Zjx7&Lw'), 
     'encryption_secret_iv' => env('ENCRYPTION_SECRET_IV', 'HkT*y8_PSAR%,p[}'), // must be 16 characters
     'encryption_fixed_salt' => env('ENCRYPTION_FIXED_SALT', 'eh[='), // must be 4 characters
];