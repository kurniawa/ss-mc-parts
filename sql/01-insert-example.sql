INSERT INTO `ekspedisi` (`id`, `nama`, `bentuk`, `alamat`, `kontak`, `keterangan`) VALUES
(1, 'Angkasa', 'CV.', 'Jl. Mangga Dua Raya,\nRuko Mangga Dua Plaza Blok B No. 6', '(021) 6120 705', ''),
(2, 'Berkat Abadi Jaya', '', 'Komplek Rukan Lodan Center\nBlok A, No.17 & 18', '(021) 2269 4890', '');

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `pulau`, `daerah`, `kontak`, `keterangan`, `singkatan`, `id_reseller`) VALUES
(1, 'Berjaya Motor', 'Jl. Selat Panjang No.A1,\r\nPontianak Utara', 'Kalimantan', 'Pontianak', '0853 8999 9188', NULL, 'BM', NULL),
(2, 'SS Uji 169 Handil Bakti', 'Jl. Karya Sabumi IV, No.26 A,\nKayu Tangi, Banjarmasin', 'Kalimantan', 'Banjarmasin', '(0561) 330 3216', '', 'SS', NULL);

INSERT INTO `pelanggan_use_ekspedisi` (`id`, `id_ekspedisi`, `id_pelanggan`, `ekspedisi_transit`, `ekspedisi_utama`) VALUES
(1, 2, 1, 'n', 'y'),
(2, 2, 1, 'n', 'y'),
(3, 2, 2, 'n', 'y');