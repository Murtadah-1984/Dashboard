<!-- Main Footer -->
<footer class="main-footer fixed-bottom">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{ config('dashboard.company_sologon')}}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ now()->format('Y') }} <a href="{{ config('dashboard.company_url')}}">{{ config('dashboard.company_name')}}</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- Datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.5.2/js/dataTables.autoFill.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.5.2/js/autoFill.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.6.1/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.3.0/js/dataTables.dateTime.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.2.1/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.3.1/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/keytable/2.8.1/js/dataTables.keyTable.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.3.0/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.4.0/js/dataTables.searchBuilder.min.js"></script>
<script src="https://cdn.datatables.net/searchbuilder/1.4.0/js/searchBuilder.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.1.1/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.1.1/js/searchPanes.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.6.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/staterestore/1.2.1/js/dataTables.stateRestore.min.js"></script>
<script src="https://cdn.datatables.net/staterestore/1.2.1/js/stateRestore.bootstrap5.min.js"></script>

@vite('resources/js/app.js')
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
<!-- Chart JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<!--Sweet Alert 2-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Ui Script -->
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script type="text/javascript">
    /**
     * Creates a DataTable with the specified columns.
     *
     * @param {Array} columns - An array of column names to display in the table.
     * @returns {Object} - A DataTable object.
     */
    function createDataTable(columns) {
        // Map the columns array to an array of column definitions.
        const colDefs = columns.map(col => ({ data: col, className: 'text-center align-middle' }));

        // Initialize the DataTable with options.
        const table = $(`#TabledataTable`).DataTable({
            // Enable server-side processing for large datasets.
            processing: true,
            // Enable server-side processing for large datasets.
            serverSide: true,
            // Automatically adjust the table layout for smaller screens.
            responsive: true,
            // Save the state of the table (e.g. sorting and filtering) for future visits.
            stateSave: true,
            // Show all rows on a single page.
            pageLength: 10,
            // Keep the table header fixed at the top of the page when scrolling.
            fixedHeader: true,
            // Allow rows to be selected.
            select: true,
            // Define the layout of the DataTable controls.
            dom: 'TlBfrtip',
            // Fetch data from the current page.
            ajax: window.location.pathname,
            // Define the columns for the DataTable.
            columns: [
                // Add a checkbox column for selecting rows.
                { data: 'checkbox', name: 'checkbox', orderable: false, printable: false, width: '1%', className: 'text-center align-middle' },
                // Add an ID column.
                { data: 'id', name: 'id', visible: true, className: 'text-center align-middle', width: '1%' },
                // Add the columns specified in the `columns` parameter.
                ...colDefs,
                // Add an action column for buttons or links.
                { data: 'action', name: 'action', orderable: false, printable: false, className: 'text-center align-middle' },
            ],
            // Add buttons for copying, exporting, and printing the table.
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="bi-clipboard"></i> Copy',
                    className: 'btn btn-secondary btn-sm',
                    titleAttr: 'Copy to Clipboard',
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="bi-file-earmark-excel"></i> Excel',
                    className: 'btn btn-secondary btn-sm',
                    titleAttr: 'Export to Excel',
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bi-file-earmark-pdf"></i> PDF',
                    className: 'btn btn-secondary btn-sm',
                    titleAttr: 'Export to PDF',
                },
                {
                    extend: 'print',
                    text: '<i class="bi-printer"></i> Print',
                    className: 'btn btn-secondary btn-sm',
                    titleAttr: 'Print Table',
                },
            ],
            // Sort by the first column (ID) in descending order by default.
            order: [[1, 'desc']],
            // Allow the user to change the number of rows per page.
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
            // Add a CSS class to rows that have a `deleted_at` property.
            rowCallback: function (row, data, index) {
                if (data.deleted_at) {
                    $(row).addClass('bg-danger');
                }
            },
            // Show a loading spinner while the table is being processed.
            // This code assumes you have a spinner element with ID "spinner".
            preDrawCallback: function () {
                $('#spinner').show();
            },
            drawCallback: function () {
                $('#spinner').hide();
            }
        });

        // Move the DataTable buttons to the specified container.
        table.buttons().container().appendTo($('#actions'));

        // Return the DataTable object.
        return table;
    }



    /**
     * Submits a form using AJAX and reloads a DataTable.
     *
     * @param {string} id - The ID of the form element.
     * @param {string} model - The ID of the modal element.
     */
    function updateOrCreate(id, model) {
        // Submit form when it is submitted
        $(id).submit(function (e) {
            e.preventDefault(); // Prevent the default form submit action

            // Create a FormData object to store the form data
            var formData = new FormData(this);

            // Send an AJAX request to the server to create or update data
            $.ajax({
                type: 'POST', // HTTP request method
                dataType: 'json', // Data format to send and receive
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json'}, // Request headers
                url: window.location.pathname, // Request URL
                data: formData, // Data to send
                cache: false, // Disable caching
                contentType: false, // Do not set content type
                processData: false, // Do not process data
                error: (data) => { // Function to execute on error
                    console.log('Error:', data.responseJSON.errors);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicated Data entered!!',
                    });
                },
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    $(model).modal('hide'); // Hide the modal
                    $("#btn-submit").html('Submit'); // Set the button text to 'Submit'
                    alertNow('success', data.message); // Show a success message
                },
            });

            table.ajax.reload(); // Reload the DataTable
        });
    }

    /**
     * Deletes a record using AJAX and reloads a DataTable.
     *
     * @param {number} id - The ID of the record to delete.
     * @param {string} Model - The name of the model for the record.
     */
    function destroy(id, Model) {
        var slug = Model.toLowerCase() + "s"; // Create a slug for the model

        // Confirm that the user wants to delete the record
        if (confirm('Are you sure?')) {
            // Send an AJAX request to the server to delete the record
            $.ajax({
                type: 'POST', // HTTP request method
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'}, // Request headers
                url: "/" + slug + "/" + id, // Request URL
                method: 'DELETE', // HTTP request method
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    alertNow('success', data.message); // Show a success message
                },
            });
            table.ajax.reload(); // Reload the DataTable
            alertNow('success', 'Record deleted successfully'); // Show a success message
        }
    }


    /**
     * Permanently deletes a record using AJAX and reloads a DataTable.
     *
     * @param {number} id - The ID of the record to delete.
     * @param {string} Model - The name of the model for the record.
     */
    function forceDelete(id, Model) {
        var slug = Model.toLowerCase() + "s"; // Create a slug for the model

        // Confirm that the user wants to permanently delete the record
        if (confirm('Are you sure you want to permanently delete this record? This action cannot be undone.')) {
            // Send an AJAX request to the server to permanently delete the record
            $.ajax({
                type: 'POST', // HTTP request method
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'}, // Request headers
                url: "/forceDelete", // Request URL
                data: { id: id ,slug:slug, _method: 'DELETE' }, // Request data
                success: (data) => { // Function to execute on success
                    console.log('Success:', data);
                    alertNow('success', data.message); // Show a success message
                },
            });
            table.ajax.reload(); // Reload the DataTable
            alertNow('success', 'Record deleted permanently.'); // Show a success message
        }
    }


    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Destroy Script
     * --------------------------------------------
     * @param {string} Model - The name of the model for the record.
     */
    function massDestroy(Model) {
        // Create slug for the model
        const slug = Model.toLowerCase() + "s";

        // Create model path
        const model = "\\App\\Models\\" + Model;

        // Get the ids of the records that are checked
        const ids = Array.from($('.checkbox:checked')).map((checkbox) => checkbox.value);

        // Check if any record is selected
        if (ids.length === 0) {
            alert('Zero Record Selected!!!');
            return;
        }

        // Confirm with the user before deleting records
        if (confirm('Are you sure?')) {
            $.ajax({
                type: 'POST',
                headers: {
                    'x-csrf-token': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                url: '/massDestroy',

                // Send the ids, model slug and model name as data to the server
                data: {
                    ids: ids,
                    slug: slug,
                    model: model,
                    _method: 'DELETE'
                },
                success: (data) => {
                    console.log('Success:', data);
                    alertNow('success', data.message);
                },
            });

            // Reload the data table
            table.ajax.reload();
        }
    }

    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Force Delete Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function massForceDelete(Model){
        var slug=Model.toLowerCase()+"s";
        var model="\\App\\Models\\"+Model;
        var ids = [];
        $('.checkbox:checked').each(function(){
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Zero Record Selected!!!')
            return
        }

        if (confirm('Are you Sure?')) {
            $.ajax({
                type: 'POST',
                headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'},
                url: "/massForceDelete",
                data: { ids: ids,slug:slug, model:model, _method: 'DELETE' },
                success: (data) => {
                    console.log('Success:', data);
                    alertNow('success', data.message);
                },
            })
            table.ajax.reload();
        }
    }
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Mass Restore Script
     * --------------------------------------------
     * --------------------------------------------
     */
    function massRestore(Model) {
        // Construct the slug and model strings for the request
        const slug = Model.toLowerCase() + "s";
        const model = "\\App\\Models\\" + Model;

        // Get an array of all the selected record IDs
        const selectedIds = getSelectedRecordIds();

        // If no records are selected, show an alert and return
        if (selectedIds.length === 0) {
            alert("No records selected.");
            return;
        }

        // Confirm the restore action with the user
        if (confirm("Are you sure you want to restore the selected records?")) {
            // Send a POST request to the server to restore the selected records
            $.ajax({
                type: "POST",
                headers: {
                    "x-csrf-token": $('meta[name="csrf-token"]').attr("content"),
                    Accept: "application/json",
                },
                url: "/massRestore",
                data: {
                    ids: selectedIds,
                    slug: slug,
                    model: model,
                    _method: "POST",
                },
                success: (data) => {
                    console.log("Success:", data);
                    alertNow("success", data.message);
                },
            });
            // Reload the data table after the restore action is complete
            table.ajax.reload();
        }

        // Get an array of all the IDs of the selected records
        function getSelectedRecordIds() {
            const selectedIds = [];
            $(".checkbox:checked").each(function () {
                selectedIds.push($(this).val());
            });
            return selectedIds;
        }
    }

    /**
     * Performs a restore operation for a given record using an AJAX request.
     *
     * @param {string} id - The ID of the record to restore.
     * @param {string} Model - The name of the model class for the record.
     */
    function restore(id, Model) {
        // Derive the slug and model name for the record based on the supplied Model parameter.
        var slug = Model.toLowerCase() + "s";
        var model = "\\App\\Models\\" + Model;

        // Send an AJAX POST request to the server to perform the restore operation.
        $.ajax({
            type: 'POST',
            headers: {'x-csrf-token': $('meta[name="csrf-token"]').attr('content'), 'Accept':'application/json'},
            url: "/restore",
            data: {id: id, slug: slug, model: model, _method: 'POST'},
            success: (data) => {
                // If the restore operation was successful, log a success message to the console and display a success toast notification.
                console.log('Success:', data);
                alertNow('success', data.message);
            },
        })

        // Reload the table data using an AJAX request to ensure that the restored record is displayed.
        table.ajax.reload();
    }



    /**
     * Displays a toast notification using SweetAlert2.
     *
     * @param {string} label - The label for the toast, which determines the icon to display.
     * @param {string} action - The message to display in the toast.
     */
    function alertNow(label, action) {
        // Create a new Toast instance using SweetAlert2.
        const Toast = Swal.mixin({
            toast: true,                  // Display the toast as a notification.
            position: 'top-end',          // Position the toast at the top-right corner of the screen.
            showConfirmButton: false,     // Do not display a confirmation button.
            timer: 3000,                  // Automatically close the toast after 3 seconds.
            timerProgressBar: true,       // Display a progress bar indicating the remaining time.
            didOpen: (toast) => {
                // Pause the timer when the user hovers over the toast.
                toast.addEventListener('mouseenter', Swal.stopTimer)
                // Resume the timer when the user moves the mouse away from the toast.
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        // Display the toast notification.
        Toast.fire({
            icon: label,   // Set the icon for the toast based on the label.
            title: action  // Set the message for the toast.
        })
    }

</script>
<!-- Additional Scripts -->
@yield('scripts')
<script type="text/javascript">
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Scroll Arrow Script
     * --------------------------------------------
     * --------------------------------------------
     */
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    $('#return-to-top').click(function() {      // When arrow is clicked
        $('body,html').animate({
            scrollTop : 0                       // Scroll to top of body
        }, 500);
    });
</script>
<script>
    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Search Script
     * --------------------------------------------
     * --------------------------------------------
     */
        $('.searchable-field').select2({
            theme: "classic",
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("globalSearch") }}',
                dataType: 'json',
                type: 'GET',
                delay: 200,
                data: function (term) {
                    return {
                        search: term
                    };
                },
                results: function (data) {
                    return {
                        data
                    };
                }
            },
            escapeMarkup: function (markup) { return markup; },
            templateResult: formatItem,
            templateSelection: formatItemSelection,
            placeholder : 'Global Search',
            language: {
                inputTooShort: function(args) {
                    var remainingChars = args.minimum - args.input.length;
                    var translation = 'Search input is too short';

                    return translation.replace(':count', remainingChars);
                },
                errorLoading: function() {
                    return 'errorr loading results';
                },
                searching: function() {
                    return 'global searching';
                },
                noResults: function() {
                    return 'no result';
                },
            }

        });
        function formatItem (item) {
            if (item.loading) {
                return 'global searching';
            }
            var markup = "<div class='searchable-link' href='" + item.url + "'>";
            markup += "<div class='searchable-title'>" + item.model + "</div>";
            $.each(item.fields, function(key, field) {
                markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
            });
            markup += "</div></div>";

            return markup;
        }

        function formatItemSelection (item) {
            if (!item.model) {
                return 'global search';
            }
            return item.model;
        }

    $(document).delegate('.searchable-link', 'click', function() {
        var url = $(this).attr('href');
        window.location = url;
    });

    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Get the model scopes
     * --------------------------------------------
     * --------------------------------------------
     */

    // Fetch available scopes and populate the select tag
    if (document.getElementById('scope-select')) {
        $.get(window.location.pathname + '/create?scopes=', function (scopes) {
            $.each(scopes, function (index, scope) {
                $('#scope-select').append($('<option>', {
                    value: scope,
                    text: scope
                }));
            });
        });

        // Refresh the DataTable when a scope is selected
        $('#scope-select').on('change', function () {
            var scope = $(this).val();
            if (scope === '') {
                table.ajax.url(window.location.pathname).load();
            } else {
                table.ajax.url(window.location.pathname + '?scope=' + encodeURIComponent(scope)).load();
            }
        });
    }


    /**
     * ------------------------------------------
     * --------------------------------------------
     * Global Select Deselect Records Script
     * --------------------------------------------
     * --------------------------------------------
     */
    $('#select-toggle').click(function() {
        var checkboxes = $('td:nth-child(1) input[type="checkbox"]');
        checkboxes.prop('checked', !checkboxes.prop('checked'));

        // Change button icon based on whether any checkboxes are checked
        var buttonIcon = $('#select-toggle i');
        if (checkboxes.filter(':checked').length > 0) {
            buttonIcon.removeClass('far fa-square');
            buttonIcon.addClass('fas fa-check-square');
        } else {
            buttonIcon.removeClass('fas fa-check-square');
            buttonIcon.addClass('far fa-square');
        }
    });


</script>

</body>
</html>
