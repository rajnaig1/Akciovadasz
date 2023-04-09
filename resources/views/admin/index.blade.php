@extends('../layouts/layout')
@section('content')
<h1 class="text-center">Cron Runner Logs</h1>
<div class="text-center">
    <div class="btn-group" role="group" aria-label="Basic example">
        <x-modal-component class="btn-warning" buttonText="Penny manuális feltöltés" id="PennyModal" title="A penny adatbázis manuális feltöltése" body="Biztosan felül akarja írni az adatbázis?" url="/admin/pennyupload"/>
        <x-modal-component class="btn-warning" buttonText="Tesco manuális feltöltés" id="TescoModal" title="A Tesco adatbázis manuális feltöltése" body="Biztosan felül akarja írni az adatbázis?" url="/admin/tescoupload"/>
      </div>
      @if (null!=Session::get('status')&&(Session::get('status')->response=='Success'))

        <div class="alert alert-success">
            <p>{{ Session::get('status')->Shop.' Database Updated Succesfully!' }}</p>
        </div>
        @elseif (null!=Session::get('status')&&(Session::get('status')->response=='failure'))
        <div class="alert alert-danger">
            <p>' OOPS Something went wrong! Check logs for further details'</p>
        </div>
        @else
    @endif
</div>
@if(count($logCollection)==0)
<div class="alert alert-warning min-vh-80">
    <span class='d-flex align-items-center justify-content-center min-vh-100'>
<h2 class='h4 text-center'>Nincs logfile!</h2>
</span>
</div>
@else
@include('../tables/cronlogtable')
@endif

@endsection