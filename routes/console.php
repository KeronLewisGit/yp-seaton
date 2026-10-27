<?php

use Illuminate\Support\Facades\Schedule;

// Hostinger cron (hPanel → Advanced → Cron Jobs), once a minute or once a day:
//   php /home/USER/public_html/yps-app/artisan schedule:run
Schedule::command('app:remind-expiring')->dailyAt('07:00');
