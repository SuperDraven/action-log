<?php
namespace luoyangpeng\ActionLog\Repositories;

use Illuminate\Http\Request;
use luoyangpeng\ActionLog\Services\clientService;
use illuminate\support\facades\route;
class ActionLogRepository {


    /**
     * 记录用户操作日志
     * @param $type
     * @param $content
     * @param ActionLog $actionLog
     * @return bool
     */
    public function createActionLog($type,$content)
    {
        $admin = request()->get('admin');
    	$actionLog = new \luoyangpeng\ActionLog\Models\ActionLog();

    		$actionLog->admin_id=$admin->id;
    		$actionLog->admin_name = $admin->name;

       	$actionLog->browser = clientService::getBrowser($_SERVER['HTTP_USER_AGENT'],true);
       	$actionLog->system = clientService::getPlatForm($_SERVER['HTTP_USER_AGENT'],true);
       	$actionLog->url = request()->getRequestUri();
        $actionLog->ip = request()->getClientIp();
        $actionLog->type = $type;
        $actionLog->content = $content;
        $actionLog->url_name = Route::currentRouteName();
        $res = $actionLog->save();

        return $res;
    }
}