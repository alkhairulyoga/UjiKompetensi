    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">

                <?php
                $page = $this->uri->segment(1);
                $master = ["jurusan", "skema", "skemalsp", "dosen", "mahasiswa"];
                $relasi = ["skemapengajar", "levelskemalsp"];
                $users = ["users"];
                ?>

                <?php if ($this->ion_auth->is_admin()) : ?>
                    <a class="nav-link collapsed <?= in_array($page, $master)  ? "active menu-open" : ""  ?>" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                        <i class="bi bi-menu-button-wide"></i><span>Data Master</span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <li class="<?= $page === 'jurusan' ? "active" : "" ?>">
                            <a href="<?= base_url('jurusan') ?>">
                                <i class="bi bi-circle"></i>
                                Master Level
                            </a>
                        </li>
                        <li class="<?= $page === 'skema' ? "active" : "" ?>">
                            <a href="<?= base_url('skema') ?>">
                                <i class="bi bi-circle"></i>
                                Master Skema
                            </a>
                        </li>
                        <li class="<?= $page === 'skemalsp' ? "active" : "" ?>">
                            <a href="<?= base_url('skemalsp') ?>">
                                <i class="bi bi-circle"></i>
                                Master Skema Lsp
                            </a>
                        </li>

                        <li class="<?= $page === 'dosen' ? "active" : "" ?>">
                            <a href="<?= base_url('dosen') ?>">
                                <i class="bi bi-circle"></i>
                                Master Pengajar
                            </a>
                        </li>
                        <li class="<?= $page === 'mahasiswa' ? "active" : "" ?>">
                            <a href="<?= base_url('mahasiswa') ?>">
                                <i class="bi bi-circle"></i>
                                Master Peserta
                            </a>
                        </li>
                        <li class="<?= $page === 'pertemuan' ? "active" : "" ?>">
                            <a href="<?= base_url('pertemuan') ?>">
                                <i class="bi bi-circle"></i>
                                Master Pertemuan
                            </a>
                        </li>
                        <li class="<?= $page === 'absensi' ? "active" : "" ?>">
                            <a href="<?= base_url('absensi') ?>">
                                <i class="bi bi-circle"></i>
                                Master Absensi
                            </a>
                        </li>
                    </ul>
            </li><!-- End Components Nav -->
        <?php endif; ?>


        <li class="<?= $page === 'dashboard' ? "active" : "" ?>">
            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-grid"></i>
                <br>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'modul' ? "active" : "" ?>">
                <a href="<?= base_url('modul') ?>" rel="noopener noreferrer">
                    <i class="bi bi-book-half"></i> <span>Modul</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'soal' ? "active" : "" ?>">
                <a href="<?= base_url('soal') ?>" rel="noopener noreferrer">
                    <i class="bi bi-list-task"></i> <span>Soal Objective</span>
                </a>
            </li>
        <?php endif; ?>

        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'essay' ? "active" : "" ?>">
                <a href="<?= base_url('essay') ?>" rel="noopener noreferrer">
                    <i class="bi bi-file-earmark-check"></i> <span>Soal Essay</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'latihan' ? "active" : "" ?>">
                <a href="<?= base_url('latihan') ?>" rel="noopener noreferrer">
                    <i class="bi bi-file-earmark-check"></i> <span>Soal Latihan</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'praktek' ? "active" : "" ?>">
                <a href="<?= base_url('praktek') ?>" rel="noopener noreferrer">
                    <i class="bi bi-code-square"></i> <span>Soal Praktek</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($this->ion_auth->in_group('dosen')) : ?>
            <li class=" nav-link collapsed <?= $page === 'ujian' ? "active" : "" ?>">
                <a href="<?= base_url('ujian/master') ?>" rel="noopener noreferrer">
                    <i class="bi bi-exclamation-square"></i> <span>Ujian</span>
                </a>
            </li>
        <?php endif; ?>
        <?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
            <li class=" nav-link collapsed <?= $page === 'ujian' ? "active" : "" ?>">
                <a href="<?= base_url('ujian/list') ?>" rel="noopener noreferrer">
                    <i class="bi bi-exclamation-square"></i> <span>Ujian</span>
                </a>
            </li>
            <?php endif; ?>-
            <?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
                <li class=" nav-link collapsed <?= $page === 'latihan' ? "active" : "" ?>">
                    <a href="<?= base_url('latihan/list') ?>" rel="noopener noreferrer">
                        <i class="bi bi-exclamation-square"></i> <span>Latihan</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
                <li class=" nav-link collapsed <?= $page === 'ujian' ? "active" : "" ?>">
                    <a href="<?= base_url('absen/list') ?>" rel="noopener noreferrer">
                        <i class="bi bi-exclamation-square"></i> <span>Absen</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
                <li class=" nav-link collapsed <?= $page === 'absen' ? "active" : "" ?>">
                    <a href="<?= base_url('absen/list') ?>" rel="noopener noreferrer">
                        <i class="bi bi-exclamation-square"></i> <span>Absen</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
                <li class=" nav-link collapsed <?= $page === 'praktek' ? "active" : "" ?>">
                    <a href="<?= base_url('praktek/list') ?>" rel="noopener noreferrer">
                        <i class="bi bi-exclamation-square"></i> <span>Praktek</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
                <li class="nav-heading">Report</li>
                <li class=" nav-link collapsed <?= $page === 'hasilessay' ? "active" : "" ?>">
                    <a href="<?= base_url('hasilessay') ?>" rel="noopener noreferrer">
                        <i class="bi bi-file-binary"></i> <span>Hasil Ujian</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
                <li class="nav-heading">Report</li>
                <li class=" nav-link collapsed <?= $page === 'hasilujian' ? "active" : "" ?>">
                    <a href="<?= base_url('hasilujian') ?>" rel="noopener noreferrer">
                        <i class="bi bi-file-binary"></i> <span>Hasil Essay</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
                <li class="nav-heading">Report</li>
                <li class=" nav-link collapsed <?= $page === 'muser' ? "active" : "" ?>">
                    <a href="<?= base_url('muser') ?>" rel="noopener noreferrer">
                        <i class="bi bi-journal-bookmark-fill"></i> <span>User Modul</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
                <li class="nav-heading">Report</li>
                <li class=" nav-link collapsed <?= $page === 'muser' ? "active" : "" ?>">
                    <a href="<?= base_url('muser') ?>" rel="noopener noreferrer">
                        <i class="bi bi-journal-bookmark-fill"></i> <span>User Modul</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if ($this->ion_auth->is_admin()) : ?>
                <li class="header">ADMINISTRATOR</li>
                <li class=" nav-link collapsed <?= $page === 'users' ? "active" : "" ?>">
                    <a href="<?= base_url('users') ?>" rel="noopener noreferrer">
                        <i class="fa fa-users"></i> <span>User Management</span>
                    </a>
                </li>
                <li class=" nav-link collapsed <?= $page === 'settings' ? "active" : "" ?>">
                    <a href="<?= base_url('settings') ?>" rel="noopener noreferrer">
                        <i class="bi bi-journal-text"></i> <span>Settings</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>

    </aside><!-- End Sidebar-->