# DTMS 2.0
## Changes:

### URL
* Giữ nguyên: Đọc config/route

### Controller
* Tách controller Feedback ra thành nhiều controller để dễ maintain

### Model
* Các model cho bản 2.0 được viết mới tại Feed_upgrade_model
* Tối ưu các query

### View
* Chỉnh sửa 1 số view để phù hợp vs controller mới

### Database
* Thêm trường main_teacher trong bảng feedback_class để dễ query
* Thêm các trường number_* trong bảng feedback_class

### Thuật toán chấm điểm
* Chia nhỏ thuật toán chấm điểm thành nhiều tiêu chí để tối ưu ...