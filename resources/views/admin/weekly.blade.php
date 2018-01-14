@extends('template.admin')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h2>Weekly Closing Report</h2>
        <table id="tbl" class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>M #ID</th>
                <th>Name</th>
                <th>Level</th>
                <th>Direct</th>
                <th>Team</th>
                <th>Amount w/o (Admin+TDS)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $index=>$m)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $m->id }}</td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->level }}</td>
                    <td>{{ $m->highest . ' '. $m->team[0]->name }}</td>
                    <td>{{ count($m->team) }}</td>
                    <td>{{ $m->account['amount']. ' ('.$m->account['admin']. ' + '.$m->account['tds'] .')' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function (){
            $("#tbl").dataTable({
                dom: 'Bfrtlp',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        })
    </script>
@endsection