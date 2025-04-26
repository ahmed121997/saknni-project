<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="typePropertyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Type Property Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border:#ccc">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="adminForm">
                    @csrf
                    <input type="hidden" name="property_type_id" id="property_type_id" value="">
                    <div class="row">
                        <x-language-input label="Property Type Name" name="name" id="propertyTypeName" />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" id="btnSave" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>



