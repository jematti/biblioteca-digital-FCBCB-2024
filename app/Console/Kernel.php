<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function(){
            //programar tarea para eliminar ordenes pendientes de mas de 10 minutos de creacionsa
            $hora = now()->subMinute(10);


            $orders = Order::where('estado',1)->where('created_at','<=',$hora)->get();

            foreach ($orders as $order) {
                $items = json_decode($order->content);

                foreach ($items as $item) {
                    incrementa($item);
                }

                $order->estado = 5;
                $order->save();
            }
            return "se formateo correctamente";

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
