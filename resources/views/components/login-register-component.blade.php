<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->

    <!-- Modal -->
<form id="{{ $id }}_form" action="{{ url($url) }}" method="{{ $method }}">
  @csrf
  <div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
          <button type="button" class="btn-close" id="{{ $id.'CloseButton' }}" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          @if(count($errors)>0)
          <div class="alert alert-danger">
          @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
          </div>
        @endforeach
        @endif
          {{ $body }}
          {{ $slot }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="{{ $id.'DismissButton' }}" data-bs-dismiss="modal">Vissza</button>
          <input class="btn btn-success" type="submit" id="{{ $id.'SuccessButton' }}" value="{{ $buttonText }}">
        </div>
      </div>
    </div>
  </div>
</form>
</div>