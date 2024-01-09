<!-- Your Blade view file -->

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', [
'title' => 'View Complaints',
'welcome_message' => 'View Complaints',
])
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">List of complaints</h5>

            @if (count($complaints) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Complaint Title</th>
                        <th>Complaint Submitter</th>
                        <th>Details</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->complaint_title }} </td>
                        <td style="margin-left:5px">{{ $userNamesByUserId[$complaint->parti_ID] ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a class="btn btn-primary view-form" data-toggle="modal" data-target="#solutionModal" data-complaint-id="{{ $complaint->complaint_ID }}" data-description="{{ $complaint->description }}">
                                View Form
                            </a>

                            <!-- Modal for each complaint -->
                            <div class="modal fade" id="solutionModal" tabindex="-1" role="dialog" aria-labelledby="solutionModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="solutionModalLabel">Input Solution for Complaint</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <label for="Description">Complaint Description:</label>
                                            <input id="desc" class="form-control" readonly>
                                            <!-- Add other form elements as needed -->
                                            <!-- Add your form elements here for inputting the solution -->
                                            <form id="solutionForm{{ $complaint->id }}" action="/ComplainStatus/{{ $complaint->complaint_ID }}/Solution" method="POST">
                                                @csrf
                                                <label for="solution">Solution:</label>
                                                <textarea name="complaint_solution" id="solution" class="form-control" rows="3"></textarea>
                                                <!-- Add a hidden input field for the complaint ID -->
                                                <button type="submit" class="btn btn-primary">Submit Solution</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <form id="complaintForm_{{ $complaint->complaint_ID }}" action="/ComplainStatus/{{ $complaint->complaint_ID }}" method="POST">
                                @csrf
                                <select name="complaint_status" id="complaint_status_{{ $complaint->complaint_ID }}" class="btn bg-gradient-primary" onchange="submitForm('{{ $complaint->complaint_ID }}')">
                                    <option value="{{ $complaint->complaint_status }}" disabled selected>{{ $complaint->complaint_status }}</option>
                                    <option value="open">Open</option>
                                   <!-- <option value="close">Close</option>-->
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No complaints found.</p>
            @endif


        </div>
    </div>
</div>

@include('layouts.footers.auth.footer')

<!-- Your JavaScript Section -->
@push('js')
<script>
    function submitForm(complaintId) {
        var selectedOption = document.getElementById("complaint_status_" + complaintId).value;

        // Display confirmation dialog
        var isConfirmed = confirm("Are you sure you want to submit the complaint with status: " + selectedOption + "?");

        if (isConfirmed) {
            // Submit the form
            document.getElementById("complaintForm_" + complaintId).submit();
        } else {
            // Optionally, handle the case where the user cancels the submission
        }
    }
    $(document).ready(function() {
        // Event listener for when the modal is about to be shown
        $('#solutionModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var description = button.data('description'); // Extract info from data-* attributes
            var complaintId = button.data('complaint-id'); // Extract complaint ID

            // Update the modal content with the specific complaint details
            var modal = $(this);
            modal.find('#desc').val(description);

            // Display the complaint ID in the modal title or a separate element
            modal.find('.modal-title').text('Input Solution for Complaint ID: ' + complaintId);

            // Update the action attribute of the form in the modal
            var solutionForm = modal.find('#solutionForm');
            solutionForm.attr('action', '/ComplainStatus/' + complaintId + '/Solution');
            solutionForm.data('complaint-id', complaintId);
        });

        // Event listener for when the solution form is submitted
        $('#solutionForm').on('submit', function(event) {
            // Handle your form submission logic here
        });
    });
</script>
@endpush
@endsection

