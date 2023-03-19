@extends('../layouts/datatable')
@section('datatablecontent')
    <table class="table" id="cronLogTable">
        <thead class="text-center">
                <th class="text-center"><b>Time</b><i class="fa fa-fw fa-sort"></i></th>
                <th><b>Runner</b></th>
                <th><b>Job</b><i class="fa fa-fw fa-sort"></i></th>
                <th class="text-center"><b>File</b><i class="fa fa-fw fa-sort"></i></th>
                <th><b>Line</b></th>
                <th><b>Message</b></th>
                <th><b>StackTrace</b></th>
            
        </thead>
        <tbody>
        @foreach($logCollection as $log)
        @if($log->success!='failure')
        <tr class="table-success">
        @else
        <tr class="table-danger">
        @endif
        <td>{{ $log->time }}</td>
        <td>{{ $log->runner }}</td>
        <td>{{ $log->job }}</td>
        @if($log->success!='failure')
        <td class="text-center">Success</td>
        <td class="text-center">Success</td>
        <td class="text-center">Success</td>
        <td class="text-center">Success</td>
        @else
        <td>{{ $log->file }}</td>
        <td>{{ $log->line }}</td>
        <td>{{ $log->message }}</td>
        <td>{{ $log->stackTrace }}</td>
        @endif
        </tr>
        @endforeach
        </tbody>
    </table>
    <script src="{{ asset('js/customJS/datatable_setup.js') }}"></script>
    <script>
    let id='cronLogTable';
    setupDataTable(id);  
    </script>
    @endsection