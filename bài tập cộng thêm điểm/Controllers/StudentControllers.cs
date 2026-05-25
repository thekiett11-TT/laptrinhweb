// Cần using thư mục Models để nhận diện DBContext và Student
// Sửa lại namespace này cho đúng với tên project thực tế của bạn
using BaiTapCongThemDiem.Models;
using Microsoft.AspNetCore.Mvc;

namespace bai_tap_cong_them_diem.Controllers // Sửa namespace nếu cần
{
    public class StudentControllers : Controller
    {
        private readonly DBContext _context;

        // Hàm tạo (Constructor) để nhận DBContext
        public StudentControllers(DBContext context)
        {
            _context = context;
        }

        // Action Index sẽ hiển thị danh sách học sinh
        public IActionResult Index()
        {
            // Lấy toàn bộ dữ liệu từ bảng Students trong Database
            var danhSachHocSinh = _context.Students.ToList();

            // Truyền danh sách này sang View để hiển thị
            return View(danhSachHocSinh);
        }
    }
}