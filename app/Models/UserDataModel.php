<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDataModel extends Model
{
    protected $table      = 'demo';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['name', 'address','material', 'quantity','detail', 'remark'];
}
