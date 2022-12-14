@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Prescriptions</h1>
    <p class="mb-4">List of all prescriptions. View the prescription and start creating quotation</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Prescriptions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered prescriptionTable" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Address</th>
                            <th>Delivery Time</th>
                            <th>View Prescription</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Note</th>
                            <th>Address</th>
                            <th>Delivery Time</th>
                            <th>View Prescription</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($prescriptions as $prescription)
                        <tr>
                            <form action="/create_quotation_view" method="get">
                                <td>{{ $prescription->id }}</td>
                                <td>{{ $prescription->prescription_name }}</td>
                                <td>{{ $prescription->date }}</td>
                                <td>{{ $prescription->note }}</td>
                                <td>{{ $prescription->address }}</td>
                                <td>{{ $prescription->deliveryTime }}</td>
                                <td><a href="" class="viewImg" target="_blank" data-toggle="modal" data-target="#prescriptionModal" data-id="{{ $prescription->id }}">View Prescription</a></td>
                                <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                                @if($prescription->quotation_status == 'created' || $prescription->quotation_status == 'sent' || $prescription->quotation_status == 'accepted' || $prescription->quotation_status == 'rejected')
                                <td style="color: green; text-align: center;"><b>CREATED</b></td>
                                @else
                                <td><button type="submit" class="btn btn-primary mr-3">Create Quotation</button></td>
                                @endif
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- The Modal for prescription -->
        <div class="modal fade" id="prescriptionModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 id="modal-title" class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <img id="imgPres" style="display: block; margin-left: auto; margin-right: auto;" src="" alt="prescription">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End of modal for prescription -->
    </div>

</div>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script type='text/javascript'>
    $(document).ready(function() {

        $('.prescriptionTable').on('click', '.viewImg', function(e) {
            e.preventDefault();

            var prescriptionID = $(this).attr('data-id');

            if (prescriptionID > 0) {

                // AJAX request
                var url = "{{ route('prescription.show',[':prescriptionID']) }}";
                url = url.replace(':prescriptionID', prescriptionID);

                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: function(response) {
                        //Change the title of the modal header
                        $('#modal-title').text(response.prescription_name[0].prescription_name);

                        //Change the prescription image
                        $('#imgPres').attr("src", response.prescription_img[0].file_name);
                    }
                });
            }
        });

    });
</script>
@endsection