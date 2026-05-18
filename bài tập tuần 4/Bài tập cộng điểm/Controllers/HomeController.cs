using System.Diagnostics;
using bài_tập_công_điểm.Models;
using Microsoft.AspNetCore.Mvc;

namespace bài_tập_công_điểm.Controllers
{
    public class HomeController : Controller
    {
        public IActionResult Index()
        {
            var actors = new List<Actor>
            {
                new Actor { Name = "Phương Anh Đào", Height = 160, Role = "Mai" },
                new Actor { Name = "Tuấn Trần", Height = 170, Role = "Dương (Sâu)" },
                new Actor { Name = "Trấn Thành", Height = 150, Role = "ông Hoàng" },
                new Actor{Name ="Kiệt ",Height = 159,Role="Ông trùm xã hội"},
                 new Actor{Name ="Vũ ",Height = 200,Role="Ông trùm ma túy"}

            };
            return View(actors);

        }

        public IActionResult Privacy()
        {
            return View();
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
