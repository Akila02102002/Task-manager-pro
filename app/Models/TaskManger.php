<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TaskManger extends Model {

    protected $table = 'tbl_task_manager';
    protected $primaryKey = 'id';
    protected $fillable = ['task_name','task_description','is_active','status','start_date','due_date'];

    protected $dates = ['created_at', 'updated_at'];


}
