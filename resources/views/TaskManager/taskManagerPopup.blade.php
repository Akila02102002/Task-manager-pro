<!-- Create Task Modal -->
<div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createTaskModalLabel">🆕 Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetForm()"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="createTaskForm" action="{{ url('task_manager/save') }}" accept-charset="UTF-8" style="display:inline">
                    {{ csrf_field() }}
                    <input type="hidden" id="task_id" name="id">
                    <div class="mb-3">
                        <label for="taskName" class="form-label">Task Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="task_name" name="task_name" placeholder="Enter task name">
                        <p id="task_name_err" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Task Description<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="task_description" name="task_description" rows="4" placeholder="Enter task description"></textarea>
                        <p id="task_description_err" style="color: red;"></p>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status<span class="text-danger">*</span></label>
                        <div id="status_wrapper">
                            <select class="form-select" id="status" name="status">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div id="status_view_wrapper" class="d-none">
                            <input type="text" class="form-control mt-2" id="status_view" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date">
                            <p id="start_date_err" style="color: red;"></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Due Date<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="due_date" name="due_date">
                            <p id="due_date_err" style="color: red;"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="submit_task_form" class="btn btn-primary buttonLogin">Done</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#submit_task_form').click(function () {
        var validate_man = 0;
        var valid_man = 0;

        valid_man = checkEmpty('task_name', 'task_name_err', '* Required');
        if (valid_man == 1) {
            validate_man += 1;
        }
        valid_man = checkEmpty('task_description', 'task_description_err', '* Required');
        if (valid_man == 1) {
            validate_man += 1;
        }
        valid_man = checkEmpty('start_date', 'start_date_err', '* Required');
        if (valid_man == 1) {
            validate_man += 1;
        }
        valid_man = checkEmpty('due_date', 'due_date_err', '* Required');
        if (valid_man == 1) {
            validate_man += 1;
        }

        const theButton = document.querySelector("#submit_task_form");

        if (validate_man == 0) {
            theButton.classList.add("button--loading");
            $('#submit_task_form').prop('disabled', true);
            $('#createTaskForm').submit();
        } else {
            theButton.classList.remove("button--loading");
            $('#submit_task_form').prop('disabled', false);
        }
    });

    function checkEmpty(id, err_id, msg) {
        var valid_man = 0;
        var id_val = $("#" + id).val();
        if (id_val == '') {
            valid_man = 1;
            $("#" + err_id).html(msg);
        } else {
            $("#" + err_id).html('');
        }
        return valid_man;
    }
</script>
<script>
function resetForm() {
    $('#createTaskForm')[0].reset();
    $('#task_id').val('');
    $('#status_wrapper').removeClass('d-none');
    $('#status_view_wrapper').addClass('d-none');
    $('#status_view').val('');
    $('p[id$="_err"]').html('');
}

function viewTask(id) {
    $.get(`{{ url('task_manager/view') }}/${id}`, function (data) {
        resetForm();
        $('#task_name').val(data.task_name).prop('readonly', true);
        $('#task_description').val(data.task_description).prop('readonly', true);
        $('#start_date').val(data.start_date).prop('readonly', true);
        $('#due_date').val(data.due_date).prop('readonly', true);
        $('#status_wrapper').addClass('d-none');
        $('#status_view').val(data.status);
        $('#status_view_wrapper').removeClass('d-none');
        $('#submit_task_form').hide();
        $('#createTaskModalLabel').text('View Task');
        $('#createTaskModal').modal('show');
    });
}
function editTask(id) {
    $.get(`{{ url('task_manager/view') }}/${id}`, function (data) {
        resetForm();
        $('#task_id').val(data.id);
        $('#task_name').val(data.task_name);
        $('#task_description').val(data.task_description);
        $('#start_date').val(data.start_date);
        $('#due_date').val(data.due_date);
        $('#status').val(data.status).prop('disabled', false);
        $('#submit_task_form').show();
        $('#createTaskModal').modal('show');
    });
}
function deleteTask(id) {
    if (confirm("Are you sure you want to delete this task?")) {
        $.ajax({
            url: "{{ url('task_manager/delete') }}/" + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                alert(res.message);
                search(1);
            }
        });
    }
}
</script>

