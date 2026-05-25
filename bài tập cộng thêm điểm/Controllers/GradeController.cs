// Nhớ using thư mục Models của bạn
using BaiTapCongThemDiem.Models;
using Microsoft.AspNetCore.Mvc;

namespace bai_tap_cong_them_diem.Controllers
{
    public class GradeController : Controller
    {
        // Thuộc tính có thể truy cập và thực thi truy vấn đến CSDL
        private readonly DBContext _context;

        public GradeController(DBContext context)
        {
            _context = context;
        }

        // Action xem danh sách các lớp học
        // GET: /Grade/Index
        public IActionResult Index()
        {
            // Lấy danh sách tất cả các lớp học từ cơ sở dữ liệu
            var listGrade = _context.Grades.ToList();

            // Trả về view "Index" và truyền danh sách Lớp học vào view để hiển thị
            return View(listGrade);
        }
    }
}