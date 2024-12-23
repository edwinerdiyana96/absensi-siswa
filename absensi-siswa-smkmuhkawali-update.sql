-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Des 2024 pada 15.07
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi-siswa-smkmuhkawali`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_device`
--

CREATE TABLE `data_device` (
  `device_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `update` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_geolocation`
--

CREATE TABLE `data_geolocation` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `place_id` varchar(255) NOT NULL,
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_holiday`
--

CREATE TABLE `data_holiday` (
  `id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jarak`
--

CREATE TABLE `data_jarak` (
  `id` int(11) NOT NULL,
  `jarak` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_jarak`
--

INSERT INTO `data_jarak` (`id`, `jarak`, `status`) VALUES
(1, 500000, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `qr`
--

CREATE TABLE `qr` (
  `id` int(11) NOT NULL,
  `qr_token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `qr`
--

INSERT INTO `qr` (`id`, `qr_token`) VALUES
(13, 'sRhQbdvfz1nATimTnx7g');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) NOT NULL,
  `sampul` longtext NOT NULL,
  `logo` longtext NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `token_telegram` longtext NOT NULL,
  `bot_telegram` text NOT NULL,
  `address` longtext NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `maps_enabled` int(11) NOT NULL,
  `uuid_enabled` int(11) NOT NULL,
  `metode_laporan` varchar(50) NOT NULL,
  `bg-qrcode` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `sampul`, `logo`, `name`, `phone`, `token_telegram`, `bot_telegram`, `address`, `latitude`, `longitude`, `maps_enabled`, `uuid_enabled`, `metode_laporan`, `bg-qrcode`) VALUES
(1, 'assets/images/sampul.jpg', 'assets/images/profile.jpg', 'SMK Muhammadiyah Kawali', '', 'AAH7GGErG1xLb9mxhAx9KOJlLtQxMxQ0NEw', 'bot5962774962', 'l. Poronggol Raya No.18, Kawalimukti, Kec. Kawali, Kabupaten Ciamis, Jawa Barat 46253', '-7.1871632', '108.3655518', 0, 0, 'Whatsapp', 'assets/images/qr-template/QR-TEMPLATE4.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_attendance`
--

CREATE TABLE `student_attendance` (
  `attendance_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `month` varchar(35) NOT NULL,
  `time` time NOT NULL,
  `status` int(11) NOT NULL,
  `description` text NOT NULL,
  `class` varchar(255) NOT NULL,
  `waktu_siswa_pulang` time NOT NULL,
  `status_siswa_pulang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_class`
--

CREATE TABLE `student_class` (
  `class_id` bigint(20) NOT NULL,
  `class` varchar(50) NOT NULL,
  `homeroom_teacher` bigint(20) NOT NULL,
  `class_leader` bigint(20) NOT NULL,
  `vice_leader` bigint(20) NOT NULL,
  `grade` varchar(11) NOT NULL,
  `status` varchar(150) NOT NULL,
  `kode_group` text NOT NULL,
  `kode_group_grade` longtext NOT NULL,
  `chat_id` text NOT NULL,
  `chat_id_angkatan` text NOT NULL,
  `group_laporan_angkatan` longtext NOT NULL,
  `no_whatsapp_grade` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_lessons`
--

CREATE TABLE `student_lessons` (
  `mapel_id` int(11) NOT NULL,
  `lessons` text NOT NULL,
  `grade` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_parent`
--

CREATE TABLE `student_parent` (
  `id` bigint(20) NOT NULL,
  `nis` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `student_parent`
--

INSERT INTO `student_parent` (`id`, `nis`, `name`, `phone`, `password`) VALUES
(2, 192010029191, '0', '083199766610', 'password');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_picture`
--

CREATE TABLE `student_picture` (
  `id` bigint(20) NOT NULL,
  `student_attendance` bigint(20) NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `student_picture`
--

INSERT INTO `student_picture` (`id`, `student_attendance`, `image`) VALUES
(1, 18407, 'image_1675298087.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_room`
--

CREATE TABLE `student_room` (
  `room_id` bigint(20) NOT NULL,
  `no` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `pic` bigint(20) NOT NULL,
  `qr_token` longtext NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'Normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_room_absent`
--

CREATE TABLE `student_room_absent` (
  `student_room_id` bigint(20) NOT NULL,
  `room_history_id` bigint(20) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `lessons_id` bigint(20) NOT NULL,
  `tanggal` date NOT NULL,
  `time` time NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `student_room_history`
--

CREATE TABLE `student_room_history` (
  `id` bigint(20) NOT NULL,
  `room_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `class` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `is_done` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `teacher_lessons`
--

CREATE TABLE `teacher_lessons` (
  `teacher_lessons_id` bigint(20) NOT NULL,
  `lessons_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `time_attendance`
--

CREATE TABLE `time_attendance` (
  `id` int(11) NOT NULL,
  `time_schedule` varchar(128) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `time_attendance`
--

INSERT INTO `time_attendance` (`id`, `time_schedule`, `time_start`, `time_end`) VALUES
(1, 'Jam Masuk', '03:00:00', '09:20:00'),
(2, 'Jam Telat', '09:21:00', '14:00:00'),
(3, 'Jam Pulang', '14:01:00', '18:59:00'),
(4, 'Jam Istirahat', '10:00:00', '10:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `department` varchar(256) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `address` text NOT NULL,
  `is_flexible` int(11) NOT NULL DEFAULT 0,
  `view_sakit` int(11) NOT NULL,
  `view_izin` int(11) NOT NULL,
  `view_alpha` int(11) NOT NULL,
  `view_pkl` int(11) NOT NULL,
  `view_bolos` int(11) NOT NULL,
  `view_hadir` int(11) NOT NULL,
  `view_dispensasi` int(11) NOT NULL,
  `view_tugas` int(11) NOT NULL,
  `view_tidak_hadir` int(11) NOT NULL,
  `view_persentase` decimal(10,2) NOT NULL,
  `qr_code` varchar(125) NOT NULL,
  `uuid` longtext NOT NULL,
  `is_pkl` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `date_created`, `department`, `class_name`, `phone`, `gender`, `address`, `is_flexible`, `view_sakit`, `view_izin`, `view_alpha`, `view_pkl`, `view_bolos`, `view_hadir`, `view_dispensasi`, `view_tugas`, `view_tidak_hadir`, `view_persentase`, `qr_code`, `uuid`, `is_pkl`) VALUES
(1, 'Administrator Sistem Absensi', 'admin@gmail.com', 'LOGO_SMK_MUHAMMADIYAH_KAWALI.png', '$2y$10$jO2/FIjBMAfw.vTclVKMDe3NFlypJrShKBHQmQIYgZE.Kooiy.zbq', 1, 1, '0000-00-00 00:00:00', 'superadmin', '', '083823237979', 'L', 'Jl. Poronggol Raya No.18, Kawalimukti, Kec. Kawali, Kabupaten Ciamis, Jawa Barat 46253', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0.00', 'OK', '', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 1),
(49, 1, 2),
(50, 1, 3),
(51, 1, 6),
(53, 2, 2),
(55, 1, 9),
(56, 1, 10),
(57, 1, 11),
(58, 15, 14),
(59, 1, 12),
(60, 1, 13),
(61, 1, 14),
(63, 3, 15),
(69, 4, 18),
(70, 5, 19),
(71, 5, 20),
(72, 17, 20),
(73, 2, 20),
(75, 1, 18),
(77, 1, 20),
(78, 1, 19),
(79, 3, 20),
(83, 24, 20),
(84, 3, 23),
(86, 1, 24),
(87, 1, 25),
(88, 1, 26),
(89, 1, 27),
(90, 6, 27),
(91, 7, 17),
(93, 4, 25),
(94, 5, 25),
(95, 28, 26),
(96, 29, 25),
(97, 30, 25),
(99, 38, 29),
(100, 1, 17),
(102, 39, 27),
(103, 29, 23),
(105, 30, 23),
(106, 5, 23),
(107, 28, 23),
(108, 28, 25),
(109, 3, 30),
(112, 1, 23),
(113, 1, 29),
(118, 1, 30),
(119, 7, 23);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(1, 'Administrator'),
(3, 'Menu Management'),
(6, 'User Management'),
(17, 'Operator'),
(23, 'Guru'),
(25, 'Laporan'),
(26, 'BK'),
(27, 'Siswa'),
(29, 'Ortu'),
(30, 'Wali Kelas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'superadmin'),
(2, 'Staff'),
(3, 'Guru'),
(4, 'Kepala Sekolah'),
(5, 'Wakil Kepala Sekolah'),
(6, 'Siswa'),
(7, 'Operator'),
(28, 'Bimbingan Konseling'),
(29, 'Manajer Kesiswaan'),
(30, 'Manajer Kurikulum'),
(38, 'Orang Tua'),
(39, 'Demo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_status`
--

CREATE TABLE `user_status` (
  `id` int(11) NOT NULL,
  `name` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_status`
--

INSERT INTO `user_status` (`id`, `name`) VALUES
(0, 'Belum Absen / Alfa'),
(1, 'Hadir Tepat Waktu'),
(2, 'Hadir Telat'),
(3, 'Sakit'),
(4, 'Izin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`) VALUES
(1, 1, 'Dashboard', 'admin', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 1),
(2, 2, 'My Profile', 'user', '<i class=\"fas fa-user\"></i>', 1),
(3, 2, 'Edit Profile', 'user/edit', '<i class=\"fas fa-user-edit\"></i>', 1),
(4, 3, 'Menu Management', 'menu', '<i class=\"fas fa-folder\"></i>', 1),
(5, 3, 'Submenu Management', 'menu/submenu', '<i class=\"fas fa-folder-minus\"></i>', 1),
(9, 1, 'Role', 'admin/role', '<i class=\"fas fa-user-cog\"></i>', 1),
(10, 2, 'Change Password', 'user/changepassword', '<i class=\"fas fa-key\"></i>', 1),
(11, 6, 'Manage User', 'admin/manage', '<i class=\"fas fa-users-cog\"></i>', 1),
(17, 9, 'Manage Sosmed', 'sosmed/', '<i class=\"fas fa-thumbs-up\"></i>', 1),
(18, 10, 'Manage Mitra', 'mitra', '<i class=\"fas fa-building\"></i>', 1),
(19, 11, 'Manage Service', 'service/index', '<i class=\"fas fa-users-cog\"></i>', 1),
(20, 11, 'Add Service', 'service/addService', '<i class=\"fas fa-plus-square\"></i>', 1),
(21, 15, 'Data Keuangan', '#', '<i class=\"fas fa-fw fa-folder\"></i>', 1),
(22, 17, 'Dashboard', 'operator', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 1),
(27, 18, 'Dashboard', 'kepsek', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 1),
(28, 18, 'Rekap Absen', 'absensi/rekap', '<i class=\"fas fa-folder\"></i>', 1),
(29, 19, 'Dashboard', 'wakasek', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 1),
(30, 19, 'Rekap Absen', 'absensi/rekap', '<i class=\"fas fa-folder\"></i>', 1),
(31, 20, 'Dashboard', 'user', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 1),
(32, 20, 'Scan QR', 'pegawai/scan', '<i class=\"fas fa-folder\"></i>', 1),
(33, 20, 'Rekap Absen', 'pegawai/rekap', '<i class=\"fas fa-folder\"></i>', 1),
(34, 17, ' Data Guru', 'operator/guru', '<i class=\"fa fa-users\" aria-hidden=\"true\"></i>', 1),
(35, 1, 'QR Code', 'admin/qr', '<i class=\"fas fa-folder\"></i>', 1),
(37, 1, 'Geolocation', 'admin/geolocation', '<i class=\"fas fa-folder\"></i>', 1),
(39, 18, 'Kehadiran', 'operator/kehadiran', '<i class=\"fas fa-folder\"></i>', 1),
(40, 19, 'Kehadiran', 'operator/kehadiran', '<i class=\"fas fa-folder\"></i>', 1),
(42, 20, 'KetidakHadiran', 'pegawai/ketidakhadiran', '<i class=\"fas fa-folder\"></i>', 1),
(43, 17, 'Data Siswa', 'operator/siswa', '<i class=\"fas fa-users\"></i>', 1),
(44, 23, 'Dashboard Guru', 'guru', '<i class=\"fa fa-home\" aria-hidden=\"true\"></i>', 1),
(45, 30, 'Rekap Absensi Siswa', 'guru/rekap', '<i class=\"fa fa-book\" aria-hidden=\"true\"></i>', 1),
(46, 24, 'Dashboard', 'ruangan/index', '<i class=\"fas fa-folder\"></i>', 1),
(48, 26, 'Data Siswa', 'bk/index', '<i class=\"fas fa-folder\"></i>', 1),
(49, 25, 'Dashboard', 'laporan/index', '<i class=\"fas fa-folder\"></i>', 1),
(51, 24, 'Data Ruangan', 'ruangan/data_ruangan', '<i class=\"fas fa-folder\"></i>', 1),
(52, 17, 'Data Kelas', 'operator/kelas', '<i class=\"fas fa-folder\"></i>', 1),
(53, 27, 'Dashboard', 'siswa', '<i class=\"fa fa-home\" aria-hidden=\"true\"></i>', 1),
(54, 27, 'Rekap Absen', 'siswa/rekap_absen', '<i class=\"fa fa-bar-chart\"></i>', 1),
(55, 17, 'Data Ruangan', 'operator/ruangan', '<i class=\"fas fa-folder\"></i>', 1),
(56, 17, 'Data Mapel', 'operator/mapel', '<i class=\"fas fa-folder\"></i>', 1),
(57, 17, 'Rekap Absensi Siswa', 'operator/rekap', '<i class=\"fa fa-bar-chart\"></i>', 1),
(59, 26, 'Siswa Telat', 'bk/siswa_telat', '<i class=\"fas fa-fw fa-folder\"></i>', 1),
(60, 23, 'Histori Absensi Harian', 'guru/room_teacher', '<i class=\"fa fa-history\" aria-hidden=\"true\"></i>', 1),
(61, 1, 'Auto', 'auto/', '<i class=\"fas fa-folder\"></i>', 1),
(62, 1, 'Jam Absensi', 'operator/jam_absensi', '<i class=\"fas fa-folder\"></i>', 1),
(63, 25, 'Rekap Absen', 'operator/rekap', '<i class=\"fa fa-bar-chart\"></i>', 1),
(64, 29, 'Dashboard', 'ortu/dashboard', '<i class=\"fas fa-folder\"></i>', 1),
(65, 29, 'Rekap Absen', 'ortu/rekap_absen', '<i class=\"fa fa-bar-chart\"></i>', 1),
(66, 23, 'Scan QR Code Siswa', 'guru/absensi_pusat', '<i class=\"fa fa-camera\" aria-hidden=\"true\"></i>', 0),
(67, 17, 'Laporan Absensi Pusat', 'operator/laporan_absen_pusat', '<i class=\"fas fa-folder\"></i>', 1),
(115, 17, 'Pengaturan Jarak Absensi', 'operator/jarak', '<i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i>', 1),
(116, 27, 'Generate QR Code', 'siswa/qrcode', '<i class=\"fa fa-qrcode\" aria-hidden=\"true\"></i>', 1),
(117, 17, 'KIRIM KE TELEGRAM', 'telegram/', '<i class=\"fa fa-telegram\" aria-hidden=\"true\"></i>', 0),
(118, 23, 'Data Mata Pelajaran', 'guru/mapel', '<i class=\"fas fa-folder\"></i>', 1),
(119, 17, 'Data Grup WhatsApp', 'operator/group', '<i class=\"fas fa-folder\"></i>', 1),
(120, 17, 'Kirim Total Data Alpa Per Tingkat', 'operator/angkatan', '<i class=\"fa fa-whatsapp\" aria-hidden=\"true\"></i>', 1),
(121, 1, 'Pengaturan', 'admin/settings', '<i class=\"fa fa-cog\" aria-hidden=\"true\"></i>', 1),
(122, 1, 'Pengaturan Api', 'admin/settings_api', '<i class=\"fa fa-cog\" aria-hidden=\"true\"></i>', 1),
(123, 17, 'Update Data Absensi Siswa Per Hari', 'operator/absen_siswa', '<i class=\"fa fa-file\" aria-hidden=\"true\"></i>', 1),
(124, 30, 'Update Data Absensi', 'guru/absensi_kelas', '<i class=\"fa fa-check\" aria-hidden=\"true\"></i>', 1),
(125, 17, 'Grup WhatsApp Proses KBM Per Tingkat', 'operator/group_laporan', '<i class=\"fa fa-whatsapp\" aria-hidden=\"true\"></i>', 1),
(126, 23, 'Histori Absensi Per Bulan', 'guru/histori_bulanan', '<i class=\"fa fa-history\" aria-hidden=\"true\"></i>', 1),
(127, 17, 'Absensi Libur', 'operator/absen_libur', '<i class=\"fas fa-calendar\"></i>', 1),
(128, 17, 'Laporan Harian Kesiswaan', 'operator/laphar', '<i class=\"fa fa-whatsapp\" aria-hidden=\"true\"></i>', 1),
(129, 30, 'Kelola Data Siswa', 'guru/data_siswa', '<i class=\"fas fa-users-cog\"></i>', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_device`
--
ALTER TABLE `data_device`
  ADD PRIMARY KEY (`device_id`);

--
-- Indeks untuk tabel `data_geolocation`
--
ALTER TABLE `data_geolocation`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_holiday`
--
ALTER TABLE `data_holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_jarak`
--
ALTER TABLE `data_jarak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `qr`
--
ALTER TABLE `qr`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `student_class`
--
ALTER TABLE `student_class`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `class` (`class`);

--
-- Indeks untuk tabel `student_lessons`
--
ALTER TABLE `student_lessons`
  ADD PRIMARY KEY (`mapel_id`);

--
-- Indeks untuk tabel `student_parent`
--
ALTER TABLE `student_parent`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `student_picture`
--
ALTER TABLE `student_picture`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `student_room`
--
ALTER TABLE `student_room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indeks untuk tabel `student_room_absent`
--
ALTER TABLE `student_room_absent`
  ADD PRIMARY KEY (`student_room_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_history_id` (`room_history_id`),
  ADD KEY `lessons_id` (`lessons_id`);

--
-- Indeks untuk tabel `student_room_history`
--
ALTER TABLE `student_room_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indeks untuk tabel `teacher_lessons`
--
ALTER TABLE `teacher_lessons`
  ADD PRIMARY KEY (`teacher_lessons_id`),
  ADD KEY `lessons_id` (`lessons_id`);

--
-- Indeks untuk tabel `time_attendance`
--
ALTER TABLE `time_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_device`
--
ALTER TABLE `data_device`
  MODIFY `device_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_geolocation`
--
ALTER TABLE `data_geolocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `data_holiday`
--
ALTER TABLE `data_holiday`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT untuk tabel `data_jarak`
--
ALTER TABLE `data_jarak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `qr`
--
ALTER TABLE `qr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `attendance_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=810844;

--
-- AUTO_INCREMENT untuk tabel `student_class`
--
ALTER TABLE `student_class`
  MODIFY `class_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `student_lessons`
--
ALTER TABLE `student_lessons`
  MODIFY `mapel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT untuk tabel `student_parent`
--
ALTER TABLE `student_parent`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `student_picture`
--
ALTER TABLE `student_picture`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `student_room`
--
ALTER TABLE `student_room`
  MODIFY `room_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT untuk tabel `student_room_absent`
--
ALTER TABLE `student_room_absent`
  MODIFY `student_room_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=843601;

--
-- AUTO_INCREMENT untuk tabel `student_room_history`
--
ALTER TABLE `student_room_history`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9626;

--
-- AUTO_INCREMENT untuk tabel `teacher_lessons`
--
ALTER TABLE `teacher_lessons`
  MODIFY `teacher_lessons_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT untuk tabel `time_attendance`
--
ALTER TABLE `time_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16666;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
