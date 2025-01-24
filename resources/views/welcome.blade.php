@extends('layouts.app')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.js"></script>


<!-- Hero Section -->
<section id="hero" class="hero section dark-background">

  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
        <h1>Soluciones Rápidas y Eficientes para tu Movilidad</h1>
        <p>Somos un equipo de riders comprometidos en ofrecerte el mejor servicio de mototaxi</p>
        <div class="d-flex">
          <a href="{{route('login')}}" class="btn-get-started">Comienza Ahora</a>
        </div>
      </div>
     
    </div>
  </div>

</section><!-- /Sección Hero -->



<!-- About Section -->
<section id="about" class="about section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Sobre Nosotros</h2>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
        <p>
          Somos una empresa comprometida con ofrecer soluciones de movilidad rápidas, seguras y confiables a través de nuestro equipo de riders profesionales. Con años de experiencia en el sector, nos esforzamos por brindar un servicio eficiente que se adapte a las necesidades de nuestros clientes.
        </p>
        <ul>
          <li><i class="bi bi-check2-circle"></i> <span>Riders capacitados y profesionales.</span></li>
          <li><i class="bi bi-check2-circle"></i> <span>Servicios rápidos y seguros en toda la ciudad.</span></li>
          <li><i class="bi bi-check2-circle"></i> <span>Facilidad para solicitar viajes a través de nuestra plataforma.</span></li>
        </ul>
      </div>

      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
        <p>Ofrecemos una alternativa de transporte ágil, ideal para quienes buscan moverse por la ciudad de manera eficiente. Nos diferenciamos por la calidad de nuestro servicio, el compromiso con la seguridad de nuestros pasajeros y la rapidez con la que realizamos cada viaje.</p>
       
      </div>

    </div>

  </div>

</section><!-- /About Section -->



<!-- Services Section -->
<section id="services" class="services section light-background">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Servicios</h2>
    <p>Ofrecemos una amplia gama de servicios diseñados para mejorar tu movilidad y facilitar tu día a día.</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

    

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-box-seam icon"></i></div>
          <h4><a href="" class="stretched-link">Entrega de Paquetes</a></h4>
          <p>Entrega segura y rápida de paquetes y documentos en cualquier punto de la ciudad.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-person-check icon"></i></div>
          <h4><a href="" class="stretched-link">Rider Personalizado</a></h4>
          <p>Reserva un rider exclusivo para tus necesidades diarias de transporte.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-shield-check icon"></i></div>
          <h4><a href="" class="stretched-link">Transporte Seguro</a></h4>
          <p>Todos nuestros riders cumplen con estrictas medidas de seguridad para garantizar tu bienestar.</p>
        </div>
      </div><!-- End Service Item -->

      <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-geo-alt icon"></i></div>
          <h4><a href="" class="stretched-link">Cobertura Amplia</a></h4>
          <p>Contamos con una amplia red de riders para garantizar servicio en toda la ciudad.</p>
        </div>
      </div><!-- End Service Item -->

    </div>

  </div>

</section><!-- /Services Section -->


<!-- Call To Action Section -->
<section id="call-to-action" class="call-to-action section dark-background">

  <img src="assets/img/cta-bg.jpg" alt="">

  <div class="container">

    <div class="row" data-aos="zoom-in" data-aos-delay="100">
      <div class="col-xl-9 text-center text-xl-start">
        <h3>¿Necesitas un transporte rápido y seguro?</h3>
        <p>Con nuestro servicio de mototaxi, llegas a tu destino de forma rápida, segura y sin complicaciones. Olvídate del tráfico y los retrasos. Estamos aquí para ofrecerte un transporte eficiente cuando más lo necesitas.</p>
      </div>
      <div class="col-xl-3 cta-btn-container text-center">
        <a class="cta-btn align-middle" href="#">¡Reserva ahora!</a>
      </div>
    </div>

  </div>

</section><!-- /Call To Action Section -->



<!-- Pricing Section -->
<section id="pricing" class="pricing section light-background">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Precios</h2>
    <p>Elige el plan que mejor se adapte a tus necesidades y disfruta de un transporte rápido y seguro</p>
  </div><!-- End Section Title -->

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="pricing-item">
          <h3>Carrera corta</h3>
          <h4><sup>30 Bs</sup>1<span> / viaje</span></h4>
          <ul>
            <li><i class="bi bi-check"></i> <span>Viaje corto en la ciudad</span></li>
            <li><i class="bi bi-check"></i> <span>Disponible de lunes a viernes</span></li>
            <li><i class="bi bi-check"></i> <span>Soporte básico</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Servicio 24/7</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Seguros adicionales</span></li>
          </ul>
          <a href="#" class="buy-btn">Contratar</a>
        </div>
      </div><!-- End Pricing Item -->

      <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="pricing-item featured">
          <h3>Carrera Larga</h3>
          <h4><sup>60 Bs</sup>1<span> / viaje</span></h4>
          <ul>
            <li><i class="bi bi-check"></i> <span>Viaje de media distancia</span></li>
            <li><i class="bi bi-check"></i> <span>Disponible de lunes a sábado</span></li>
            <li><i class="bi bi-check"></i> <span>Soporte preferente</span></li>
            <li><i class="bi bi-check"></i> <span>Servicio 24/7</span></li>
            <li class="na"><i class="bi bi-x"></i> <span>Seguros adicionales</span></li>
          </ul>
          <a href="#" class="buy-btn">Contratar</a>
        </div>
      </div><!-- End Pricing Item -->

   

    </div>

  </div>

</section><!-- /Pricing Section -->



@section('content')






<!-- Footer -->

<!-- Footer -->

@endsection