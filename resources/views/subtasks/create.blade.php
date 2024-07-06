<!-- Modal para crear subtareas -->
<div class="modal fade" id="createSubtaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="createSubtaskModalLabel-{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSubtaskModalLabel-{{ $task->id }}">Crear Subtarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('subtasks.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Crear Subtarea</button>
                </div>
            </form>
        </div>
    </div>
</div>

