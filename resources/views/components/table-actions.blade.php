<a href="javascript:void(0)"
   data-toggle="tooltip"
   data-id="{{ $id }}"
   data-original-title="Edit"
   class="edit text-primary mx-2 {{ $editClass ?? 'editItem' }}">
    <i class="fas fa-edit text-primary"></i>
</a>

<a href="javascript:void(0)"
   data-toggle="tooltip"
   data-id="{{ $id }}"
   data-original-title="Delete"
   class="delete text-danger {{ $deleteClass ?? 'deleteItem' }}">
   <i class="far fa-trash-alt text-danger"></i>
</a>
