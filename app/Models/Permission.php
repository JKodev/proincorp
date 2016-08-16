<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
	protected $dateFormat = 'd/m/Y H:i:s.u';
}
