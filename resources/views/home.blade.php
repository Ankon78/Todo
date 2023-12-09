@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ isset($task) ? route('task.update', $task->id) : route('task.store') }}"
                              method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="task" class="form-label">Task</label>
                                <input type="text" class="form-control" id="task" name="task" required
                                       value="{{ isset($task) ? $task->task : '' }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        <div class="table-responsive mt-2">
                            <table class="table table-bordered">
                                <thead>
                                <th>SL.</th>
                                <th>Task</th>
                                <th>Status</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($task_list as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="task_name" style="text-decoration: {{ ($item->status == 1) ? 'line-through' : 'none' }}">{{ $item->task }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input data-id="{{ $item->id }}"
                                                       class="form-check-input flexSwitchCheckDefault" type="checkbox" {{ ($item->status == 1) ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('task.edit', $item->id) }}" class="btn btn-info">Edit</a>
                                            <a href="{{ route('task.destroy', $item->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="csrf" value="{{ csrf_token() }}">
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            $('.flexSwitchCheckDefault').change(function () {
                var status = '';
                if ($(this).is(":checked")) {
                    status = 1;
                    $(this).closest('tr').find('.task_name').css('text-decoration', 'line-through');
                } else {
                    status = 0;
                    $(this).closest('tr').find('.task_name').css('text-decoration', 'none');
                }
                var id = $(this).data('id');
                var csrf = $('#csrf').val();


                $.ajax({
                    url: "/task-update-status/" + id,
                    type: "post",
                    data: {
                        _token: csrf,
                        status: status
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });

        });
    </script>
@endsection
