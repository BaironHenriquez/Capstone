<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calificar Técnico | Baieco</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    /* Fondo degradado */
    body {
      background: linear-gradient(135deg, #0047ab 0%, #007bff 50%, #ff6600 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      color: #333;
    }

    /* Navbar superior */
    nav {
      background-color: #163bbd;
      padding: 0.75rem 1.5rem;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      font-weight: 700;
      color: white !important;
      font-size: 1.25rem;
    }

    .navbar-brand .logo {
      background-color: #ff6600;
      border-radius: 12px;
      padding: 6px 10px;
      margin-right: 8px;
    }

    .navbar-nav .nav-link {
      color: #ffffff;
      font-weight: 500;
      margin-right: 1rem;
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: #ffcc80;
    }

    .btn-ingresar {
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 6px 18px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-ingresar:hover {
      background: #005fd4;
      transform: translateY(-1px);
    }

    .btn-demo {
      background: #ff6600;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 6px 18px;
      font-weight: 600;
      margin-left: 8px;
      transition: 0.3s;
    }

    .btn-demo:hover {
      background: #ff7f2a;
      transform: translateY(-1px);
    }

    /* Contenedor del formulario */
    .rating-container {
      background: #ffffff;
      border-radius: 18px;
      padding: 40px 35px;
      width: 100%;
      max-width: 500px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
      text-align: center;
      margin: 80px auto;
    }

    .rating-container h3 {
      color: #0047ab;
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .rating-container p {
      color: #555;
      font-size: 15px;
      margin-bottom: 1.5rem;
    }

    .form-label {
      color: #0047ab;
      font-weight: 600;
    }

    .form-control,
    .form-select {
      border-radius: 8px;
      border: 1px solid #ccd9ff;
      background-color: #f8f9ff;
      color: #333;
    }

    .form-control::placeholder {
      color: #999;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.2);
    }

    /* Estrellas */
    .rating {
      display: flex;
      justify-content: center;
      gap: 12px;
      margin: 20px 0;
    }

    .rating i {
      font-size: 2.5rem;
      color: #ccc;
      cursor: pointer;
      transition: all 0.25s ease;
      text-shadow: none;
    }

    .rating i.hovered {
      color: #fff;
      text-shadow: 0 0 10px #007bff, 0 0 20px #007bff;
    }

    .rating i.active {
      color: #ffd43b;
      text-shadow: 0 0 8px #007bff, 0 0 16px #007bff;
    }

    /* Botón */
    .btn-custom {
      background: linear-gradient(90deg, #007bff, #ff6600);
      border: none;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      padding: 12px 0;
      transition: 0.3s ease;
    }

    .btn-custom:hover {
      transform: scale(1.02);
      background: linear-gradient(90deg, #0069d9, #ff7a1a);
    }

    footer {
      margin-top: 25px;
      font-size: 13px;
      color: #777;
    }
  </style>
</head>
<body>

  <!-- 🔹 NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <div class="logo">
          <i class="bi bi-file-earmark-text-fill text-white"></i>
        </div>
        Baieco
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Características</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Consultar Orden</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        </ul>
        <div>
          <button class="btn-ingresar">Ingresar</button>
          <button class="btn-demo">Demo Gratis</button>
        </div>
      </div>
    </div>
  </nav>

  <!-- 🔹 FORMULARIO -->
  <div class="rating-container">
    <h3>Calificar Técnico</h3>
    <p>Evalúa la atención de nuestro técnico y ayuda a mejorar nuestro servicio 💬</p>

    <form id="ratingForm">
      <div class="mb-4 text-start">
        <label for="orden" class="form-label">Ingrese orden de servicio:</label>
        <input type="text" id="orden" class="form-control" placeholder="Ej: TS-2025-001" required>
      </div>

      <div class="mb-4 text-start">
        <label for="tecnico" class="form-label">Selecciona un técnico:</label>
        <select class="form-select" id="tecnico" required>
          <option value="">-- Selecciona --</option>
          <option value="1">Carlos Rodríguez</option>
          <option value="2">María González</option>
          <option value="3">Diego Sánchez</option>
          <option value="4">Ana Torres</option>
          <option value="5">Luis Contreras</option>
        </select>
      </div>

      <div class="rating" id="starRating">
        <i class="bi bi-star" data-value="1"></i>
        <i class="bi bi-star" data-value="2"></i>
        <i class="bi bi-star" data-value="3"></i>
        <i class="bi bi-star" data-value="4"></i>
        <i class="bi bi-star" data-value="5"></i>
      </div>

      <input type="hidden" id="ratingValue" name="rating" value="0">

      <button type="submit" class="btn btn-custom w-100">Enviar Calificación</button>
    </form>

    <div id="mensaje" class="alert mt-4 d-none"></div>

    <footer>© 2025 Baieco Service - Todos los derechos reservados</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const stars = document.querySelectorAll('#starRating i');
    const ratingValue = document.getElementById('ratingValue');
    const tecnicoSelect = document.getElementById('tecnico');
    const form = document.getElementById('ratingForm');
    const mensaje = document.getElementById('mensaje');
    const ordenInput = document.getElementById('orden');
    const calificaciones = {};

    function pintarEstrellas(valor) {
      stars.forEach((s, i) => {
        s.className = 'bi ' + (i < valor ? 'bi-star-fill active' : 'bi-star');
      });
    }

    stars.forEach((star, index) => {
      star.addEventListener('mouseover', () => {
        stars.forEach((s, i) => s.classList.toggle('hovered', i <= index));
      });
      star.addEventListener('mouseout', () => {
        stars.forEach(s => s.classList.remove('hovered'));
      });
      star.addEventListener('click', () => {
        const tecnico = tecnicoSelect.value;
        if (!tecnico) {
          alert('Selecciona un técnico antes de calificar.');
          return;
        }
        const valor = star.getAttribute('data-value');
        ratingValue.value = valor;
        calificaciones[tecnico] = valor;
        pintarEstrellas(valor);
      });
    });

    tecnicoSelect.addEventListener('change', () => {
      const tecnico = tecnicoSelect.value;
      const valor = calificaciones[tecnico] || 0;
      ratingValue.value = valor;
      pintarEstrellas(valor);
    });

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const tecnico = tecnicoSelect.value;
      const rating = ratingValue.value;
      const orden = ordenInput.value.trim();
      if (!orden || !tecnico || rating == 0) {
        mensaje.classList.remove('d-none', 'alert-success');
        mensaje.classList.add('alert', 'alert-danger');
        mensaje.textContent = 'Por favor, completa todos los campos y selecciona una calificación.';
        return;
      }
      const nombre = tecnicoSelect.options[tecnicoSelect.selectedIndex].text;
      mensaje.classList.remove('d-none', 'alert-danger');
      mensaje.classList.add('alert', 'alert-success');
      mensaje.textContent = `✅ Orden ${orden}: Has calificado a ${nombre} con ${rating} estrella${rating > 1 ? 's' : ''}. ¡Gracias por tu opinión!`;
      form.reset();
      ratingValue.value = 0;
      pintarEstrellas(0);
    });
  </script>
</body>
</html>
