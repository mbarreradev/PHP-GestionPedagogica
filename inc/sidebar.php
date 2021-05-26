
<?php
require_once 'database.php';

// Contador ordenes pendientes de revisión - confirmación
$sql_ordenes_pendientes_confirmacion = "SELECT * FROM ordencompra WHERE estado_orden = 'Pendiente de confirmación'";  
$rs_result_ordenes_pendientes_confirmacion = mysqli_query($conn, $sql_ordenes_pendientes_confirmacion);  
$cnt_ordenes_pendientes_confirmacion = $rs_result_ordenes_pendientes_confirmacion->num_rows;

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="js/carrito.js"></script>
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
              <i class="fas fa-sign-in-alt"></i>
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
              <i class="fas fa-folder"></i>
              <span>Mis ordenes</span>
            </a>
          </li>
          <li>
            <a href="/planificaciones">
              <i class="fas fa-file"></i>
              <span>Planificaciones</span>
            </a>
          </li>
          <li>
            <a href="/guias">
              <i class="fas fa-file"></i>
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
                <i class="fas fa-folder"></i>
              <span>Ordenes</span>
              <span class="badge badge-pill badge-danger"><?php echo $cnt_ordenes_pendientes_confirmacion; ?></span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="/ordenes">Dashboard</a>
                </li>
                <li>
                  <a href="#">Ordenes pagadas</a>
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
                  <a href="#">Usuarios bloqueados</a>
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
                  <a href="/documentos">Dashboard</a>
                </li>
                <li>
                  <a href="/nuevodocumento">Crear nuevo</a>
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
            <a href="https://api.whatsapp.com/send?phone=569"><button class="btn btn-secondary"><i class="fab fa-whatsapp"></i> Contactar por WhatsApp</button></a>
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
      <a href="#cart" data-toggle="modal">
        <i class="fas fa-cart-plus" alt="Carrito"><span class="total-count badge badge-pill badge-info ml-1"></span></i>
      </a>
      <a href="/opciones">
        <i class="fa fa-cog" alt="Opciones"></i>
      </a>
      <a href="/logout">
        <i class="fa fa-power-off" alt="Desconectar"></i>
      </a>
    </div>
    <?php
    }
    ?>
  </nav>

   <!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Carrito</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="show-cart table">
          
        </table>
        <div>Precio total: $<span class="total-cart"></span></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Crear orden</button>
      </div>
    </div>
  </div>
</div>
  <!-- sidebar-wrapper  -->