<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskManger;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class TaskManagerController extends Controller
{
    public function list(Request $request) {
        $page_title = 'Task Manager';
        $page_description = 'Description';
        $resVal = $this->getList($request);
        return view('TaskManager.list', compact('page_title', 'page_description','resVal'));
    }
    public function getList(Request $request)
    {
        $resVal=Array();

        $search = $request->input('search','');
        $status = $request->input('status','');
        $limit = $request->input('limit',50);

        $query = DB::table('tbl_task_manager')
                  ->select('*')
                  ->where('is_active',1);

        $need_page = $request->input('need_page',0);

        if (!empty($search)) {
            $query->where('task_name', 'like', '%' . $search . '%');
        }
         if (!empty($status)) {
            $query->where('status', 'like', '%' . $status . '%');
        }

        $query->orderBy('id', 'desc');

        $resVal['total'] = $query->count();
        $resVal['limit'] = $limit;
        $resVal['list'] = $query->paginate($limit);
        $resVal['page'] =$request->input('page',1);

        if ($resVal['total'] > 0) {
            $resVal['success'] = TRUE;

        } else {
            $resVal['success'] = FALSE;
            $resVal['message'] = 'No Data Found';
        }
       if(isset($need_page)&& $need_page==1)
            return view('TaskManager/pagination_data', [
                         'resVal' => $resVal
                     ]);
       else
           return $resVal;

    }
    public function save(Request $request) {
        $id = $request->input('id');
        $taskManager = $id ? TaskManger::find($id) : new TaskManger();

        if (!$taskManager) {
            return redirect()->back()->with('error', 'Task not found');
        }

        $taskManager->fill($request->all());
        $taskManager->is_active = 1;
        $taskManager->save();

        $msg = $id ? "Task Updated Successfully" : "Task Added Successfully";
        return redirect('task_manager/list')->with('success', $msg);
    }

    public function view($id) {
        $taskManager = TaskManger::where('id', $id)->first();
        return response()->json($taskManager);
    }

    public function delete($id) {
        $taskManager = TaskManger::find($id);
        if ($taskManager) {
            $taskManager->is_active = 0;
            $taskManager->save();
            return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Task not found.']);
    }
}
