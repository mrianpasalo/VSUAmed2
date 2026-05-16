      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="https://www.instagram.com/_shrwin.dv" class="logo">
              <!-- <img
                src="../assets/img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="20"
              /> -->
              <p class="text-white text-center h4" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">CLINIC RECORDS</p>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary" id="mainSidebarAccordion">

              <!---------------------- Sidebar ----------------------->
              
              <li class="nav-item"> <!-- Dashboard Button -->
                <a href="dashboard.php">
                  <i class="fas fa-layer-group"></i>
                  <p>Dashboard</p>
                </a>
              </li>

              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#medRec">
                  <i class="fas fa-bars"></i>
                  <p>Medical Records</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="medRec" data-bs-parent="#mainSidebarAccordion">
                  <ul class="nav nav-collapse"  id="programAccordion">
                    <?php
                      include '../model/sidebarFunction.php';
                      $programs = getPrograms();
                      if($programs):
                      foreach($programs as $prog):
                      ?>
                      <li>
                        <a data-bs-toggle="collapse" href="#programs<?= $prog['program_id'] ?>">
                          <span class="sub-item"><?= strtoupper($prog['program_code']) ?></span>
                          <span class="caret"></span>
                        </a>
                        <div class="collapse" id="programs<?= $prog['program_id'] ?>" data-bs-parent="#programAccordion">
                          <ul class="nav nav-collapse subnav">
                            <?php
                              $years = getYear();
                              foreach ($years as $yr):
                              ?>
                              <li>
                                <a href="medicalrecord.php?program=<?= $prog['program_id'] ?>&&yr=<?= $yr['year_level_id'] ?>">
                                  <span class="sub-item"><?= $yr['year_level_name'] . " Year" ?></span>
                                </a>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </li>
                    <?php endforeach; endif; ?>
                    <li>
                      <a href="medicalrecord.php?page=addProgram">
                        <span class="sub-item">Add Program</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>

              <li class="nav-item submenu"> <!-- Student Collapse Button -->
                <a data-bs-toggle="collapse" href="#Students" class="collapsed" aria-expanded="false">
                  <i class="fas fa-layer-group"></i>
                  <p>Students</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="Students" data-bs-parent="#mainSidebarAccordion">
                  <ul class="nav nav-collapse">

                    <li>
                      <a href="manage_students.php?page=AddStudent">
                        <span class="sub-item">Add Students</span>
                      </a>
                    </li>

                    <li>
                      <a href="manage_students.php?page=SearchStudent">
                        <span class="sub-item">Search Students</span>
                      </a>
                    </li>



                  </ul>
                </div>
              </li>

              <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Menu Levels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav1">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav2">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Level 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> --> <!--- if collapsible menu is needed -->


              <!---------------------- Sidebar ----------------------->


            </ul>
          </div>
        </div>
      </div>