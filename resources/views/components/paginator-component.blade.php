<div>
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
    <div class=" d-flex justify-content-center sticky-bottom">
        <div class="d-none d-lg-block">
        <nav aria-label="...">
          <ul class="pagination pagination-lg">
            {{ $slot }}
          </ul>
        </nav>
      </div>
      <div class="d-none d-lg-none d-md-block">
        <nav aria-label="...">
          <ul class="pagination pagination">
            {{ $slot }}
          </ul>
        </nav>
      </div>
      <div class="d-none d-lg-none d-md-none d-sm-block">
        <nav aria-label="...">
          <ul class="pagination pagination-sm">
            {{ $slot }}
          </ul>
        </nav>
      </div>
      <div class="d-block d-sm-none">
        <nav aria-label="...">
          <ul class="pagination pagination-sm">
            {{ $slot }}
          </ul>
        </nav>
      </div>
      </div>
</div>