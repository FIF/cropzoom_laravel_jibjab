<?php

namespace LaravelPrototype\Events;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class EventsServiceProvider extends ServiceProvider {

    public function register() {

        //Log DB Queries
        if (Config::get('database.log'))
        {
            Event::listen('illuminate.query', function($query, $bindings, $time, $name)
            {
                $data = compact('bindings', 'time', 'name');

                // Format binding data for sql insertion
                foreach ($bindings as $i => $binding)
                {
                    if ($binding instanceof \DateTime)
                    {
                        $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    }
                    else if (is_string($binding))
                    {
                        $bindings[$i] = "'$binding'";
                    }
                }

                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
                $query = vsprintf($query, $bindings);

                Log::info($query, $data);
            });
        }

        // TODO: Implement register() method.


    }
}