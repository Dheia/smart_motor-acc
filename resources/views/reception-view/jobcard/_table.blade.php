<script>
    $(document).ready(function() {
        init_DataTables();
    });

    function init_DataTables() {

        console.log('run_datatables');

        if( typeof ($.fn.DataTable) === 'undefined'){ return; }
        console.log('init_DataTables');

        var handleDataTableButtons = function() {
            if ($("#datatable-buttons").length) {
                $("#datatable-buttons").DataTable({
                    dom: "Bfrtip",
                    buttons: [
                        {
                            extend: "copy",
                            className: "btn-sm"
                        },
                        {
                            extend: "csv",
                            className: "btn-sm"
                        },
                        {
                            extend: "excel",
                            className: "btn-sm"
                        },
                        {
                            extend: "pdfHtml5",
                            className: "btn-sm"
                        },
                        {
                            extend: "print",
                            className: "btn-sm"
                        },
                    ],
                    responsive: true
                });
            }
        };

        TableManageButtons = function() {
            "use strict";
            return {
                init: function() {
                    handleDataTableButtons();
                }
            };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
            keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
            ajax: "js/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });

        $('#datatable-fixed-header').DataTable({
            fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
            'order': [[ 1, 'asc' ]],
            'columnDefs': [
                { orderable: false, targets: [0] }
            ]
        });
        $datatable.on('draw.dt', function() {
            $('checkbox input').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });
        });

        TableManageButtons.init();

    };
</script>

<div class="x_panel table_up_div">
    <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
        <thead>
        <tr>
            <th>{{ trans('app.#')}}</th>
            <th>{{ trans('app.Job Card No')}}</th>
            <th>{{ trans('Quality Controller')}}</th>
            <th>{{ trans('app.Customer Name')}}</th>
            <th>{{ trans('Company Name')}}</th>
            <th>{{ trans('Vehicle Number')}}</th>
            <th>{{ trans('Received Date')}}</th>
            <th>{{ trans('app.Status')}}</th>
            <th>{{ trans('app.Action')}}</th>
        </tr>
        </thead>


        <tbody>
        <?php $i = 1; ?>
        @if(!empty($services))
                <?php $i = 1; ?>
            @foreach ($services as $servicess)

                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $servicess->job_no }}</td>
                    <td>{{ getCustomerName($servicess->assign_to) }}</td>
                    <td>{{ getCustomerName($servicess->customer_id) }}</td>
                    @php($user = \App\User::find($servicess->customer_id))
                    @php($company = \App\User::find($user->company_id))
                    @php($company_name = $company?$company->name:'-')
                    <td>{{ $company_name }}</td>
                    @php($vehicle = DB::table('tbl_vehicles')->where('id',$servicess->vehicle_id)->first())
                    <td>{{ $vehicle->carNumber }}</td>
                        <?php $dateservice = date("Y-m-d", strtotime($servicess->service_date)); ?>
                    <td>{{ date(getDateFormat(),strtotime($dateservice)) }}</td>

                    <td><?php if($servicess->done_status == 0)
                        { echo"Active";}
                        else if($servicess->done_status == 1)
                        { echo"Completed";}
                        elseif($servicess->done_status == 2){
                            echo"Progress";
                        } ?>
                    </td>
                    <td>

                            <?php  $jobcard = getJobcardStatus($servicess->job_no);
                            $view_data = getInvoiceStatus($servicess->job_no);
                            ?>

                        @if($jobcard == 1)
                            <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
                        @elseif($view_data == "Yes")
                            <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
                        @else
                            <a href="{{ url('/reception/jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" >{{ trans('app.Process Job')}}</button></a>
                        @endif

                    </td>
                </tr>
                    <?php $i++; ?>
            @endforeach

        @endif
        </tbody>
    </table>
</div>




<!-- Custom Theme Scripts -->








