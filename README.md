Platform Komentar Berbasis Forum

Aplikasi forum diskusi yang dibangun dengan menggunakan arsitektur mikroservis modern. Proyek ini mendemonstrasikan komunikasi antar-layanan menggunakan HTTP (Synchronous) dan RabbitMQ (Asynchronous/Event-Driven).

🏗️ Arsitektur Sistem
Sistem ini terdiri dari beberapa komponen utama:
1. Frontend: Laravel (Blade) - Berjalan di Port 3000
2. User Service: NestJS (Autentikasi & Registrasi) - Berjalan di Port 3001
3. Comment Service: NestJS (CRUD Komentar) - Berjalan di Port 3002
4. Message Broker: RabbitMQ (Sinkronisasi Data) - Port 15672 (Management)
5. Database: MySQL (Penyimpanan Data Komentar)

🛠️ Fitur Utama
1. Join Forum (Event-Driven): Saat user mendaftar via User Service, pesan dikirim melalui RabbitMQ ke Comment Service secara otomatis.
2. Post & Manage Comments: CRUD komentar secara langsung melalui Comment Service menggunakan database MySQL.
3. Dockerized: Seluruh layanan dapat dijalankan hanya dengan satu perintah menggunakan Docker Compose.
4. CI/CD Ready: Dilengkapi dengan GitHub Actions untuk otomatisasi pengujian dan pembangunan aplikasi.




