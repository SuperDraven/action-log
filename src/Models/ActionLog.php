<?php
namespace lld\ActionLog\Models;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model {

    protected $table = "action_log";
    protected $dateFormat = 'U';
    protected $fillable = ['uid','username','type','ip','content','url_name'];
}