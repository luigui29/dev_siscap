<!-- Styles shared globally across SISCAP views -->
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

<!-- AdminLTE core CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

@stack('styles')

<style>
     /* --- CORE VARIABLES --- */
     :root {
          --primary-color: #a0aab4;
          --secondary-color: #afb8c2;
          --accent-blue: #3498db;
          --accent-green: #27ae60;
          --accent-orange: #e67e22;
          --accent-purple: #9b59b6;
          --light-bg: rgba(255, 255, 255, 0.9);
          --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          --hover-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
     }

     /* --- GLOBAL BODY --- */
     body {
          font-family: 'Inter', sans-serif;
          background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
          min-height: 100vh;
          color: #1e293b;
     }

     /* --- LAYOUT WRAPPERS --- */
     .wrapper,
     .content {
          min-height: 100vh;
     }

     /* Menu de navegacion y dropdowns */
     .navbar {
          background-color: #ffffff;
          border-bottom: 1px solid #e2e8f0;
     }

     .navbar-nav .nav-link {
          padding: 0.5rem 1rem;
          transition: all 0.3s;
     }

     .navbar-light .navbar-nav .active > .nav-link {
          font-weight: 600;
          color: #007bff;
     }

     .navbar-nav.mx-auto {
          display: flex;
          justify-content: center;
     }

     .navbar-collapse {
          position: relative;
     }

     .navbar-nav .nav-item {
          margin: 0 5px;
     }

     .dropdown-menu {
          border: none;
          box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
          position: absolute;
          z-index: 1000;
     }

     .dropdown-header {
          font-weight: bold;
          font-size: 0.8rem;
          color: #6c757d;
          text-transform: uppercase;
          letter-spacing: 0.05em;
     }

     .dropdown-submenu {
          position: relative;
     }

     .dropdown-submenu .dropdown-menu {
          top: 0;
          left: 100%;
          margin-top: -2px;
          margin-left: 2px;
          display: none;
          border-radius: 8px !important;
          border: 1px solid #e2e8f0 !important;
          box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
          min-width: 220px;
          background-color: #ffffff;
     }
     
     .dropdown-submenu:hover > .dropdown-menu,
     .dropdown-submenu.show > .dropdown-menu {
          display: block !important;
     }
     
     .dropdown-submenu .dropdown-item {
          padding: 0.5rem 1.25rem;
          font-size: 0.88rem;
          font-weight: 500;
          color: #475569;
     }

     .dropdown-submenu .dropdown-item:hover {
          background-color: rgba(93, 173, 226, 0.1) !important;
          color: #2E86C1 !important;
     }

     
     .dropdown-item.active,
     .dropdown-item:active {
          background-color: rgba(93, 173, 226, 0.1) !important;
          color: #2E86C1 !important;
     }

     /* Asegurar que el logo no se superponga */
     .brand-link {
          margin-right: 15px;
          display: flex;
          align-items: center;
     }

     .avatar-text {
          display: inline-block;
          width: 30px;
          height: 30px;
          line-height: 30px;
          text-align: center;
          background-color: #5DADE2;
          color: white;
          border-radius: 50%;
          font-weight: bold;
     }

     /* Tarjetas para stats en dashboard */
     .stat-card {
          border-left: 4px solid;
          padding-left: 1rem;
     }

     .stat-card.total-1 {
          background-color: #3498db7e;
          border-left-color: var(--accent-blue);
     }

     .stat-card.total-2 {
          background-color: #27ae607e;
          border-left-color: var(--accent-green);
     }

     .stat-card.total-3 {
          background-color: #e67e227e;
          border-left-color: var(--accent-orange);
     }

     .stat-card.total-4 {
          background-color: #9b59b67e;
          border-left-color: var(--accent-purple);
     }

     .stat-icon {
          width: 60px;
          height: 60px;
          border-radius: 12px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24px;
          opacity: 0.9;
     }

     .stat-icon.total-1 {
          background: rgba(52, 152, 219, 0.15);
          color: var(--accent-blue);
     }

     .stat-icon.total-2 {
          background: rgba(39, 174, 96, 0.15);
          color: var(--accent-green);
     }

     .stat-icon.total-3 {
          background: rgba(230, 126, 34, 0.15);
          color: var(--accent-orange);
     }

     .stat-icon.total-4 {
          background: rgba(155, 89, 182, 0.15);
          color: var(--accent-purple);
     }

     /* Estilos de tarjetas */
     .card {
          border: none;
          border-radius: 5px;
          overflow: hidden;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
          background: var(--light-bg);
          backdrop-filter: blur(10px);
     }

     .card-header,
     .card-footer {
          background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
          color: white;
          border-bottom: none;
          padding: 0.3rem 1rem;
     }

     .card-header h4 {
          font-weight: 600;
          letter-spacing: 0.5px;
     }

     .card-corporate {
          border: none;
          border-radius: 5px;
          border-top: 4px solid #5DADE2;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
          overflow: hidden;
          margin-bottom: 2rem;
          background: white;
     }

     .card-corporate .card-title {
          font-weight: 700;
          letter-spacing: 0.3px;
          font-size: 1.05rem;
          color: #d6d6d6ff !important;
          display: flex;
          align-items: center;
          margin: 0;
     }

     .card-corporate .card-title i {
          color: #5DADE2;
          margin-right: 12px;
          font-size: 1.2rem;
     }

     .card-primary:not(.card-outline) > .card-header {
          background-color: #5DADE2;
     }

     .card-info:not(.card-outline) > .card-header {
          background-color: #7FB3D5;
     }
 
     /* Estilos de tabla */
     .table {
          background: white;
          border-radius: 3px;
          overflow: hidden;
     }

     .table-corporate thead {
          background: #F8FAFC !important;
          border-bottom: 2px solid #E2E8F0 !important;
     }

     .table-corporate thead th {
          color: #64748B !important;
          font-weight: 700 !important;
          text-transform: uppercase !important;
          font-size: 0.75rem !important;
          letter-spacing: 1px !important;
          padding: 1rem 1.5rem !important;
          border: none !important;
     }

     .table-corporate td {
          padding: 1.25rem 1.5rem !important;
          vertical-align: middle !important;
          border-top: 1px solid #F1F5F9 !important;
     }

     /* Botones y acciones */
     .btn-primary {
          background-color: #5DADE2;
          border-color: #5DADE2;
          color: #fff;
     }

     .btn-primary:hover,
     .btn-primary:focus,
     .btn-primary:active {
          background-color: #4A9BCF !important;
          border-color: #4A9BCF !important;
     }

     .btn-info {
          background-color: #7FB3D5;
          border-color: #7FB3D5;
          color: #fff;
     }

     .btn-info:hover,
     .btn-info:focus,
     .btn-info:active {
          background-color: #6EA2C4 !important;
          border-color: #6EA2C4 !important;
     }

     .btn-secondary {
          background-color: #95A5A6;
          border-color: #95A5A6;
          color: #fff;
     }

     .btn-secondary:hover,
     .btn-secondary:focus,
     .btn-secondary:active {
          background-color: #849495 !important;
          border-color: #849495 !important;
     }

     .btn-success {
          background-color: #58D68D;
          border-color: #58D68D;
          color: #fff;
     }

     .btn-success:hover,
     .btn-success:focus,
     .btn-success:active {
          background-color: #47C57C !important;
          border-color: #47C57C !important;
     }

     .btn-danger {
          background-color: #EC7063;
          border-color: #EC7063;
          color: #fff;
     }

     .btn-danger:hover,
     .btn-danger:focus,
     .btn-danger:active {
          background-color: #DB5F52 !important;
          border-color: #DB5F52 !important;
     }

     .btn-pdf {
          background-color: #EC8763FF;
          border-color: #EC8763FF;
          color: #fff;
     }

     .btn-pdf:hover,
     .btn-pdf:focus,
     .btn-pdf:active {
          background-color: #DB8B52FF !important;
          border-color: #DB8B52FF !important;
          color: #fff;
     }
     
     /* Etiquetas de estatus y colores */
     .status-badge {
          padding: 0.25rem 0.75rem;
          border-radius: 20px;
          font-size: 0.75rem;
          font-weight: 500;
     }

     .status-badge-corp {
          display: inline-block;
          font-size: 0.75rem;
          font-weight: 700;
          padding: 0.25rem 0.75rem;
          border-radius: 50px;
          text-transform: uppercase;
     }

     .badge-corporate-blue {
          background-color: rgba(93, 173, 226, 0.15) !important;
          color: #2E86C1 !important;
          border: 1px solid rgba(93, 173, 226, 0.2);
     }

     .badge-verde {
          background: rgba(141, 213, 127, 0.1);
          color: #2ec150ff;
          border: 1px solid rgba(127, 213, 144, 0.2);
     }

     .badge-morado {
          background-color: rgba(196, 127, 213, 0.1);
          color: #9b59b6ff;
          border: 1px solid rgba(201, 127, 213, 0.2);
     }

     .badge-rojo {
          background-color: rgba(231, 76, 60, 0.1);
          color: #c0392bff;
          border: 1px solid rgba(231, 76, 60, 0.2);
     }

     /* Estilos para user  */
     .user-badge-ficha {
          background: #F1F5F9;
          color: #475569;
          font-weight: 700;
          padding: 0.5rem 0.75rem;
          border-radius: 6px;
          border: 1px solid #E2E8F0;
          font-size: 0.85rem;
     }

     .user-primary-text {
          color: #1E293B;
          font-weight: 600;
          font-size: 0.95rem;
          display: block;
     }

     .user-secondary-text {
          color: #64748B;
          font-size: 0.8rem;
     }

     .avatar-circle {
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
     }

     .avatar-circle:hover {
          transform: scale(1.1) rotate(5deg);
     }

     /* Estilos para Bootstrap Modals */
      .modal-content {
          border-radius: 12px;
          border: none;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
          overflow: hidden;
     }

     .modal-header {
          background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
          color: white;
          border-radius: 12px 12px 0 0;
          padding: 1.25rem 1.5rem;
          position: relative;
          overflow: hidden;
     }

     .modal-header::after {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
          pointer-events: none;
     }

     .modal-header-corporate {
          background: white !important;
          border-top: 4px solid #5DADE2 !important;
          border-bottom: 1px solid #f0f2f5 !important;
          padding: 1.25rem 1.5rem !important;
     }

     .modal-header-corporate .modal-title {
          color: #334155 !important;
          font-weight: 700 !important;
          font-size: 1.05rem !important;
          letter-spacing: 0.3px !important;
          display: flex !important;
          align-items: center;
     }

     .modal-header-corporate .modal-title i {
          color: #5DADE2 !important;
          margin-right: 12px !important;
          font-size: 1.2rem !important;
     }

     .btn-close-corporate {
          background: #f1f5f9;
          border: none;
          width: 30px;
          height: 30px;
          border-radius: 6px;
          display: flex;
          align-items: center;
          justify-content: center;
          color: #64748b;
          transition: all 0.2s;
          font-size: 1.2rem;
          line-height: 1;
          cursor: pointer;
     }

     .btn-close-corporate:hover {
          background: #ef4444;
          color: white;
     }

     .close:hover {
          transform: rotate(90deg);
          color: #fff !important;
     }
     
     .empty-state {
          text-align: center;
          padding: 3rem;
          color: #7f8c8d;
     }

     .empty-state i {
          font-size: 3rem;
          margin-bottom: 1rem;
          opacity: 0.5;
     }

     .loading-spinner {
          display: none;
          text-align: center;
          padding: 2rem;
     }

     .loading-spinner i {
          font-size: 2rem;
          color: var(--accent-blue);
          animation: spin 1s linear infinite;
     }

     @keyframes spin {
          0% {
               transform: rotate(0deg);
          }
          100% {
               transform: rotate(360deg);
          }
     }

     .breadcrumb-item + .breadcrumb-item::before {
          content: "\f105";
          font-family: "Font Awesome 5 Free";
          font-weight: 900;
          color: #cbd5e0;
          padding-right: 0.5rem;
     }

     .breadcrumb-item a:hover {
          color: #5DADE2 !important;
     }

     .breadcrumb {
          font-size: 0.85rem;
          text-transform: uppercase;
          letter-spacing: 0.5px;
     }

     /* Estilos para días del Calendario */
     .calendario-dia {
          min-height: 70px;
          padding: 6px;
          vertical-align: top;
          text-align: left;
          border: 1px solid #F1F5F9;
          background-color: #FFFFFF;
          transition: background-color 0.2s;
     }

     .calendario-dia:hover {
          background-color: #F8FAFC;
     }

     .calendario-dia .dia-numero {
          font-size: 0.85rem;
          font-weight: 600;
          color: #475569;
          margin-bottom: 4px;
          display: block;
     }

     .calendario-dia.otro-mes {
          background-color: #FAFBFC;
     }

     .calendario-dia.otro-mes .dia-numero {
          color: #CBD5E0;
     }

     .calendario-dia.feriado {
          background-color: rgba(231, 76, 60, 0.05);
     }

     .calendario-dia.feriado .dia-numero {
          color: #E74C3C;
     }

     .calendario-dia .dia-eventos {
          display: flex;
          flex-direction: column;
          gap: 3px;
     }

     .calendario-dia .evento-etiqueta {
          display: inline-block;
          font-size: 0.65rem;
          font-weight: 700;
          padding: 1px 6px;
          border-radius: 4px;
          line-height: 1.4;
          white-space: nowrap;
     }

     .evento-etiqueta.pre-programado {
          background-color: rgba(245, 176, 65, 0.15);
          color: #D4870E;
          border: 1px solid rgba(245, 176, 65, 0.3);
     }

     .evento-etiqueta.programado {
          background-color: rgba(88, 214, 141, 0.15);
          color: #1E8449;
          border: 1px solid rgba(88, 214, 141, 0.3);
     }

     .evento-etiqueta.ejecutado {
          background-color: rgba(93, 173, 226, 0.15);
          color: #2471A3;
          border: 1px solid rgba(93, 173, 226, 0.3);
     }

     /* Leyenda del calendario */
     .calendario-leyenda {
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 20px;
          font-size: 0.85rem;
          font-weight: 500;
          color: #475569;
          margin-top: 1rem;
     }

     .calendario-leyenda .leyenda-item {
          display: flex;
          align-items: center;
          gap: 6px;
     }

     .calendario-leyenda .leyenda-color {
          width: 14px;
          height: 14px;
          border-radius: 3px;
          display: inline-block;
     }
</style>
