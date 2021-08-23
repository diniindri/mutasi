<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <?php
        $kewenangan = $this->session->userdata('level');
        if ($kewenangan === '1') {
            $levels = [
                ['id' => 1, 'level' => 'halaman Utama'],
                ['id' => 2, 'level' => 'Rincian']
            ];
        } else {
            $levels = [
                ['id' => 1, 'level' => 'halaman Utama']
            ];
        }

        $menus = [
            ['menu' => 'Dashboard', 'level' => 1, 'url' => 'dashboard'],
            ['menu' => 'Timeline', 'level' => 1, 'url' => 'timeline'],
            ['menu' => 'SK Mutasi', 'level' => 2, 'url' => 'sk-mutasi'],
            ['menu' => 'Biaya Mutasi', 'level' => 2, 'url' => 'biaya-mutasi'],
            ['menu' => 'Monitoring Dokumen', 'level' => 2, 'url' => 'monitoring-dokumen'],
            ['menu' => 'Payroll', 'level' => 2, 'url' => 'payroll'],
            ['menu' => 'Referensi', 'level' => 2, 'url' => 'referensi'],

        ];
        foreach ($levels as $r) :
            $level = $r['level'];
            $id_level = $r['id'];
            $newAr = [];
            foreach ($menus as $val) {
                if ($val['level'] == $id_level) {
                    $newAr[] = $val;
                }
            }
        ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-3 mb-1 text-muted">
                <span><?= $level; ?></span>
            </h6>
            <ul class="nav flex-column">
                <?php
                foreach ($newAr as $s) :
                    $menu = $s['menu'];
                    $url = $s['url'];
                ?>
                    <li class="nav-item m-0 p-0">
                        <a class="nav-link <?= $this->uri->segment(1) == $url ? 'active' : ''; ?> pb-1" href="<?= base_url() . $url; ?>">
                            &nbsp; <?= $menu; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
        <a href="<?= base_url('sign-out'); ?>" class="btn btn-sm btn-outline-success mt-3 ml-4">Keluar Aplikasi</a>
    </div>
</nav>