using System.Diagnostics;
using chieut2_laptrinhweb.Models;
using Microsoft.AspNetCore.Mvc;

namespace chieut2_laptrinhweb.Controllers
{
    public class HomeController : Controller
    {

        public IActionResult Index()
        {
            return View();
        }

        public IActionResult Privacy()
        {
            return View();
        }

        public IActionResult sanpham() {



        return View();
        
        }

        public IActionResult Baitap2() {
            var sp = new SanPhamViewModel() { TenSP = "laptop", MaSP = "01" , AnhMota = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxU5frfB98F9Dj0FTggW29yZ5qycVVOSc7RQ&s" };

            return View(sp);
        }


        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
