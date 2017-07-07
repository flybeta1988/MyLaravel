<?php
/**
 * 缓存操作类型
 */
namespace App\Library\Cache;

use Illuminate\Support\Facades\Cache;

class CacheMaintainType
{

    const ADD = 'add';

    const REMOVE = 'remove';

    const REPLACE = 'replace';

    const FORWARD = 'forward';

    const DELETE = 'delete';

}
