<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Support</h2>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Sujet</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ticket->user->name ?? '-' }}</td>
                            <td>{{ $ticket->subject ?? '-' }}</td>
                            <td>{{ $ticket->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 