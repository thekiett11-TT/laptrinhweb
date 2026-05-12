using Microsoft.AspNetCore.Mvc;

namespace chieut2_laptrinhweb.Controllers
{
    public class indexController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
