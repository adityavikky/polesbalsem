CREATE TABLE `antrean_loket` (
  `id_antrean_loket` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) NOT NULL DEFAULT '0',
  `id_loket` bigint(20) NOT NULL,
  `tanggal_antrean_loket` date DEFAULT NULL,
  `status_antrean_loket` varchar(10) NOT NULL DEFAULT 'Aktif' COMMENT 'Aktif/Tidak',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_antrean` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_antrean_loket`),
  KEY `antrean_loket_id_loket_index` (`id_loket`),
  KEY `antrean_loket_id_users_index` (`id_user`) USING BTREE
) ENGINE=InnoDB;

CREATE TABLE `antrean_loket_detail` (
  `id_antrean_loket_detail` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_antrean_loket` bigint(20) NOT NULL,
  `id_loket` bigint(20) NOT NULL,
  `tanggal_panggil` datetime DEFAULT NULL,
  `qty_panggil` int(11) NOT NULL DEFAULT '0',
  `status_antrean_loket_detail` varchar(10) NOT NULL DEFAULT 'Aktif' COMMENT 'Aktif/Tidak',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_antrean_loket_detail`)
) ENGINE=InnoDB;
