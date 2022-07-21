<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?= base_url() ?>assets/dist/img/user1.png" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?= $user->username ?></p>
				<small><?= $user->email ?></small>
			</div>
		</div>

		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN MENU</li>
			<!-- Optionally, you can add icons to the links -->
			<?php
			$page = $this->uri->segment(1);
			$master = ["level", "skema", "skemalsp", "dosen", "mahasiswa"];
			$relasi = ["skemapengajar", "levelskemalsp"];
			$users = ["users"];
			?>
			<li class="<?= $page === 'dashboard' ? "active" : "" ?>"><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="treeview <?= in_array($page, $master)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-folder"></i> <span>Data Master</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'level' ? "active" : "" ?>">
							<a href="<?= base_url('level') ?>">
								<i class="fa fa-circle-o"></i>
								Master Level KKNI
							</a>
						</li>
						<li class="<?= $page === 'skema' ? "active" : "" ?>">
							<a href="<?= base_url('skema') ?>">
								<i class="fa fa-circle-o"></i>
								Master Skema
							</a>
						</li>
						<li class="<?= $page === 'skemalsp' ? "active" : "" ?>">
							<a href="<?= base_url('skemalsp') ?>">
								<i class="fa fa-circle-o"></i>
								Master Skema LSP
							</a>
						</li>

						<li class="<?= $page === 'pengajar' ? "active" : "" ?>">
							<a href="<?= base_url('pengajar') ?>">
								<i class="fa fa-circle-o"></i>
								Master Pengajar
							</a>
						</li>
						<li class="<?= $page === 'peserta' ? "active" : "" ?>">
							<a href="<?= base_url('peserta') ?>">
								<i class="fa fa-circle-o"></i>
								Master Peserta
							</a>
						</li>
					</ul>
				</li>
				<li class="treeview <?= in_array($page, $relasi)  ? "active menu-open" : ""  ?>">
					<a href="#"><i class="fa fa-link"></i> <span>Relasi</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li class="<?= $page === 'skemapengajar' ? "active" : "" ?>">
							<a href="<?= base_url('skemapengajar') ?>">
								<i class="fa fa-circle-o"></i>
								Skema - Pengajar
							</a>
						</li>
						<li class="<?= $page === 'levelskemalsp' ? "active" : "" ?>">
							<a href="<?= base_url('levelskemalsp') ?>">
								<i class="fa fa-circle-o"></i>
								Level - KLSP
							</a>
						</li>
					</ul>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'modul' ? "active" : "" ?>">
					<a href="<?= base_url('modul') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text-o"></i> <span>Modul</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'soal' ? "active" : "" ?>">
					<a href="<?= base_url('soal') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text-o"></i> <span>Soal Objective</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'essay' ? "active" : "" ?>">
					<a href="<?= base_url('essay') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text-o"></i> <span>Soal Essay</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'latihan' ? "active" : "" ?>">
					<a href="<?= base_url('latihan') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text-o"></i> <span>Soal Latihan</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->is_admin() || $this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'praktek' ? "active" : "" ?>">
					<a href="<?= base_url('praktek') ?>" rel="noopener noreferrer">
						<i class="fa fa-file-text-o"></i> <span>Soal Praktek</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'ujian' ? "active" : "" ?>">
					<a href="<?= base_url('ujian/master') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Ujian</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="<?= $page === 'ujian' ? "active" : "" ?>">
					<a href="<?= base_url('ujian/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Ujian</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="<?= $page === 'modul' ? "active" : "" ?>">
					<a href="<?= base_url('modul/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Modul</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'latihanmodul' ? "active" : "" ?>">
					<a href="<?= base_url('latihanmodul/master') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Latihan</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="<?= $page === 'latihanmodul' ? "active" : "" ?>">
					<a href="<?= base_url('latihanmodul/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Soal Latihan</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'ujian_praktek' ? "active" : "" ?>">
					<a href="<?= base_url('ujian_praktek/master') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Praktek</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="<?= $page === 'ujian_praktek' ? "active" : "" ?>">
					<a href="<?= base_url('ujian_praktek/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Soal Praktek</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->in_group('dosen')) : ?>
				<li class="<?= $page === 'ujian_essay' ? "active" : "" ?>">
					<a href="<?= base_url('ujian_essay/master') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Essay</span>
					</a>
				</li>
			<?php endif; ?>

			<?php if ($this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="<?= $page === 'ujian_essay' ? "active" : "" ?>">
					<a href="<?= base_url('ujian_essay/list') ?>" rel="noopener noreferrer">
						<i class="fa fa-chrome"></i> <span>Soal Essay</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="header">REPORTS</li>
				<li class="<?= $page === 'hasilujian' ? "active" : "" ?>">
					<a href="<?= base_url('hasilujian') ?>" rel="noopener noreferrer">
						<i class="fa fa-file"></i> <span>Hasil Ujian</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="header">REPORTS</li>
				<li class="<?= $page === 'hasillatihan' ? "active" : "" ?>">
					<a href="<?= base_url('hasillatihan') ?>" rel="noopener noreferrer">
						<i class="fa fa-file"></i> <span>Hasil Latihan</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="header">REPORTS</li>
				<li class="<?= $page === 'hasilujianessay' ? "active" : "" ?>">
					<a href="<?= base_url('hasilujianessay') ?>" rel="noopener noreferrer">
						<i class="fa fa-file"></i> <span>Hasil Essay</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if (!$this->ion_auth->in_group('mahasiswa')) : ?>
				<li class="header">REPORTS</li>
				<li class="<?= $page === 'hasilujianpraktek' ? "active" : "" ?>">
					<a href="<?= base_url('hasilujianpraktek') ?>" rel="noopener noreferrer">
						<i class="fa fa-file"></i> <span>Hasil Praktek</span>
					</a>
				</li>
			<?php endif; ?>
			<?php if ($this->ion_auth->is_admin()) : ?>
				<li class="header">ADMINISTRATOR</li>
				<li class="<?= $page === 'users' ? "active" : "" ?>">
					<a href="<?= base_url('users') ?>" rel="noopener noreferrer">
						<i class="fa fa-users"></i> <span>User Management</span>
					</a>
				</li>
				<li class="<?= $page === 'settings' ? "active" : "" ?>">
					<a href="<?= base_url('settings') ?>" rel="noopener noreferrer">
						<i class="fa fa-cog"></i> <span>Settings</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>

	</section>
	<!-- /.sidebar -->
</aside>