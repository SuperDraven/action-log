<?php

namespace lld\ActionLog;

use Illuminate\Support\ServiceProvider;
use ActionLog;

class ActionLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish configuration files

        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations'),
        ], 'migrations');


        $this->publishes([
            __DIR__.'/config/actionlog.php' => config_path('actionlog.php'),
        ], 'config');

        $model = config("actionlog");
		if($model){
			foreach($model as $k => $v) {

//			$v::updated(function($data){
//
//					ActionLog::createActionLog('update',"更新的id:".$data->id);
//				});
			
			$v::saved(function($data){

                if(strtotime($data->updated_at)==strtotime($data->created_at)){
                    ActionLog::createActionLog('add',$data->id);
                }else{
                    ActionLog::createActionLog('update',$data->id);
                }

			});
			
			$v::deleted(function($data){
				ActionLog::createActionLog('delete',$data->id);

			});
			
			}
		}
        

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("ActionLog",function($app){
            return new \luoyangpeng\ActionLog\Repositories\ActionLogRepository();
        });
    }
}
