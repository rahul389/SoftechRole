<script type="text/javascript">


    	$(function () {
        // Defaults
	        var swalInit = swal.mixin({
	            buttonsStyling: false,
	            confirmButtonClass: 'btn btn-primary',
	            cancelButtonClass: 'btn btn-light'
	        });
            $('.fileinput-remove-button').hide();
            $('.fileinput-upload-button').hide();
            $('.file-upload-indicator').hide();
            $('.kv-file-upload').hide();
	        var message = '';
            var url = window.location.href;
            var lastPart = url.split("/").pop();
	        var cards = null;
	        var chart = null;
	        var amountChart = null;
	        var app = {
	            init: function () {
                    app.rolesData();
                    app.deleteRole();
                    app.toggleRoleStatus();
                    app.checkBoxShow();
                    app.componentUniform();
                    app.selectAllCheckbox();
                    app.handleResponse();
	            },

	        /**
             * Handle status response
             * */
            handleResponse: function (response, message, statusCode) {
                let notification = {};
                switch (statusCode) {
                    case 200:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 201:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 204:
                        notification.title = 'Success';
                        notification.text = message;
                        notification.addclass = 'bg-success border-success';
                        break;
                    case 404:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 409:
                        notification.title = 'Error';
                        notification.text = message;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 422:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 500:
                        notification.title = 'Error';
                        notification.text = response.responseJSON.error;
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    case 598: // Network read timeout error
                        notification.title = 'Error';
                        notification.text = 'Please check your internet connection';
                        notification.addclass = 'bg-danger border-danger';
                        break;
                    default:

                }
                if (!$.isEmptyObject(notification)) {
                    notification.delay = 1500;
                    new PNotify(notification);
                }
            },

	        /*
             * roles list
             * */
            rolesData: function () {

                $('#roles-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    bInfo: false,
                    // order: [[1, "id"]],
                    order: [[0, "desc"]],
                    language: {
                        sSearch: "Search ",
                        searchPlaceholder: 'Search @lang("views.role")',
                    },
                    order:['3','desc'],
                   columnDefs: [         // see https://datatables.net/reference/option/columns.searchable
                        {
                            'searchable': false,
                            'orderable': false,
                            'targets': [1,2],
                        },
                        {
                            'visible':false,
                            'targets': [3],
                        },
                         {className: "dt-center", targets: [0,1,2]}
                    ],

                    ajax: {
                        url: '{{ route('roles.data') }}',

                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'status', name: 'status'},
                        {data: 'actions', name: 'actions'},
                        {data: 'id', name: 'id'},
                    ],
                    "drawCallback": function() {
                        if (this.fnSettings().fnRecordsTotal() < 11) {
                            $('.dataTables_paginate').hide();
                        }
                    },
                });
            },
            /**
             * delete role
             * */

            deleteRole: function (id) {
                $(document).on('click', '.delete-role', function (e) {
                    var id = $(this).data("role-id");
                    var destroyRoute = $(this).data("destroy-route");
                    var message = '';
                    swalInit({
                        title: '@lang('messages.are_you_sure')',
                        text: '@lang('messages.you_are_going_to_action_this_attribute', ['action' => 'delete', 'attribute' => 'role'])',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: '@lang('views.delete')',
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: destroyRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'DELETE',
                                statusCode: {
                                    204: function (data) {
                                        app.rolesData();
                                        message = '@lang('messages.attribute_action_successfully',['attribute' => \Lang::get('views.role'), 'action' => 'deleted'])';
                                        app.handleResponse(data, message, 204);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                });
            },

            /**
             * for checkbox and radio button
             * */
            componentUniform: function () {
                $('.form-check-input-styled').uniform();

                $('.form-input-styled').uniform({
                    fileButtonClass: 'action btn bg-pink-400'
                });

                $('.form-control-uniform-custom').uniform({
                    fileButtonClass: 'action btn bg-blue',
                    selectClass: 'uniform-select bg-pink-400 border-pink-400'
                });
            },

            checkBoxShow:function () {
                $(document).on('click', '.date-range-checkbox', function (e) {
                    if ( $('.date-range-checkbox').is(':checked') ) {
                        $('#select-date').val('true');
                        $('#date-calender').show();
                        $('#date-calender-text').show();
                    } else {
                        $('#select-date').val('');
                        $('#date-calender').hide();
                        $('#date-calender-text').hide();
                    }
                });

            },

            /*
             * select/un-select permission checkboxes
             * */
            selectAllCheckbox: function () {
                $(document).on('click', '.select-all', function () {
                    if ($(this).is(':checked')) {
                        $(this).parents('.checkbox-parent').find('.checkbox').each(function () {
                            $(this).parents(".uniform-checker").find("span").addClass('checked');
                            $(this).prop('checked', true);
                        });
                    } else {
                        $(this).parents('.checkbox-parent').find('.checkbox').each(function () {
                            $(this).parents(".uniform-checker").find("span").removeClass('checked');
                            $(this).prop('checked', false);
                        });
                    }
                });
            },

            /*
             * activate/deactivate the role status
             * */
            toggleRoleStatus: function () {
                $(document).on('click', '.toggle-role-status', function (e) {
                    var id = $(this).data("role-id");
                    var statusRoute = $(this).data("status-route");
                    var message = $(this).hasClass('inactive') ? '@lang("messages.attribute_action_successfully", ["attribute" => "Role", "action" => "activated"])' : '@lang("messages.attribute_action_successfully", ["attribute" => "Role", "action" => "deactivated"])';
                    var text = $(this).hasClass('active') ? '@lang('messages.you_are_going_to_action_this_attribute',['action' => 'deactivate', 'attribute' => 'role'])' : '@lang('messages.you_are_going_to_action_this_attribute',['action' => 'activate', 'attribute' => 'role'])';
                    var btnTxt = $(this).hasClass('active') ? '@lang('views.deactivate')' : '@lang('views.activate')';
                    var confirmButtonClass = $(this).hasClass('active') ? 'btn btn-danger' : 'btn btn-success';
                    swalInit({
                        title: '@lang('messages.are_you_sure')',
                        text: text,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonClass: confirmButtonClass,
                        confirmButtonText: btnTxt,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            $.ajax({
                                url: statusRoute,
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                processData: false,
                                contentType: false,
                                type: 'POST',
                                statusCode: {
                                    200: function (data) {
                                        app.rolesData();
                                        app.handleResponse(data, message, 200);
                                    },
                                    404: function (data) {
                                        app.handleResponse(data, message, 404);
                                    },
                                    500: function (data) {
                                        app.handleResponse(data, message, 500);
                                    }
                                }
                            });
                        }
                    })
                })
            },

	    };
        app.init();
    });

</script>