# Bước 1: Tạo một script shell để khởi động 50 máy chủ SMB
Bạn có thể tạo một script shell để tự động khởi động 50 container SMB bằng Docker. Mỗi container sẽ có tên và thư mục chia sẻ riêng biệt.

Tạo script create_smb_containers.sh:

```
#!/bin/bash

# Tạo 50 container SMB với các thiết lập riêng biệt
for i in $(seq 1 50); do
  container_name="smbserver_$i"
  shared_folder="/path/to/shared/folder_$i"
  user="user_$i"
  password="password_$i"

  # Tạo thư mục chia sẻ trên máy host
  mkdir -p $shared_folder

  # Khởi động container SMB
  docker run -d \
    --name $container_name \
    -v $shared_folder:/mount \
    dperson/samba \
    -u "$user;$password" \
    -s "share_$i;/mount;yes;no;yes"

  echo "Container $container_name created with user $user and password $password"
done
```
Ghi chú:
- **for i in $(seq 1 50)**: Vòng lặp để tạo 50 containers.
- **container_name="smbserver_$i"**: Đặt tên container với số thứ tự từ 1 đến 50.
- **shared_folder="/path/to/shared/folder_$i"**: Tạo thư mục chia sẻ riêng cho mỗi container.
- **docker run -d**: Chạy container SMB với thông tin người dùng và thư mục chia sẻ tương ứng.
# Lưu script và chạy:
1. Lưu file **create_smb_containers.sh.**
2. Chạy lệnh sau để cấp quyền thực thi cho script:
```
chmod +x create_smb_containers.sh
```
3. Thực thi script:

```
./create_smb_containers.sh
```
- Sau khi chạy script này, 50 container SMB sẽ được tạo ra, mỗi container sẽ có:
- Một người dùng với tên và mật khẩu riêng.
- Một thư mục chia sẻ riêng.
# Bước 2: Kiểm tra danh sách container đã tạo
- Bạn có thể kiểm tra xem các container đã được tạo thành công bằng lệnh:
```
docker ps
```
![image](https://github.com/user-attachments/assets/2943c9dc-2003-4857-acbc-e036b322817b)
# Bước 3: Kiểm tra SMB bằng CrackMapExec
- Sau khi các container SMB đã được khởi động, bạn có thể dùng CrackMapExec để kiểm tra các chia sẻ SMB trên tất cả các container này. Giả sử dải IP của các container là 172.17.0.0/24, bạn có thể quét tất cả các container như sau:
```
crackmapexec smb 172.17.0.0/24 -u user_1 -p password_1
```
![image](https://github.com/user-attachments/assets/87f3f977-c758-4690-84d1-853472d904c6)

![image](https://github.com/user-attachments/assets/7791aa87-370b-4209-b356-d4e6fc55803f)


# Bước 4: Xóa các container SMB khi không cần thiết
- Sau khi hoàn tất kiểm tra, bạn có thể dọn dẹp và xóa tất cả các container đã tạo bằng lệnh sau:
```
docker rm -f $(docker ps -aq --filter "name=smbserver_")
```
Lệnh này sẽ xóa tất cả các container có tên bắt đầu với smbserver_.





