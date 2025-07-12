@if(empty($resVal['success']))
    <div class="text-center py-4">
        <p class="text-danger">{{ $resVal['message'] }}</p>
    </div>
@else
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">S.NO</th>
                <th style="width: 25%;">Task Name</th>
                <th style="width: 40%;">Task Description</th>
                <th style="width: 15%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $page = $resVal['page'];
                $limit = $resVal['limit'];
                $count = ($page - 1) > 0 ? (($page - 1) * $limit) + 1 : 1;
            @endphp
            @foreach ($resVal['list'] as $list)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $list->task_name }}</td>
                    <td>{{ $list->task_description }}</td>
                    <td>
                        <span class="badge bg-warning text-dark">{{ $list->status }}</span>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-info" onclick="viewTask({{ $list->id }})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary" onclick="editTask({{ $list->id }})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteTask({{ $list->id }})" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-end mt-3" id="pagination">
        {{ $resVal['list']->render() }}
    </div>
@endif
