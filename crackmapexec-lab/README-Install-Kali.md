# Bước 1: Cài đặt Docker
Đảm bảo Docker đã được cài đặt trên hệ thống của bạn. Nếu chưa cài đặt, bạn có thể làm theo hướng dẫn trên Docker's website.
# Bước 2: Tải về và chạy Kali Linux container
Sử dụng lệnh sau để kéo và chạy hình ảnh Docker của Kali Linux:

```
docker run -it --name kali_container kalilinux/kali-rolling /bin/bash
```
![image](https://github.com/user-attachments/assets/ad2a0fe4-812c-459f-9c28-d2f4d2c414cb)
Giải thích:

- **docker run -it**: Chạy container với chế độ tương tác (-it).
- **--name kali_container**: Đặt tên container là kali_container.
- **kalilinux/kali-rolling**: Đây là hình ảnh Kali Linux từ Docker Hub.
- **/bin/bash**: Chạy shell Bash trong container Kali Linux.
- Lệnh này sẽ tải xuống Kali Linux từ Docker Hub (nếu bạn chưa có hình ảnh này trên máy), sau đó mở một shell Bash trong container Kali Linux.

# Bước 3: Cài đặt các công cụ bổ sung (tuỳ chọn)

Sau khi Kali Linux container đã được khởi chạy, bạn có thể cài đặt các công cụ tùy chỉnh mà bạn cần. Ví dụ, để cài đặt các công cụ phổ biến như **Metasploit**, **Nmap**, **CrackMapExec**, bạn có thể sử dụng các lệnh sau:

Cập nhật hệ thống
```
apt update && apt upgrade -y

```
![image](https://github.com/user-attachments/assets/f39bd1a5-2cf2-48d6-a2d3-52b128f9de67)

Cài đặt Nmap:

```
apt install nmap -y
```
![image](https://github.com/user-attachments/assets/f92d4a66-46ab-47a0-b69e-c6f4348b3f6d)

