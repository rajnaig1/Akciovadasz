<div>
    <!-- Be present above all else. - Naval Ravikant -->
    <h2 class="text-center" id="{{ $id }}_h2" style="display:none;">{{ $h2 }}</h2>
    <table class="table table-striped align-middle" id="{{ $id.'Table' }}" style="display:none;">
        <thead class="text-center">
                <th></th>
                <th>Terméknév</th>
                <th>Mennyiség</th>
                <th>Ár</th>
                <th>Megjegyzés</th>
                <th>Akció időtartama</th>
                <th>Kép</th>
                <th colspan="2">Műveletek</th>
        </thead>
        <tbody>
            {{ $slot }}
        
        </tbody>
    </table>
</div>