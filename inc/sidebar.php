
<?php
require_once 'database.php';
?>
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="http://repositorio.gestionpedagogica.cl">Gestión Pedagógica</a>
        <span class="badge badge-pill badge-primary">Beta</span>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <?php
      if (isset($_SESSION["fb_access_token"]))
      {
      ?>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="<?php echo $row_profile_general["avatar_url"]; ?>" alt="User picture">
        </div>
        <div class="user-info">
          <span class="user-name"><strong><?php echo $row_profile_general["nombres"] ." ". $row_profile_general["apellidos"]; ?></strong></span>
          <span class="user-role"><?php if($row_profile_general["rango"] == 2) { echo "Administrador"; } else { echo "Usuario"; } ?></span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <?php
      }
      ?>
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>Navegación</span>
          </li>
          <li>
            <a href="http://repositorio.gestionpedagogica.cl">
              <i class="fa fa-home"></i>
              <span>Inicio</span>
            </a>
          </li>
          <?php
          if (!isset($_SESSION["fb_access_token"]))
            {
          ?>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="far fa-gem"></i>
              <span>Iniciar sesión</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="/login">Con Facebook</a>
                </li>
                <li>
                  <a href="#">Con Correo</a>
                </li>
              </ul>
            </div>
          </li>
          <li>
            <a href="/planificaciones">
              <i class="fa fa-folder"></i>
              <span>Planificaciones</span>
            </a>
          </li>
          <li>
            <a href="/guias">
              <i class="fa fa-folder"></i>
              <span>Guías</span>
            </a>
          </li>
          <li>
            <a href="/contacto">
              <i class="fas fa-envelope"></i>
              <span>Contacto</span>
            </a>
          </li>
          <?php
          }
				  else
				  {
          ?>
          <li>
            <a href="/perfil">
              <i class="fas fa-id-card"></i>
              <span>Mi perfil</span>
            </a>
          </li>
          <li>
            <a href="/misordenes">
              <i class="fa fa-calendar"></i>
              <span>Mis ordenes</span>
            </a>
          </li>
          <li>
            <a href="/planificaciones">
              <i class="fa fa-folder"></i>
              <span>Planificaciones</span>
            </a>
          </li>
          <li>
            <a href="/guias">
              <i class="fa fa-folder"></i>
              <span>Guías</span>
            </a>
          </li>
          <li>
            <a href="/contacto">
              <i class="fas fa-envelope"></i>
              <span>Contacto</span>
            </a>
          </li>
          <?php
          }
          ?>

          <?php 
          if (isset($_SESSION["rango"]) == '2')
          {
          ?>
          <li class="header-menu">
            <span>Administración</span>
          </li>
          <li>
            <a href="/administracion">
              <i class="fa fa-tachometer-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fas fa-user"></i>
              <span>Ordenes</span>
              <span class="badge badge-pill badge-danger">3</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="/ordenes">Dashboard</a>
                </li>
                <li>
                  <a href="#">Ver todos</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fas fa-user"></i>
              <span>Usuarios</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="/usuarios">Dashboard</a>
                </li>
                <li>
                  <a href="#">Ver todos</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fas fa-file"></i>
              <span>Documentos</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="/archivos">Dashboard</a>
                </li>
                <li>
                  <a href="#">Crear nuevo</a>
                </li>
                <li>
                  <a href="#">Todos</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-chart-line"></i>
              <span>Estadísticas</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li>
          <?php
          }
		      ?>

        </ul>
      </div>
      <!-- sidebar-menu  -->
      <!-- sidebar-header  -->
      <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" placeholder="Contactar por WhatsApp">
            <button>WhatsApp</button>
          </div>
        </div>
      </div>
      <!-- sidebar-search  -->
    </div>
    <?php
    if (isset($_SESSION["fb_access_token"]))
    {
    ?>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
      <a href="/opciones">
        <i class="fa fa-cog"></i>
      </a>
      <a href="/logout">
        <i class="fa fa-power-off"></i>
      </a>
    </div>
    <?php
    }
    ?>
  </nav>
  <!-- sidebar-wrapper  -->