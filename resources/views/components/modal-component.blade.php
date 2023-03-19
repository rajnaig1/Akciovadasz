<button type="button" id="{{ $id.'Button' }}" {{ $attributes->merge(["class"=>"btn"]) }} data-bs-toggle="modal" data-bs-target="#{{ $id }}"data-bs-whatever="@mdo">
    {{ $buttonText }}
  </button>
<div>
    <!-- Life is available only in the present moment. - Thich Nhat Hanh -->

    <!-- Modal -->
  <div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
          <button type="button" class="btn-close" id="{{ $id.'CloseButton' }}" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{ $body }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" id="{{ $id.'DismissButton' }}" data-bs-dismiss="modal">Nem</button>
          <a class="btn btn-success" href="{{ URL($url) }}">Igen</a>
        </div>
      </div>
    </div>
  </div>
</div>