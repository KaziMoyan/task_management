<div class="modal-body p-4">
    <h4 class="mb-3 text-success"><strong><i class="fas fa-tasks"></i> {{ $task->name }}</strong></h4>

    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Description:</strong> {{ $task->short_description }}</li>
        <li class="list-group-item"><strong>Estimated Minutes:</strong> {{ $task->minutes }} mins</li>
        <li class="list-group-item"><strong>Date:</strong> {{ $task->date }}</li>
        <li class="list-group-item"><strong>Start Time:</strong> {{ $task->time_start }}</li>
        <li class="list-group-item"><strong>End Time:</strong> {{ $task->time_end }}</li>
        <!-- Add Total Time Here -->
        <li class="list-group-item"><strong>Total Time:</strong> {{ $totalTime }}</li>
        <li class="list-group-item"><strong>Status:</strong>
            @switch($task->status)
                @case('pending')
                    <span class="badge bg-warning text-black">Pending</span>
                    @break
                @case('in_progress')
                    <span class="badge bg-info text-black">In Progress</span>
                    @break
                @case('completed')
                    <span class="badge bg-success text-black">Completed</span>
                    @break
                @default
                    <span class="badge bg-secondary text-black">Unknown</span>
            @endswitch
        </li>
    </ul>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-success" id="saveTaskButton">Save</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>



<script>
    $(document).ready(function () {
        // Event handler for the "Save" button click
        $('#saveTaskButton').on('click', function () {
            // Close the modal when the "Save" button is clicked
            $('#taskModal').modal('hide');
        });

        // Event handler for the view-task button click (to load content via AJAX)
        $('.view-task').on('click', function () {
            var taskId = $(this).data('task-id');
            var taskDetailsDiv = $('#taskDetails');

            // If task details are already loaded, show the modal without reloading
            if (taskDetailsDiv.is(':empty')) {
                // Show loading spinner
                taskDetailsDiv.html('<div class="text-center p-4">Loading...</div>');
                $('#taskModal').modal('show'); // Open modal

                // Load content via AJAX from the full blade view
                $.ajax({
                    url: '/tasks/' + taskId,
                    type: 'GET',
                    success: function (response) {
                        taskDetailsDiv.html(response); // Fill the modal with content
                    },
                    error: function () {
                        taskDetailsDiv.html('<div class="alert alert-danger">Failed to load task details.</div>');
                    }
                });
            } else {
                // If the content is already loaded, just show the modal
                $('#taskModal').modal('show');
            }
        });
    });
</script>
