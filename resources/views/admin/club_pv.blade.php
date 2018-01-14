@extends('template.admin')
@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" />
@endsection
@section('content')
    <div class="container">
        <h2>Club PV Report</h2>
        <table id="tbl" class="table table-striped">
            <thead>
            <tr>
                <th>M #ID</th>
                <th>Direct Count</th>
                <th>Highest Member PV</th>
                <th>Other Total PV</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $m)
                <tr>
                    <td>{{ $m['id'] }}</td>
                    <td>{{ $m['c'] }}</td>
                    <td><span style="color: {{ $m['h'][0]>50000?'red':'black' }};">{{ $m['h'][0] }}</span> - {{ isset($m['h'][1])?$m['h'][1]:'' }}</td>
                    <td><span style="color: {{ $m['o']>50000?'red':'black' }};">{{ $m['o'] }}</span></td>
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