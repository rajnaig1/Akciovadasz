@extends('../layouts/layout')
@section('content')
    @if (null != Session::get('profileModifySuccess'))
        <div class="alert alert-success">
            <p class="text-center">Profilod módosítva!</p>
        </div>
    @elseif (null != Session::get('profileModifyFailure'))
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="text-center">{{ $error }}</p>
            @endforeach
        </div>
    @else
    @endif
    <form action='/profileModify' method='POST'>
        @csrf
        <strong>Név:</strong>
        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required
            style="margin-bottom: 10px;">
        <strong>Email:</strong>
        <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required
            style="margin-bottom: 10px;">
        <strong>Régi jelszó:</strong>
        <input type="text" class="form-control" name="old_password" placeholder="Régi Jelszó" required
            style="margin-bottom: 10px;">
        <strong>Új jelszó:</strong>
        <input type="text" class="form-control" name="password" placeholder="Jelszó" required
            style="margin-bottom: 10px;">
        <strong>Új jelszó mégegyszer:</strong>
        <input type="text" class="form-control" name="password_confirmation" placeholder="Jelszó Mégegyszer" required
            style="margin-bottom: 10px;">
        <button class="btn btn-success btn-rounded" type="submit">Módosítás</button>
    </form>
@endsection
