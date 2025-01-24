<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{route('home')}}" class=" d-flex align-items-center">
      <span class="d-none d-lg-block ml-3 text-white"> <strong>DELIVERY</strong> </span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->



  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

    <li class="nav-item dropdown">
  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
    <i class="bi bi-bell"></i>
    <span class="badge bg-primary badge-number" style="color: white !important">
      {{ count(Auth::user()->notifications) }}
    </span>
  </a><!-- End Notification Icon -->

  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" style="max-height: 300px; overflow-y: auto;">
    <li class="dropdown-header">
      Usted tiene {{ count(Auth::user()->notifications) }} notificaciones
      <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todas</span></a>
    </li>
    <li>
      <hr class="dropdown-divider">
    </li>

    @foreach (Auth::user()->notifications as $notificacion)
      <a href="{{ $notificacion->data['url'] ?? '#' }}" class="text-decoration-none text-dark">
        <li class="notification-item">
          <i class="bi bi-check-circle text-success"></i>
          <div>
            <h4>{{ $notificacion->data['titulo'] ?? '' }}</h4>
            <p>{{ $notificacion->data['mensaje'] ?? '' }}</p>
            <p>{{ $notificacion->created_at->diffForHumans() }}</p>
          </div>
        </li>
      </a>
      <li>
        <hr class="dropdown-divider">
      </li>
    @endforeach

    <li>
      <hr class="dropdown-divider">
    </li>

    <li class="dropdown-footer">
      <a href="{{ route('notificaciones.index') }}">Ver todas las notificaciones</a>
    </li>
  </ul><!-- End Notification Dropdown Items -->
</li><!-- End Notification Nav -->



      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">

          <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{Auth::user()->name}}</h6>
            <span>{{Auth::user()->role}}</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>Mi perfil</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <hr class="dropdown-divider">
          </li>


          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Salir
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>


        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
@include('layout.script')
