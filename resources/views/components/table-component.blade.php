<div>
    @include("layouts.tableHead")
    <div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupModalLabel">New message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- <form>
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                            <input type="text" class="form-control" id="recipient-name">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text"></textarea>
                        </div>
                    </form> -->
                    <livewire:form.form-wrapper
                        :fields="[
                                 ['name' => 'name', 'label' => 'Owner Name', 'type' => 'text', 'rules' => 'required', 'attributes' => ['placeholder' => 'Enter Owner Name']],
                                 ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'rules' => 'required|email', 'attributes' => ['placeholder' => 'Owner Email Address']],
                                 ['name' => 'contact', 'label' => 'Contact Number', 'type' => 'tel', 'rules' => 'required|regex:/^[0-9+\-\s]+$/', 'attributes' => ['placeholder' => 'Contact Number']],
                                ]"
                        :className="App\Models\User::class"
                        wire:key="{{ rand() }}"
                        id="edit-modal-1"
                        submitLabel="Update" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="table" data-filter-control-multiple-search="true"
            data-filter-control-multiple-search-delimiter="," data-virtual-scroll="true"
            data-filter-control="true" data-toggle="table" data-flat="true" data-pagination="true"
            data-show-toggle="true" data-show-export="true" data-show-columns="true" data-show-refresh="true"
            data-show-pagination-switch="true" data-show-columns-toggle-all="true" data-row-style="rowStyle"
            data-page-list="[10, 25, 50, 100]" data-url="{{route($requestUrl)}}">
            <thead>
                <tr>
                    <th data-filter-control="input" data-width="50" data-field="SNO" data-formatter="operateSerial">S.No.</th>
                    @foreach($columns as $key=>$column)
                    @if(isset($column['right']))
                    @can($column['right'])
                    @if(isset($column['searchable']) && $column['searchable'] === true)
                    <th data-filter-control="input" data-sortable="true" data-field="{{$column['name']}}"
                    data-formatter="{{$column['function']}}">{{$column['label']}}</th>
                    @else
                    <th data-field="{{$column['name']}}"
                    data-formatter="{{$column['function']}}">{{$column['label']}}</th>
                    @endif
                    @endcan
                    @else
                    @if(isset($column['searchable']) && $column['searchable'] === true)
                    <th data-filter-control="input" data-sortable="true" data-field="{{$column['name']}}"
                        data-formatter="{{$column['function']}}">{{$column['label']}}</th>
                    @else
                    <th data-field="{{$column['name']}}"
                        data-formatter="{{$column['function']}}">{{$column['label']}}</th>
                    @endif
                    @endif
                    @endforeach
                </tr>
            </thead>
        </table>
    </div>
    <div class="toast align-items-center text-white bg-primary border-0 position-fixed bottom-0 end-0 mb-4 mx-2" id="clipboard-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="clipboard-toast-body">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    @include("layouts.tableFoot")
    <script>
        function operateSerial(value, row, index) {
            return index + 1;
        }

        function operateText(value, row, index) {
            return value ? `<span style="text-transform:capitalize">${value.toString().replace(/[^\w ]/, " ")}</span>` : "N/A"
        }

        function operateEmail(value, row, index) {
            return value ? `<span">
                                    <a href="mailto:${value}">${value}</a>
                                    &nbsp;
                                    <i class="ti ti-copy" style="cursor: pointer; font-size:20px;" onclick="copyToClipboard('${value}')"></i>
                                    </span>` : "N/A";
        }

        function operateContact(value, row, index) {
            return value ? `<span">
                                    <a href="tel:${value}">${value}</a>
                                    &nbsp;
                                    <i class="ti ti-copy" style="cursor: pointer; font-size:20px;" onclick="copyToClipboard('${value}')"></i>
                                    </span>` : "N/A";
        }

        function operatePicture(value, row, index) {
            console.log(value)
            if (value != null) {
                return value ? `<img  onerror="this.style.display='none'" style="object-fit: cover;" width="100" height="120" src="${value}" />` : ['<div class="left">', 'Not Available', '</div>'].join('');
            }
        }

        function operateQuickEdit(value, row, index) {
            if (value) {
                return [
                    '<div class="left">',
                    '<a class="btn btn-success" style="font-size:24px;" data-bs-toggle="modal" data-bs-target="#popupModal" data-bs-whatever="' + value + '">',
                    '<i class="ti ti-user-edit"></i>',
                    '</a>',
                    '</div>'
                ].join('')
            }
        }


        function operateEdit(value, row, index) {
            let route = '{{route($editRoute, ":id")}}'.replace(':id', value);
            if (value) {
                return [
                    '<div class="left">',
                    '<a class="btn btn-success" style="font-size:24px;" target="_blank" href="' + route + '">',
                    '<i class="ti ti-edit"></i>',
                    '</a>',
                    '</div>'
                ].join('')
            }
        }

        function operateArray(value, row, index) {
            let subColumns = @json($subColumns);
            if (value) {
                return value.map((val, i) => '<span style="text-transform:capitalize">' + subColumns.map(subValue => val[subValue]) + '</span><br/>').join('')
            } else {
                return [
                    'N/A',
                ].join('')
            }
        }

        var popupModal = document.getElementById('popupModal')
        popupModal.addEventListener('show.bs.modal', function(event) {
            Livewire.dispatch('edit-modal-1', {
                updateUuid: event.relatedTarget.getAttribute('data-bs-whatever')
            });
            // // Button that triggered the modal
            // var button = event.relatedTarget
            // // Extract info from data-bs-* attributes
            // var recipient = button.getAttribute('data-bs-whatever')
            // // If necessary, you could initiate an AJAX request here
            // // and then do the updating in a callback.
            // //
            // // Update the modal's content.
            // var modalTitle = popupModal.querySelector('.modal-title')
            // var modalBodyInput = popupModal.querySelector('.modal-body input')

            // modalTitle.textContent = 'New message to ' + recipient
            // modalBodyInput.value = recipient
        })

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                        // Show Bootstrap toast
                        const toastElement = document.getElementById('clipboard-toast');
                        const toastBody = document.getElementById('clipboard-toast-body');
                        toastBody.innerText = `Copied: ${text}`;

                        const toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    }

                )
                .catch(err => console.error('Clipboard error:', err));
        }


        ['#table'].map((val => {
            // var $table = $(val)

            $(val).bootstrapTable({
                exportOptions: {
                    fileName: 'List Of All Hr Groups'
                }
            });
        }))
    </script>
</div>