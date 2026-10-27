<?php

use Illuminate\Support\Facades\Schedule;

// Hostinger cron (hPanel → Advanced → Cron Jobs), every minute (INSTALL-HOSTINGER.md, "Cron"):
//   /usr/bin/php /home/USER/domains/ypseaton.com/public_html/yps-app/artisan schedule:run
// Times are America/Jamaica (APP_TIMEZONE).
Schedule::command('app:remind-expiring')->dailyAt('07:00')->withoutOverlapping();
Schedule::command('app:prune-held-uploads')->hourly();
