<div>
    <!-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh -->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{ strToUpper($buttonText) }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            {{ $slot }}
        </ul>
      </li>
</div>