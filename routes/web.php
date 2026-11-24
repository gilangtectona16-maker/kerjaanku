    <?php

    // Route aplikasi dipisah aja ya per modul agar gak bentrok saat kerja tim.
    // Setiap anggota hanya menyunting berkas modul miliknya.
    require __DIR__.'/modules/auth.php';     // Gerald: login, dashboard, pengguna
    require __DIR__.'/modules/master.php';   // Alif: blok, slot
    require __DIR__.'/modules/parkir.php';   // Gilang: kendaraan masuk/keluar, laporan riwayat
    require __DIR__.'/modules/publik.php';   // Sofyan: beranda, pencarian, peta, kendaraan, okupansi
    require __DIR__.'/modules/user.php';     // pengguna (CRUD) 
