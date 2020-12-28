<?php

namespace App\Observers;

use App\Models\¤ModelP¤;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ¤ModelP¤Observer
{
    /**
     * Handle the ¤ModelP¤ "created" event.
     *
     * @param  \App\Models\¤ModelP¤  $¤ModelP¤
     * @return void
     */
    public function created(¤ModelP¤ $¤modelC¤)
    {
        Log::channel('app_events')->info('¤ModelP¤ created: ' . $¤modelC¤->log_data, ['id' => Auth::id()]);
    }

    /**
     * Handle the ¤ModelP¤ "updated" event.
     *
     * @param  \App\Models\¤ModelP¤  $¤ModelP¤
     * @return void
     */
    public function updated(¤ModelP¤ $¤modelC¤)
    {
        Log::channel('app_events')->info('¤ModelP¤ updated: ' . $¤modelC¤->log_data, ['id' => Auth::id()]);
    }

    /**
     * Handle the ¤ModelP¤ "deleted" event.
     *
     * @param  \App\Models\¤ModelP¤  $¤ModelP¤
     * @return void
     */
    public function deleted(¤ModelP¤ $¤modelC¤)
    {
        Log::channel('app_events')->info('¤ModelP¤ deleted: ' . $¤modelC¤->log_data, ['id' => Auth::id()]);
    }

    /**
     * Handle the ¤ModelP¤ "restored" event.
     *
     * @param  \App\Models\¤ModelP¤  $¤ModelP¤
     * @return void
     */
    public function restored(¤ModelP¤ $¤modelC¤)
    {
        Log::channel('app_events')->info('¤ModelP¤ restored: ' . $¤modelC¤->log_data, ['id' => Auth::id()]);
    }

    /**
     * Handle the ¤ModelP¤ "force deleted" event.
     *
     * @param  \App\Models\¤ModelP¤  $¤ModelP¤
     * @return void
     */
    public function forceDeleted(¤ModelP¤ $¤modelC¤)
    {
        Log::channel('app_events')->info('¤ModelP¤ forceDeleted: ' . $¤modelC¤->log_data, ['id' => Auth::id()]);
    }
}
