CREATE TABLE `email_setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `main_email` varchar(255) DEFAULT NULL,
  `email_name` varchar(255) DEFAULT NULL,
  `logo` text,
  `thumbnail_logo` text,
  `social_media` text,
  `subject_email` varchar(150) DEFAULT NULL,
  `body_email_to` text,
  `email_received` varchar(150) DEFAULT NULL,
  `body_email_received` text,
  `email_cc` text COMMENT 'Jika Email CC leih dari satu pastikan String memakai koma. EX: ''email_1@gmail.com,email_2@gmail.com''''',
  `reply_to_email` varchar(255) DEFAULT NULL,
  `reply_to_email_name` varchar(255) DEFAULT NULL,
  `mail_type` varchar(50) DEFAULT NULL,
  `protocol` varchar(50) DEFAULT NULL,
  `host` varchar(225) DEFAULT NULL,
  `username` varchar(225) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `port` int DEFAULT NULL,
  `charset` varchar(100) DEFAULT NULL,
  `timeout` int DEFAULT NULL,
  `validation` enum('TRUE','FALSE') DEFAULT NULL,
  `wordwrap` enum('TRUE','FALSE') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `createBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

/*Data for the table `email_setting` */

insert  into `email_setting`(`id`,`main_email`,`email_name`,`logo`,`thumbnail_logo`,`social_media`,`subject_email`,`body_email_to`,`email_received`,`body_email_received`,`email_cc`,`reply_to_email`,`reply_to_email_name`,`mail_type`,`protocol`,`host`,`username`,`password`,`port`,`charset`,`timeout`,`validation`,`wordwrap`,`status`,`createDate`,`createBy`,`updateDate`,`updateBy`) values 
(1,'Support@Yandaaa.com','Support Yandaaa','34906-apple-touch-icon.png','thumbnails/thumb-34906-apple-touch-icon.png','[]','Support Yandaaa.com','<p>Terima Kasih telah menghubungi kami, pesan kamu telah kami terima dan kami akan menghubungi kamu dalam 1x24 jam.<br></p>','iryanda_syamputra@yahoo.com','<p>Anda mendapatkan 1 email baru !<br></p>','iryandasyamputra@gmail.com,mrxfox1535@gmail.com','help@yandaaa.com','Help Care Yandaaa.com','html','smtp','mail.yandaaa.com','support@yandaaa.com','yandaaaCom-support-171835',587,'utf-8',10,'TRUE','TRUE','active','2021-12-24 12:37:52',NULL,'2022-01-14 14:47:33',3);

/*Table structure for table `formulir_skripsi` */


CREATE TABLE `formulir_skripsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nim` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `skripsi_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lembar_tugas_or_konsultasi_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `semester` int DEFAULT NULL,
  `status` enum('0','1','2','3','4','5','6','7','8') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `formulir_skripsi` */

insert  into `formulir_skripsi`(`id`,`nama`,`nim`,`judul`,`skripsi_files`,`lembar_tugas_or_konsultasi_files`,`semester`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,'Aldian Putra',2023000123,'SKRIPSI Aldian','84200-buku_ajar_analisa_sistem_informasi.pdf','26990-ANALISA-PERANCANGAN-SISTEM-INFORMASI.pdf',6,'3',5,'2023-08-14 02:14:28',8,'2023-08-14 02:18:03');

/*Table structure for table `formulir_sup` */


CREATE TABLE `formulir_sup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nim` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `proposal_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `lembar_tugas_or_konsultasi_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `semester` int DEFAULT NULL,
  `status` enum('0','1','2','3','4','5','6','7','8') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `formulir_sup` */

insert  into `formulir_sup`(`id`,`nama`,`nim`,`judul`,`proposal_files`,`lembar_tugas_or_konsultasi_files`,`semester`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,'Aldian Putra',2023000123,'SUP ALdian','38361-Brosur-Sarjana-dan-Terapan.pdf','13937-Brosur-Sarjana-dan-Terapan.pdf',6,'4',5,'2023-08-14 01:52:51',9,'2023-08-14 02:13:36');

/*Table structure for table `formulir_uji_kelayakan` */

CREATE TABLE `formulir_uji_kelayakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nim` int NOT NULL,
  `judul` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `semester` int DEFAULT NULL,
  `status` enum('0','1','2','3','4','5','6','7','8') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `formulir_uji_kelayakan` */

insert  into `formulir_uji_kelayakan`(`id`,`nama`,`nim`,`judul`,`files`,`semester`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,'Aldian Putra',2023000123,'Uji Kelayakan Aldian','4326-Brosur-Sarjana-dan-Terapan.pdf',6,'7',5,'2023-08-13 01:04:30',8,'2023-08-13 01:10:13');

/*Table structure for table `input_jadwal_skripsi` */


CREATE TABLE `input_jadwal_skripsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formulir_skripsi_id` int NOT NULL,
  `dosen_id` int DEFAULT NULL,
  `mahasiswa_id` int DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tempat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_akhir` time DEFAULT NULL,
  `keterangan` text,
  `status` enum('0','1') DEFAULT '0',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `input_jadwal_skripsi` */

