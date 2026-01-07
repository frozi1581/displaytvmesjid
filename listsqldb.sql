-- layr1858_masjid.failed_jobs definition

CREATE TABLE `failed_jobs` (
                               `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                               `uuid` varchar(255) NOT NULL,
                               `connection` text NOT NULL,
                               `queue` text NOT NULL,
                               `payload` longtext NOT NULL,
                               `exception` longtext NOT NULL,
                               `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
                               PRIMARY KEY (`id`),
                               UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.kas_mesjid definition

CREATE TABLE `kas_mesjid` (
                              `id` int(6) NOT NULL AUTO_INCREMENT,
                              `id_mosque` int(2) NOT NULL,
                              `tgl` date NOT NULL,
                              `saldo_awal` decimal(10,0) NOT NULL,
                              `penerimaan` decimal(10,0) NOT NULL,
                              `pengeluaran` decimal(10,0) NOT NULL,
                              `saldo_akhir` decimal(10,0) NOT NULL,
                              `tipe_kas` varchar(10) NOT NULL,
                              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                              `last_update_at` timestamp NOT NULL DEFAULT current_timestamp(),
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- layr1858_masjid.migrations definition

CREATE TABLE `migrations` (
                              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                              `migration` varchar(255) NOT NULL,
                              `batch` int(11) NOT NULL,
                              PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.password_resets definition

CREATE TABLE `password_resets` (
                                   `email` varchar(255) NOT NULL,
                                   `token` varchar(255) NOT NULL,
                                   `created_at` timestamp NULL DEFAULT NULL,
                                   KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.personal_access_tokens definition

CREATE TABLE `personal_access_tokens` (
                                          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                          `tokenable_type` varchar(255) NOT NULL,
                                          `tokenable_id` bigint(20) unsigned NOT NULL,
                                          `name` varchar(255) NOT NULL,
                                          `token` varchar(64) NOT NULL,
                                          `abilities` text DEFAULT NULL,
                                          `last_used_at` timestamp NULL DEFAULT NULL,
                                          `created_at` timestamp NULL DEFAULT NULL,
                                          `updated_at` timestamp NULL DEFAULT NULL,
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
                                          KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.prayer_box_backgrounds definition

CREATE TABLE `prayer_box_backgrounds` (
                                          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(255) NOT NULL,
                                          `created_at` timestamp NULL DEFAULT NULL,
                                          `updated_at` timestamp NULL DEFAULT NULL,
                                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.prayerdata definition

CREATE TABLE `prayerdata` (
                              `idprayer` int(11) NOT NULL AUTO_INCREMENT,
                              `wilayah` varchar(100) NOT NULL,
                              `tgl` date NOT NULL,
                              `subuh` time NOT NULL,
                              `syuruq` time NOT NULL,
                              `dhuha` time NOT NULL,
                              `dzuhur` time NOT NULL,
                              `ashar` time NOT NULL,
                              `maghrib` time NOT NULL,
                              `isya` time NOT NULL,
                              PRIMARY KEY (`idprayer`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- layr1858_masjid.templates definition

CREATE TABLE `templates` (
                             `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                             `type` enum('image','background','video') NOT NULL,
                             `is_marketing_campaign` tinyint(1) NOT NULL DEFAULT 0,
                             `path` varchar(255) NOT NULL,
                             `name` varchar(255) NOT NULL,
                             `thumbnail` varchar(255) NOT NULL,
                             `created_at` timestamp NULL DEFAULT NULL,
                             `updated_at` timestamp NULL DEFAULT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.users definition

CREATE TABLE `users` (
                         `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                         `name` varchar(255) NOT NULL,
                         `email` varchar(255) NOT NULL,
                         `email_verified_at` timestamp NULL DEFAULT NULL,
                         `password` varchar(255) NOT NULL,
                         `remember_token` varchar(100) DEFAULT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.mosques definition

CREATE TABLE `mosques` (
                           `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                           `user_id` bigint(20) unsigned NOT NULL,
                           `player_token` varchar(255) NOT NULL,
                           `logo_url` varchar(255) DEFAULT NULL,
                           `name` varchar(255) NOT NULL,
                           `email` varchar(255) DEFAULT NULL,
                           `phone` bigint(20) DEFAULT NULL,
                           `manager` varchar(255) DEFAULT NULL,
                           `address` varchar(255) DEFAULT NULL,
                           `city` varchar(255) DEFAULT NULL,
                           `province` varchar(255) DEFAULT NULL,
                           `postal_code` varchar(255) DEFAULT NULL,
                           `storage_path` varchar(255) DEFAULT NULL,
                           `marketing_campaign` tinyint(1) NOT NULL DEFAULT 0,
                           `hide_phone` tinyint(1) NOT NULL DEFAULT 0,
                           `created_at` timestamp NULL DEFAULT NULL,
                           `updated_at` timestamp NULL DEFAULT NULL,
                           `is_refresh` int(1) NOT NULL DEFAULT 0,
                           PRIMARY KEY (`id`),
                           UNIQUE KEY `mosques_player_token_unique` (`player_token`),
                           KEY `mosques_user_id_foreign` (`user_id`),
                           CONSTRAINT `mosques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.transactions definition

CREATE TABLE `transactions` (
                                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                `mosque_id` bigint(20) unsigned NOT NULL,
                                `amount` bigint(20) NOT NULL,
                                `direction` enum('debit','credit') NOT NULL,
                                `exchange` enum('nonmonetary','monetary') NOT NULL,
                                `description` varchar(255) NOT NULL,
                                `time` datetime NOT NULL,
                                `created_at` timestamp NULL DEFAULT NULL,
                                `updated_at` timestamp NULL DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                KEY `transactions_mosque_id_foreign` (`mosque_id`),
                                CONSTRAINT `transactions_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.videos definition

CREATE TABLE `videos` (
                          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                          `mosque_id` bigint(20) unsigned NOT NULL,
                          `path` varchar(255) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `created_at` timestamp NULL DEFAULT NULL,
                          `updated_at` timestamp NULL DEFAULT NULL,
                          PRIMARY KEY (`id`),
                          KEY `videos_mosque_id_foreign` (`mosque_id`),
                          CONSTRAINT `videos_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.config_player_intervals definition

CREATE TABLE `config_player_intervals` (
                                           `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                           `mosque_id` bigint(20) unsigned NOT NULL,
                                           `interval_friday` double(8,2) NOT NULL DEFAULT 40.00,
  `interval_lecture` double(8,2) NOT NULL DEFAULT 1.00,
  `interval_transaction` double(8,2) NOT NULL DEFAULT 1.00,
  `interval_image` double(8,2) NOT NULL DEFAULT 1.00,
  `interval_video` double(8,2) NOT NULL DEFAULT 1.00,
  `interval_slider` double(8,2) NOT NULL DEFAULT 0.10,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `config_player_intervals_mosque_id_foreign` (`mosque_id`),
  CONSTRAINT `config_player_intervals_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.config_player_shows definition

CREATE TABLE `config_player_shows` (
                                       `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                       `mosque_id` bigint(20) unsigned NOT NULL,
                                       `show_main` tinyint(1) NOT NULL DEFAULT 1,
                                       `show_transaction` tinyint(1) NOT NULL DEFAULT 0,
                                       `show_lecture` tinyint(1) NOT NULL DEFAULT 0,
                                       `show_video` tinyint(1) NOT NULL DEFAULT 0,
                                       `show_image` tinyint(1) NOT NULL DEFAULT 0,
                                       `created_at` timestamp NULL DEFAULT NULL,
                                       `updated_at` timestamp NULL DEFAULT NULL,
                                       PRIMARY KEY (`id`),
                                       KEY `config_player_shows_mosque_id_foreign` (`mosque_id`),
                                       CONSTRAINT `config_player_shows_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.config_players definition

CREATE TABLE `config_players` (
                                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                  `mosque_id` bigint(20) unsigned NOT NULL,
                                  `background_before_adzan` varchar(255) DEFAULT NULL,
                                  `background_iqama_time` varchar(255) DEFAULT NULL,
                                  `background_prayer_silent` varchar(255) DEFAULT NULL,
                                  `background_lecture` varchar(255) DEFAULT NULL,
                                  `background_transaction` varchar(255) DEFAULT NULL,
                                  `with_imsak` tinyint(1) NOT NULL DEFAULT 0,
                                  `with_syuruq` tinyint(1) NOT NULL DEFAULT 0,
                                  `calculation_method` varchar(255) DEFAULT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `config_players_mosque_id_foreign` (`mosque_id`),
                                  CONSTRAINT `config_players_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.config_prayers definition

CREATE TABLE `config_prayers` (
                                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                  `mosque_id` bigint(20) unsigned NOT NULL,
                                  `name` varchar(255) NOT NULL,
                                  `box_background_class` varchar(255) NOT NULL,
                                  `is_prayer_time` tinyint(1) NOT NULL DEFAULT 1,
                                  `time_adjustment` int(11) NOT NULL DEFAULT 0,
                                  `before_adzan_interval` int(11) NOT NULL DEFAULT 5,
                                  `iqama_interval` int(11) NOT NULL DEFAULT 5,
                                  `prayer_interval` int(11) NOT NULL DEFAULT 5,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  `key` varchar(20) NOT NULL,
                                  `order` int(2) NOT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `config_prayers_mosque_id_foreign` (`mosque_id`),
                                  CONSTRAINT `config_prayers_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.configurations definition

CREATE TABLE `configurations` (
                                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                                  `mosque_id` bigint(20) unsigned NOT NULL,
                                  `meta` varchar(255) NOT NULL,
                                  `value` varchar(255) NOT NULL,
                                  `created_at` timestamp NULL DEFAULT NULL,
                                  `updated_at` timestamp NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  KEY `configurations_mosque_id_foreign` (`mosque_id`),
                                  CONSTRAINT `configurations_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.files definition

CREATE TABLE `files` (
                         `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                         `mosque_id` bigint(20) unsigned NOT NULL,
                         `is_template` tinyint(1) NOT NULL DEFAULT 0,
                         `type` enum('image','background','video') NOT NULL,
                         `path` varchar(255) NOT NULL,
                         `name` varchar(255) NOT NULL,
                         `created_at` timestamp NULL DEFAULT NULL,
                         `updated_at` timestamp NULL DEFAULT NULL,
                         `start_date` datetime DEFAULT NULL,
                         `end_date` datetime DEFAULT NULL,
                         `status` varchar(1) NOT NULL DEFAULT '1',
                         `mimetype` varchar(30) DEFAULT NULL,
                         PRIMARY KEY (`id`),
                         KEY `files_mosque_id_foreign` (`mosque_id`),
                         CONSTRAINT `files_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.images definition

CREATE TABLE `images` (
                          `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                          `mosque_id` bigint(20) unsigned NOT NULL,
                          `path` varchar(255) NOT NULL,
                          `name` varchar(255) NOT NULL,
                          `created_at` timestamp NULL DEFAULT NULL,
                          `updated_at` timestamp NULL DEFAULT NULL,
                          `start_date` datetime(6) DEFAULT NULL,
                          `end_date` datetime(6) DEFAULT NULL,
                          `status` varchar(1) NOT NULL DEFAULT '1',
                          PRIMARY KEY (`id`),
                          KEY `images_mosque_id_foreign` (`mosque_id`),
                          CONSTRAINT `images_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.lectures definition

CREATE TABLE `lectures` (
                            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                            `mosque_id` bigint(20) unsigned NOT NULL,
                            `topic` varchar(255) NOT NULL,
                            `description` varchar(255) NOT NULL,
                            `speaker` varchar(255) NOT NULL,
                            `time` datetime NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            `display_start_time` datetime DEFAULT NULL,
                            `display_end_time` datetime DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `lectures_mosque_id_foreign` (`mosque_id`),
                            CONSTRAINT `lectures_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- layr1858_masjid.marquees definition

CREATE TABLE `marquees` (
                            `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                            `mosque_id` bigint(20) unsigned NOT NULL,
                            `content` varchar(255) NOT NULL,
                            `created_at` timestamp NULL DEFAULT NULL,
                            `updated_at` timestamp NULL DEFAULT NULL,
                            PRIMARY KEY (`id`),
                            KEY `marquees_mosque_id_foreign` (`mosque_id`),
                            CONSTRAINT `marquees_mosque_id_foreign` FOREIGN KEY (`mosque_id`) REFERENCES `mosques` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
