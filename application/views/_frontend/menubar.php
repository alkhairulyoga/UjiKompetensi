    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">

                <span class="d-none d-lg-block">Sertifikasi</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">

                        <li class="nav-item">
                            <a class="nav-link" href="#">Features</a>
                        </li>
                        <li><a class="nav-link  " href="#hero">Home</a></li>
                        <li><a class="nav-link " href="#about">About</a></li>
                        <li><a class="nav-link " href="#services">Services</a></li>
                        <li><a class="nav-link  " href="#portfolio">Portfolio</a></li>
                        <li><a class="nav-link " href="#team">Team</a></li>

                    </ul>
                </div>
        </nav>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->




                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= base_url() ?>assets/dist/img/user1.png" class="rounded-circle" alt="User Image">

                        <span class="d-none d-md-block dropdown-toggle ps-2">Hi, <?= $user->first_name ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="<?= base_url() ?>assets/dist/img/user1.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?= $user->first_name . ' ' . $user->last_name ?>
                                            <small>Anggota sejak <?= date('M, Y', $user->created_on) ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= base_url() ?>users/edit/<?= $user->id ?>" class="btn btn-default btn-flat">
                                                <?= $this->ion_auth->is_admin() ? "Edit Profile" : "Ganti Password" ?>
                                            </a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="#" id="logout" class="btn btn-default btn-flat">Logout</a>
                                        </div>
                                    </li>
                                </ul>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <?= $this->ion_auth->is_admin() ? "Edit Profile" : "Ganti Password" ?>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-box-arrow-right" href="#" id="logout"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->