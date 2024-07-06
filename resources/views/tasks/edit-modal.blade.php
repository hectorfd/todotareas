<div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel-{{ $task->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel-{{ $task->id }}">Editar Tarea</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $task->titulo }}">
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion">{{ $task->descripcion }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="datetime-local" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ $task->fecha_vencimiento }}">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>
