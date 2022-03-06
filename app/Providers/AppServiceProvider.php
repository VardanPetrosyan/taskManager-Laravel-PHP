<?php

    namespace App\Providers;

    use App\Models\Invoice\Grasexan;
    use App\Models\Invoice\GrasexanName;
    use App\Models\Invoice\Sidebar;
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Support\Facades\View;
    use Illuminate\Support\ServiceProvider;


    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot()
        {
            Schema::defaultStringLength(191); //Solved by increasing StringLength
            if (config('app.env') === 'production') {
                \URL::forceScheme('https');
            }
            $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local');

            View::composer('*', function ($view) {
                $sidebar = Sidebar::first();
                $fills = Grasexan::all();
                $descSidebarFill = array();
                foreach ($fills as $key => $fill) {
                    $descSidebarFill[$key]['field'] = GrasexanName::where('grasexan_id', $fill->id)->get();
                    $descSidebarFill[$key]['fill_name'] = $fill->name;
                    $descSidebarFill[$key]['slug'] = $fill->slug;
                    $descSidebarFill[$key]['fill_id'] = $fill->id;
                }

                $view->with('sidebar', $sidebar);
                $view->with('descSidebarFill', $descSidebarFill);
            });
        }


        /**
         * Register any application services.
         *
         * @return void
         */
        public function register()
        {
            //
        }
    }
