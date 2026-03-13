@include('common')

<body onload="startTime()">
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->

    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('header')
        <!-- Page Header Ends-->

        <div class="page-body-wrapper">
            <!-- Sidebar -->
            @include('sidebar')
            <!-- Sidebar End -->

            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h3>Treatment Lists</h3>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i
                                                data-feather="home"></i></a></li>
                                    <li class="breadcrumb-item">Treatment Lists</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div id="status_success"></div>

                                <div class="card-header text-end">
                                    <button class="btn btn-success" onclick="openAddModal()">Add Treatment</button>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive product-table">
                                        <table class="table table-bordered text-center" id="treatment_table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Category</th>
                                                    <th>Name</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($treatments as $treatment)
                                                <tr id="row_{{ $treatment->treatment_id }}">
                                                    <td>{{ $treatment->treatment_id }}</td>
                                                    <td>{{ $treatment->tc_name }}</td>
                                                    <td>{{ $treatment->treatment_name }}</td>
                                                    <td>{{ $treatment->amount }}</td>
                                                    <td class="switch-sm">
                                                        <label class="switch">
                                                            <input type="checkbox" class="status_toggle"
                                                                data-id="{{ $treatment->treatment_id }}"
                                                                {{ $treatment->status == 1 ? 'checked' : '' }}>
                                                            <span class="switch-state"></span>
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" class="text-primary"
                                                            onclick="openEditModal({{ $treatment->treatment_id }})">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <!-- <a href="javascript:void(0)"
                                                            class="delete_treatment text-danger ms-2"
                                                            data-id="{{ $treatment->treatment_id }}"><i
                                                                class="fa fa-trash"></i></a> -->
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

                <!-- Delete Modal -->
                <div class="modal fade" id="treatment_delete" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <h5>Delete?</h5>
                                <p>Are you sure you want to delete this Treatment?</p>
                            </div>
                            <div class="card-footer text-center mb-3">
                                <button class="btn btn-light" data-bs-dismiss="modal">No, Cancel</button>
                                <button class="btn btn-danger" id="deleteTreatmentConfirmBtn">Yes, Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                @include('footer')
            </div>
        </div>
    </div>
    <!-- Add/Edit Treatment Modal -->
    <div class="modal fade" id="treatmentModal" tabindex="-1" aria-labelledby="treatmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="treatmentModalLabel">Add Treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="status_success"></div>
                    <form id="treatment_form">
                        <input type="hidden" id="treatment_id" value="">
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label class="form-label">Treatment Category</label>
                                <select class="form-control" id="tc_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->tcategory_id }}">{{ $category->tc_name }}</option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id="error_tc_id"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Treatment Name</label>
                                <input class="form-control" type="text" id="treatment_name" placeholder="Treatment Name"
                                    required>
                                <div class="text-danger" id="error_treatment_name"></div>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Amount</label>
                                <input class="form-control" type="text" id="amount" placeholder="Amount" required>
                                <div class="text-danger" id="error_amount"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submit_treatment">
                        Submit
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                            style="display:none;"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('script')
    @include('session_timeout')

    <script>
    $(document).ready(function() {
        $('#treatment_table').DataTable({
            paging: true, // Enable pagination
            pageLength: 10, // Items per page
            lengthChange: true, // Allow changing items per page
            searching: true, // Enable search
            ordering: true, // Enable sorting
            info: true, // Show info text
            autoWidth: false,
            responsive: true
        });
    });

    function openAddModal() {
        $('#treatmentModalLabel').text('Add Treatment');
        $('#treatment_form')[0].reset();
        $('#treatment_id').val('');
        $('#status_success').html('');
        $('.text-danger').html('');
        $('#submit_treatment').attr('onclick', 'submitTreatment()');
        var modal = new bootstrap.Modal(document.getElementById('treatmentModal'));
        modal.show();
    }

    // Open modal for editing treatment
    function openEditModal(id) {
        $.ajax({
            url: `/edit_treatment/${id}`,
            type: 'GET',
            success: function(response) {
                if (response.status === 200) {
                    // Extract treatment and categories
                    let treatment = response.data.treatment; // should be a single object
                    let categories = response.data.categories; // array of categories

                    // Set modal title
                    $('#treatmentModalLabel').text('Edit Treatment');

                    // Fill form fields
                    $('#treatment_id').val(treatment.treatment_id);
                    $('#treatment_name').val(treatment.treatment_name);
                    $('#amount').val(treatment.amount);

                    // Populate category select
                    let tcSelect = $('#tc_id');
                    tcSelect.empty();
                    tcSelect.append('<option value="">Select Category</option>');
                    categories.forEach(function(cat) {
                        let selected = cat.tcategory_id == treatment.tc_id ? 'selected' : '';
                        tcSelect.append(
                            `<option value="${cat.tcategory_id}" ${selected}>${cat.tc_name}</option>`
                        );
                    });

                    // Clear previous error messages
                    $('.text-danger').html('');
                    $('#status_success').html('');

                    // Update submit button to call submitTreatment with id
                    $('#submit_treatment').attr('onclick', `submitTreatment(${treatment.treatment_id})`);

                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById('treatmentModal'));
                    modal.show();
                } else {
                    toastr.error('Failed to fetch treatment details.');
                }
            },
            error: function(err) {
                console.error(err);
                toastr.error('Error fetching treatment data.');
            }
        });
    }

    function submitTreatment(id = null) {
        let url = id ? `/update_treatment/${id}` : `/add_treatment`;
        let method = 'POST';

        let data = {
            _token: '{{ csrf_token() }}',
            tc_id: $('#tc_id').val(),
            treatment_name: $('#treatment_name').val(),
            amount: $('#amount').val()
        };

        // Show spinner
        $('.spinner-border').show();

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                // Hide spinner
                $('.spinner-border').hide();

                if (response.status === 200) {
                    toastr.success(response.message); // use "response", not "res"

                    // Close modal
                    var modalEl = document.getElementById('treatmentModal');
                    var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();

                    // Reset form
                    $('#treatment_form')[0].reset();
                    $('.text-danger').html('');
                    // Reload page or add new row (simpler)
                    window.location.reload(); // you can replace with dynamic row add if you prefe

                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                $('.spinner-border').hide();
                let errors = xhr.responseJSON.error_msg || {};
                $('#error_tc_id').text(errors.tc_id || '');
                $('#error_treatment_name').text(errors.treatment_name || '');
                $('#error_amount').text(errors.amount || '');
            }
        });
    }
    $(document).ready(function() {
        let deleteId = null;

        // Status Toggle
        $(document).on('change', '.status_toggle', function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '/treatment_status/' + id,
                type: 'PUT', // Use PUT for updating
                data: {
                    _token: '{{ csrf_token() }}', // CSRF token required for PUT
                    status: status
                },
                success: function(res) {
                    toastr.success(res.message);
                },
                error: function(err) {
                    toastr.error('Error updating status.');
                }
            });
        });

        // Open Delete Modal
        $(document).on('click', '.delete_treatment', function() {
            deleteId = $(this).data('id');
            $('#treatment_delete').modal('show');
        });

        // Confirm Delete
        $('#deleteTreatmentConfirmBtn').click(function() {
            if (deleteId) {
                let $btn = $(this);
                $btn.prop('disabled', true).text('Deleting...');
                $.ajax({
                    url: '/delete_treatment/' + deleteId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        toastr.success(res.message);
                        $('#row_' + deleteId).remove();
                        $('#treatment_delete').modal('hide');
                    },
                    complete: function() {
                        $btn.prop('disabled', false).text('Yes, Delete');
                    }
                });
            }
        });
    });
    </script>
</body>

</html>