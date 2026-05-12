using chieut2_laptrinhweb.Models;
using Microsoft.AspNetCore.Mvc;

namespace chieut2_laptrinhweb.Controllers
{
    public class StudentController : Controller
    {
        private static List<Student> RegisteredStudents = new List<Student>();

        // 1. Action để hiện trang đăng ký (GET)
        [HttpGet]
        public IActionResult Index()
        {
            return View();
        }

        // 2. Action để xử lý khi bấm nút Đăng ký (POST)
        [HttpPost]
        public IActionResult ShowKQ(Student student)
        {
            // Thêm sinh viên mới vào danh sách
            RegisteredStudents.Add(student);

            // Đếm số lượng sinh viên cùng chuyên ngành
            int sameMajorCount = RegisteredStudents.Count(s => s.ChuyenNganh == student.ChuyenNganh);

            // Truyền dữ liệu sang View ShowKQ bằng ViewBag
            ViewBag.MSSV = student.MSSV;
            ViewBag.HoTen = student.HoTen;
            ViewBag.ChuyenNganh = student.ChuyenNganh;
            ViewBag.SameMajorCount = sameMajorCount;

            return View();
        }
    }
}
