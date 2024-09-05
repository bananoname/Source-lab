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
