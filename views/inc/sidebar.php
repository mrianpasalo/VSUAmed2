<style>
    .icon-big.icon-primary   { background: #00BFFF !important; } 
    .icon-big.icon-info      { background: #00AF91 !important; } 
    .icon-big.icon-success   { background: #20B2AA !important; } 
</style>
</head>
<style>
  .sidebar .nav.nav-secondary > .nav-item a:hover i,
  .sidebar .nav.nav-secondary > .nav-item a:focus i {
    color: #fdfbd4 !important;
  }
</style>
<div class="sidebar" style="background-color: #008080">
    <div class="sidebar-logo">
      <?php $page = basename($_SERVER['PHP_SELF']); ?>
      <div class="logo-header" style="background-color: #008080">
        <a href="#" class="logo">
          <p class="text-white text-center h4" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:#ffffff !important;">CLINIC RECORDS</p>
        </a>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar" style="color:#ffffff;">
            <i class="gg-menu-right"></i>
          </button>
          <button class="btn btn-toggle sidenav-toggler" style="color:#ffffff;">
            <i class="gg-menu-left"></i>
          </button>
        </div>
        <button class="topbar-toggler more" style="color:#ffffff;">
          <i class="gg-more-vertical-alt"></i>
        </button>
      </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
      <div class="sidebar-content text-white">
        <ul class="nav nav-secondary" id="mainSidebarAccordion">
 
          <li class="nav-item <?= $page == 'dashboard.php' ? 'submenu' : '' ?>">
            <a href="dashboard.php" style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-layer-group" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">Dashboard</p>
            </a>
          </li>
 
          <hr class="m-3" style="border-color:rgba(255,255,255,0.2);">
 
          <li class="nav-item <?= $page == 'addRecord.php' ? 'submenu' : '' ?>">
            <a href="addRecord.php" style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-plus" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">Add Record</p>
            </a>
          </li>
 
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#medRec" style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-book" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">Medical Records</p>
              <span class="caret" style="color:#ffffff;"></span>
            </a>
            <div class="collapse <?= isset($_GET['program']) || isset($_GET['pagess']) ? 'show' : '' ?>"
                id="medRec" data-bs-parent="#mainSidebarAccordion">
              <ul class="nav nav-collapse" id="programAccordion">
                <?php
                include_once '../model/fetch.php';
                $programs = getPrograms();
                if ($programs):
                  foreach ($programs as $prog): ?>
                  <li>
                    <a data-bs-toggle="collapse" href="#programs<?= $prog['program_id'] ?>"
                      style="color:#ffffff !important; text-decoration:none;"
                      onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
                      onmouseout="this.style.backgroundColor='transparent'">
                      <span class="sub-item" style="color:#ffffff;"><?= strtoupper($prog['program_code']) ?></span>
                      <span class="caret" style="color:#ffffff;"></span>
                    </a>
                    <div class="collapse" id="programs<?= $prog['program_id'] ?>" data-bs-parent="#programAccordion">
                      <ul class="nav nav-collapse subnav">
                        <?php $years = getYear(); foreach ($years as $yr): ?>
                          <li>
                            <a href="medicalrecord.php?program=<?= $prog['program_id'] ?>&&yr=<?= $yr['year_level_id'] ?>"
                              style="color:#ffffff !important; text-decoration:none;"
                              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
                              onmouseout="this.style.backgroundColor='transparent'">
                              <span class="sub-item" style="color:#ffffff;"><?= $yr['year_level_name'] . " Year" ?></span>
                            </a>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </li>
                <?php endforeach; endif; ?>
                <li class="<?= isset($_GET['pagess']) ? 'active' : '' ?>">
                  <a href="medicalrecord.php?pagess=addProgram" style="color:#ffffff !important; text-decoration:none;"
                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <span class="sub-item" style="color:#ffffff;">Add Program</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
 
          <li class="nav-item <?= $page == 'history.php' ? 'submenu' : '' ?>">
            <a href="history.php" style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-history" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">History</p>
            </a>
          </li>
 
          <hr class="m-3" style="border-color:rgba(255,255,255,0.2);">
 
          <li class="nav-item">
            <a data-bs-toggle="collapse" href="#Students" class="collapsed"
              style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-users" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">Students</p>
              <span class="caret" style="color:#ffffff;"></span>
            </a>
            <div class="collapse <?= isset($_GET['page']) || isset($_GET['pages']) ? 'show' : '' ?>" id="Students" data-bs-parent="#mainSidebarAccordion">
              <ul class="nav nav-collapse">
                <li class="<?= isset($_GET['page']) == 'AddStudent' ? 'active' : '' ?>">
                  <a href="manage_students.php?page=AddStudent" style="color:#ffffff !important; text-decoration:none;"
                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <span class="sub-item" style="color:#ffffff;">Add Students</span>
                  </a>
                </li>
                <li class="<?= isset($_GET['pages']) == 'SearchStudent' ? 'active' : '' ?>">
                  <a href="manage_students.php?pages=SearchStudent" style="color:#ffffff !important; text-decoration:none;"
                    onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
                    onmouseout="this.style.backgroundColor='transparent'">
                    <span class="sub-item" style="color:#ffffff;">Search Students</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
 
          <li class="nav-item mt-5">
            <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"
              style="color:#ffffff !important; text-decoration:none;"
              onmouseover="this.style.backgroundColor='rgba(255,255,255,0.15)'"
              onmouseout="this.style.backgroundColor='transparent'">
              <i class="fas fa-lock" style="color:#ffffff;"></i>
              <p style="color:#ffffff; margin:0;">Logout</p>
            </a>
          </li>
 
        </ul>
      </div>
    </div>
</div>
 
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
      <div class="modal-header px-4 pt-4 pb-3">
        <div class="rounded-circle d-flex justify-content-center align-items-center" style="width:40px;height:40px;background:#fee2e2;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2">
            <path d="M12 9v4m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
          </svg>
        </div>
        <div class="ms-3">
          <h6 class="mb-0 fw-semibold">Confirm Logout</h6>
          <small class="text-muted">You will be returned to the login page.</small>
        </div>
        <button class="btn-close ms-auto" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer border-0 px-4 pb-4">
        <button class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../pages/logout.php" class="btn btn-sm btn-danger">Yes, Logout</a>
      </div>
    </div>
  </div>
</div>