insert  into `input_jadwal_skripsi`(`id`,`formulir_skripsi_id`,`dosen_id`,`mahasiswa_id`,`judul`,`tempat`,`tanggal`,`waktu_mulai`,`waktu_akhir`,`keterangan`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,1,NULL,5,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL),
(2,1,15,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL),
(3,1,16,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL),
(4,1,10,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL),
(5,1,4,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL),
(6,1,12,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL);
insert  into `input_jadwal_skripsi`(`id`,`formulir_skripsi_id`,`dosen_id`,`mahasiswa_id`,`judul`,`tempat`,`tanggal`,`waktu_mulai`,`waktu_akhir`,`keterangan`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(7,1,11,NULL,'SKRIPSI Aldian','Gedung Alua','2023-08-14','14:00:00','15:00:00','TEST Keterangan SKRIPSI','0',8,'2023-08-14 02:18:03',NULL,NULL);

/*Table structure for table `input_jadwal_sup` */


CREATE TABLE `input_jadwal_sup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formulir_sup_id` int NOT NULL,
  `dosen_id` int DEFAULT NULL,
  `mahasiswa_id` int DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tempat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_akhir` time DEFAULT NULL,
  `keterangan` text,
  `status` enum('0','1') DEFAULT '0',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `input_jadwal_sup` */

insert  into `input_jadwal_sup`(`id`,`formulir_sup_id`,`dosen_id`,`mahasiswa_id`,`judul`,`tempat`,`tanggal`,`waktu_mulai`,`waktu_akhir`,`keterangan`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,1,NULL,5,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','0',8,'2023-08-14 02:03:42',NULL,NULL),
(2,1,15,NULL,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','1',8,'2023-08-14 02:03:42',15,'2023-08-14 02:09:44'),
(3,1,9,NULL,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','1',8,'2023-08-14 02:03:42',9,'2023-08-14 02:13:36'),
(4,1,4,NULL,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','1',8,'2023-08-14 02:03:42',4,'2023-08-14 02:10:44'),
(5,1,12,NULL,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','1',8,'2023-08-14 02:03:42',12,'2023-08-14 02:11:29'),
(6,1,11,NULL,'SUP ALdian','Gedung Alua','2023-08-14','09:00:00','10:00:00','Test Keterangan SUP','1',8,'2023-08-14 02:03:42',11,'2023-08-14 02:12:33');

/*Table structure for table `input_jadwal_uji_kelayakan` */


CREATE TABLE `input_jadwal_uji_kelayakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formulir_uji_kelayakan_id` int NOT NULL,
  `dosen_id` int DEFAULT NULL,
  `mahasiswa_id` int DEFAULT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tempat` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `tanggal_dan_waktu` datetime NOT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `input_jadwal_uji_kelayakan` */

/*Table structure for table `input_nilai` */



CREATE TABLE `input_nilai` (
  `id` int NOT NULL AUTO_INCREMENT,
  `input_jadwal_id` int NOT NULL,
  `input_jadwal_type` enum('sup','skripsi') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dosen_id` int NOT NULL,
  `mahasiswa_id` int NOT NULL,
  `catatan` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `kesimpulan` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `instrument_data` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `input_nilai` */

insert  into `input_nilai`(`id`,`input_jadwal_id`,`input_jadwal_type`,`dosen_id`,`mahasiswa_id`,`catatan`,`kesimpulan`,`instrument_data`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,2,'sup',15,5,'Catatan 1','Layak','[{\"element_name\":\"tata_tulis_laporan\",\"element_value\":\"80\"},{\"element_name\":\"kediaman_dan_keluasan\",\"element_value\":\"75\"},{\"element_name\":\"relevansi_teori\",\"element_value\":\"90\"},{\"element_name\":\"argumentasi_teoritis\",\"element_value\":\"75\"},{\"element_name\":\"instrument_penelitian\",\"element_value\":\"100\"},{\"element_name\":\"orisinalitas\",\"element_value\":\"80\"},{\"element_name\":\"penugasaan_proposal_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"penyajian_materi_penggunaan_bahasa\",\"element_value\":\"80\"},{\"total_all_instrument_iput\":\"835\",\"nilai_akhir_nu\":\"A-\",\"total_nilai_value\":84}]',15,'2023-08-14 02:09:44',NULL,NULL);
insert  into `input_nilai`(`id`,`input_jadwal_id`,`input_jadwal_type`,`dosen_id`,`mahasiswa_id`,`catatan`,`kesimpulan`,`instrument_data`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(2,4,'sup',4,5,'Catatan 2','Layak','[{\"element_name\":\"tata_tulis_laporan\",\"element_value\":\"80\"},{\"element_name\":\"kediaman_dan_keluasan\",\"element_value\":\"75\"},{\"element_name\":\"relevansi_teori\",\"element_value\":\"90\"},{\"element_name\":\"argumentasi_teoritis\",\"element_value\":\"75\"},{\"element_name\":\"instrument_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"orisinalitas\",\"element_value\":\"80\"},{\"element_name\":\"penugasaan_proposal_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"penyajian_materi_penggunaan_bahasa\",\"element_value\":\"80\"},{\"total_all_instrument_iput\":\"795\",\"nilai_akhir_nu\":\"B+\",\"total_nilai_value\":80}]',4,'2023-08-14 02:10:44',NULL,NULL);
insert  into `input_nilai`(`id`,`input_jadwal_id`,`input_jadwal_type`,`dosen_id`,`mahasiswa_id`,`catatan`,`kesimpulan`,`instrument_data`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(3,5,'sup',12,5,'Catatan 3','Layak','[{\"element_name\":\"tata_tulis_laporan\",\"element_value\":\"80\"},{\"element_name\":\"kediaman_dan_keluasan\",\"element_value\":\"75\"},{\"element_name\":\"relevansi_teori\",\"element_value\":\"90\"},{\"element_name\":\"argumentasi_teoritis\",\"element_value\":\"75\"},{\"element_name\":\"instrument_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"orisinalitas\",\"element_value\":\"80\"},{\"element_name\":\"penugasaan_proposal_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"penyajian_materi_penggunaan_bahasa\",\"element_value\":\"80\"},{\"total_all_instrument_iput\":\"795\",\"nilai_akhir_nu\":\"B+\",\"total_nilai_value\":80}]',12,'2023-08-14 02:11:29',NULL,NULL);
insert  into `input_nilai`(`id`,`input_jadwal_id`,`input_jadwal_type`,`dosen_id`,`mahasiswa_id`,`catatan`,`kesimpulan`,`instrument_data`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(4,6,'sup',11,5,'Catatan 4','Layak','[{\"element_name\":\"tata_tulis_laporan\",\"element_value\":\"80\"},{\"element_name\":\"kediaman_dan_keluasan\",\"element_value\":\"75\"},{\"element_name\":\"relevansi_teori\",\"element_value\":\"90\"},{\"element_name\":\"argumentasi_teoritis\",\"element_value\":\"75\"},{\"element_name\":\"instrument_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"orisinalitas\",\"element_value\":\"80\"},{\"element_name\":\"penugasaan_proposal_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"penyajian_materi_penggunaan_bahasa\",\"element_value\":\"80\"},{\"total_all_instrument_iput\":\"795\",\"nilai_akhir_nu\":\"B+\",\"total_nilai_value\":80}]',11,'2023-08-14 02:12:33',NULL,NULL);
insert  into `input_nilai`(`id`,`input_jadwal_id`,`input_jadwal_type`,`dosen_id`,`mahasiswa_id`,`catatan`,`kesimpulan`,`instrument_data`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(5,3,'sup',9,5,'Catatan 5','Layak','[{\"element_name\":\"tata_tulis_laporan\",\"element_value\":\"80\"},{\"element_name\":\"kediaman_dan_keluasan\",\"element_value\":\"75\"},{\"element_name\":\"relevansi_teori\",\"element_value\":\"90\"},{\"element_name\":\"argumentasi_teoritis\",\"element_value\":\"75\"},{\"element_name\":\"instrument_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"orisinalitas\",\"element_value\":\"80\"},{\"element_name\":\"penugasaan_proposal_penelitian\",\"element_value\":\"80\"},{\"element_name\":\"penyajian_materi_penggunaan_bahasa\",\"element_value\":\"80\"},{\"total_all_instrument_iput\":\"795\",\"nilai_akhir_nu\":\"B+\",\"total_nilai_value\":80}]',9,'2023-08-14 02:13:36',NULL,NULL);

/*Table structure for table `master_semester` */


CREATE TABLE `master_semester` (
  `id` int NOT NULL AUTO_INCREMENT,
  `angkatan` int NOT NULL,
  `dari_tahun` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `sampai_tahun` varchar(10) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `semester` int NOT NULL,
  `status` enum('1','2') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `master_semester` */

insert  into `master_semester`(`id`,`angkatan`,`dari_tahun`,`sampai_tahun`,`semester`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(6,119,'2023','2024',1,'1',3,'2023-08-07 00:22:30',NULL,NULL),
(7,119,'2023','2024',2,'1',3,'2023-08-07 00:22:30',NULL,NULL),
(8,120,'2025','2026',1,'2',3,'2023-08-07 18:57:45',3,'2023-08-07 19:01:03');

/*Table structure for table `messages` */
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `name` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `subject` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `ip_address` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `reading_status` enum('0','1','2') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '0' COMMENT '0 = Unread, 1 = Read',
  `browser_name` varchar(150) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `sendBy` int DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL,
  `action` enum('0','1') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL COMMENT '0 = Inbox, 1 = Sent',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `messages` */

insert  into `messages`(`id`,`uuid`,`name`,`email`,`subject`,`message`,`ip_address`,`user_agent`,`reading_status`,`browser_name`,`sendBy`,`sendDate`,`action`) values 
(1,'74a5db22-64ae-11ec-8ec1-6c4b905d0abf','Iryanda syamputra','iryandasyamputra@gmail.com','TESTING','<p>TESTING</p>\n','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36','1','Chrome',1,'2021-12-24 18:41:49','0'),
(2,'9840da16-64ae-11ec-8ec1-6c4b905d0abf','Iryanda syamputra','iryandasyamputra@gmail.com','TESTING','<p>TESTING</p>\n','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/96.0.4664.110 Safari/537.36','2','Chrome',1,'2021-12-24 18:42:49','1');

/*Table structure for table `penilaian_uji_kelayakan` */



CREATE TABLE `penilaian_uji_kelayakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uji_kelayakan_id` int NOT NULL,
  `dosen_id` int NOT NULL,
  `mahasiswa_id` int NOT NULL,
  `catatan_penilaian_kelayakan` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `kesimpulan` enum('1','2','3') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `kesimpulan_dengan_catatan` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` enum('1','2','3','4','5') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penilaian_uji_kelayakan` */

insert  into `penilaian_uji_kelayakan`(`id`,`uji_kelayakan_id`,`dosen_id`,`mahasiswa_id`,`catatan_penilaian_kelayakan`,`kesimpulan`,`kesimpulan_dengan_catatan`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,1,9,5,'layak','1','','1',9,'2023-08-13 01:06:37',NULL,NULL),
(2,1,4,5,'Layak','1','','1',4,'2023-08-13 01:07:06',NULL,NULL),
(3,1,10,5,'Layak','1','','1',10,'2023-08-13 01:07:29',NULL,NULL);

/*Table structure for table `penugasan_dosen_pembimbing_uji_kelayakan_judul` */


CREATE TABLE `penugasan_dosen_pembimbing_uji_kelayakan_judul` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kaprodi_id` int NOT NULL,
  `formulir_uji_kelayakan_id` int NOT NULL,
  `dosen_id` int NOT NULL,
  `type_penugasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `status` enum('0','1','2') DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penugasan_dosen_pembimbing_uji_kelayakan_judul` */

insert  into `penugasan_dosen_pembimbing_uji_kelayakan_judul`(`id`,`kaprodi_id`,`formulir_uji_kelayakan_id`,`dosen_id`,`type_penugasan`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,6,1,12,'pembimbing 2','2',6,'2023-08-13 01:08:35',8,'2023-08-13 01:10:13'),
(2,6,1,11,'pembimbing 1','2',6,'2023-08-13 01:08:35',8,'2023-08-13 01:10:13');

/*Table structure for table `penugasan_dosen_penguji_skripsi` */


CREATE TABLE `penugasan_dosen_penguji_skripsi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kaprodi_id` int NOT NULL,
  `formulir_skripsi_id` int NOT NULL,
  `dosen_id` int NOT NULL,
  `type_penugasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penugasan_dosen_penguji_skripsi` */

insert  into `penugasan_dosen_penguji_skripsi`(`id`,`kaprodi_id`,`formulir_skripsi_id`,`dosen_id`,`type_penugasan`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,6,1,15,'dosen ahli',6,'2023-08-14 02:15:37',NULL,NULL),
(2,6,1,16,'penguji luar',6,'2023-08-14 02:15:37',NULL,NULL),
(3,6,1,10,'seketaris',6,'2023-08-14 02:15:37',NULL,NULL),
(4,6,1,4,'ketua',6,'2023-08-14 02:15:37',NULL,NULL);

/*Table structure for table `penugasan_dosen_penguji_sup` */


CREATE TABLE `penugasan_dosen_penguji_sup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kaprodi_id` int NOT NULL,
  `formulir_sup_id` int NOT NULL,
  `dosen_id` int NOT NULL,
  `type_penugasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penugasan_dosen_penguji_sup` */

insert  into `penugasan_dosen_penguji_sup`(`id`,`kaprodi_id`,`formulir_sup_id`,`dosen_id`,`type_penugasan`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,6,1,15,'penguji luar',6,'2023-08-14 01:54:03',NULL,NULL),
(2,6,1,9,'anggota',6,'2023-08-14 01:54:03',NULL,NULL),
(3,6,1,4,'ketua',6,'2023-08-14 01:54:03',NULL,NULL);

/*Table structure for table `penugasan_dosen_penguji_uji_kelayakan` */


CREATE TABLE `penugasan_dosen_penguji_uji_kelayakan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kaprodi_id` int NOT NULL,
  `formulir_uji_kelayakan_id` int NOT NULL,
  `dosen_id` int NOT NULL,
  `type_penugasan` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `penugasan_dosen_penguji_uji_kelayakan` */

insert  into `penugasan_dosen_penguji_uji_kelayakan`(`id`,`kaprodi_id`,`formulir_uji_kelayakan_id`,`dosen_id`,`type_penugasan`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,6,1,10,'penguji kelayakan 3',6,'2023-08-13 01:04:59',NULL,NULL),
(2,6,1,9,'penguji kelayakan 2',6,'2023-08-13 01:04:59',NULL,NULL),
(3,6,1,4,'penguji kelayakan 1',6,'2023-08-13 01:04:59',NULL,NULL);

/*Table structure for table `surat_tugas` */


CREATE TABLE `surat_tugas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uji_kelayakan_id` int DEFAULT NULL,
  `mahasiswa_id` int NOT NULL,
  `assigment_from_user_id` int NOT NULL,
  `assigment_to_user_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `surat_tugas_to_mahasiswa_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `surat_tugas_to_dosen_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` enum('0','1','2','3','4','5') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `surat_tugas` */

insert  into `surat_tugas`(`id`,`uji_kelayakan_id`,`mahasiswa_id`,`assigment_from_user_id`,`assigment_to_user_id`,`judul`,`surat_tugas_to_mahasiswa_files`,`surat_tugas_to_dosen_files`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,1,5,8,5,'Uji Kelayakan Aldian','70551-buku_ajar_analisa_sistem_informasi.pdf',NULL,'5',8,'2023-08-13 01:05:43',8,'2023-08-13 01:10:13'),
(2,1,5,8,10,'Uji Kelayakan Aldian',NULL,'82839-ANALISA-PERANCANGAN-SISTEM-INFORMASI.pdf','2',8,'2023-08-13 01:05:43',10,'2023-08-13 01:07:29'),
(3,1,5,8,9,'Uji Kelayakan Aldian',NULL,'36693-Brosur-Sarjana-dan-Terapan.pdf','2',8,'2023-08-13 01:05:43',9,'2023-08-13 01:06:37'),
(4,1,5,8,4,'Uji Kelayakan Aldian',NULL,'72206-buku_ajar_analisa_sistem_informasi.pdf','2',8,'2023-08-13 01:05:43',4,'2023-08-13 01:07:06');

/*Table structure for table `surat_tugas_bimbingan` */


CREATE TABLE `surat_tugas_bimbingan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uji_kelayakan_id` int DEFAULT NULL,
  `mahasiswa_id` int NOT NULL,
  `assigment_from_user_id` int NOT NULL,
  `assigment_to_user_id` int NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `surat_tugas_to_mahasiswa_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `surat_tugas_to_dosen_files` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `status` enum('0','1','2','3','4','5') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '1',
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `surat_tugas_bimbingan` */

insert  into `surat_tugas_bimbingan`(`id`,`uji_kelayakan_id`,`mahasiswa_id`,`assigment_from_user_id`,`assigment_to_user_id`,`judul`,`surat_tugas_to_mahasiswa_files`,`surat_tugas_to_dosen_files`,`status`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(1,1,5,8,5,'Uji Kelayakan Aldian','43489-buku_ajar_analisa_sistem_informasi.pdf',NULL,'1',8,'2023-08-13 01:10:13',NULL,NULL),
(2,1,5,8,12,'Uji Kelayakan Aldian',NULL,'92448-ANALISA-PERANCANGAN-SISTEM-INFORMASI.pdf','1',8,'2023-08-13 01:10:13',NULL,NULL),
(3,1,5,8,11,'Uji Kelayakan Aldian',NULL,'72972-Brosur-Sarjana-dan-Terapan.pdf','1',8,'2023-08-13 01:10:13',NULL,NULL);

/*Table structure for table `user` */


CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `username` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(225) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `nim` int NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `uuid` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `last_login_agent` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `browser_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `is_online` enum('1','0') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '0' COMMENT '0 = Offline, 1 = Online',
  `status` enum('1','0') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '0' COMMENT '0 = Inactive, 1 = Active',
  `rules` enum('1','2','3','4','5','6') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '2',
  `images` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `thumbnail_images` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `createBy` int DEFAULT NULL,
  `createDate` datetime DEFAULT NULL,
  `updateBy` int DEFAULT NULL,
  `updateDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `user` */

insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(3,'Administrator','admin','admin@admin.id',12345,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','7dff9ede-3a14-11ee-a1f9-b03cdc82234a','2023-08-14 03:03:38','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','1','1','1','84554-istockphoto-1283749360-612x612.png','thumbnails/thumb-84554-istockphoto-1283749360-612x612.png',1,'2020-11-29 18:54:40',3,'2023-08-14 03:03:38'),
(4,'abil','abil','abil@gmail.com',202388889,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','076e7d0a-3a0d-11ee-a1f9-b03cdc82234a','2023-08-14 02:10:12','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',4,'2023-08-14 02:10:12');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(5,'Aldian Putra','aldian-putra','aldian-putra@gmail.com',2023000123,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','52ac544e-3f7c-11ee-a1f9-b03cdc82234a','2023-08-21 00:09:29','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','Chrome','0','1','5','46374-star.png','thumbnails/thumb-46374-star.png',3,'2023-07-27 14:24:40',5,'2023-08-21 00:09:29');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(6,'Bilal Jaya','bilal-jaya','bilal-jaya@gmail.com',202399999,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','7287ee5d-3f7c-11ee-a1f9-b03cdc82234a','2023-08-21 00:10:22','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','Chrome','0','1','4','98254-location-icon-circle.png','thumbnails/thumb-98254-location-icon-circle.png',3,'2023-07-27 14:30:06',6,'2023-08-21 00:10:22');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(8,'Sukamawati','sukmawati','sukmawati@gmail.com',2023654987,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','91415295-3f7c-11ee-a1f9-b03cdc82234a','2023-08-21 00:11:14','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','Chrome','1','1','2','6232-icon-1970474_1280.png','thumbnails/thumb-6232-icon-1970474_1280.png',3,'2023-07-27 14:33:06',8,'2023-08-21 00:11:14');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(9,'Agam','Agam','agam@gmail.com',202388899,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','b25ff582-3f74-11ee-a1f9-b03cdc82234a','2023-08-20 23:14:53','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',9,'2023-08-20 23:14:53');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(10,'Fina','Fina','fina@gmail.com',202388811,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','6215b28a-3a08-11ee-a1f9-b03cdc82234a','2023-08-14 01:36:57','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',10,'2023-08-14 01:36:57');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(11,'Ana','ana','ana@gmail.com',202388822,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','4c1c01ca-3a0d-11ee-a1f9-b03cdc82234a','2023-08-14 02:12:08','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',11,'2023-08-14 02:12:08');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(12,'Dila','dila','dila@gmail.com',202388833,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','25ce8c27-3a0d-11ee-a1f9-b03cdc82234a','2023-08-14 02:11:03','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',12,'2023-08-14 02:11:03');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(13,'Agil Hendra','agil','agil@gmail.com',98888900,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','017aaeba-37a3-11ee-a1f9-b03cdc82234a','2023-08-11 00:26:13','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','5','default-avatar.png','thumbnails/thumb-default-avatar.png',3,'2023-08-01 01:30:59',13,'2023-08-11 00:26:13');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(14,'andra','andra','andra@gmail.com',202388822,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','a10c9ab0-3944-11ee-a1f9-b03cdc82234a','2023-08-13 02:15:41','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','56766-RecaptchaLogo.svg.png','thumbnails/thumb-56766-RecaptchaLogo.svg.png',3,'2022-01-14 14:14:48',14,'2023-08-13 02:15:41');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(15,'Dosen Luar','dosenluar','dosen_luar@gmail.com',567894321,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','e47ccf8a-3a0c-11ee-a1f9-b03cdc82234a','2023-08-14 02:09:14','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','default-avatar.png','thumbnails/thumb-default-avatar.png',3,'2023-08-11 02:47:15',15,'2023-08-14 02:09:14');
insert  into `user`(`id`,`full_name`,`username`,`email`,`nim`,`password`,`uuid`,`last_login`,`last_login_ip`,`last_login_agent`,`browser_name`,`is_online`,`status`,`rules`,`images`,`thumbnail_images`,`createBy`,`createDate`,`updateBy`,`updateDate`) values 
(16,'Agung Sadewa','agung_sadewa','agung@gmail.com',2147483647,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220','f5a7df66-3a07-11ee-a1f9-b03cdc82234a','2023-08-14 01:33:55','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36','Chrome','0','1','3','default-avatar.png','thumbnails/thumb-default-avatar.png',3,'2023-08-14 00:42:00',16,'2023-08-14 01:33:55');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
