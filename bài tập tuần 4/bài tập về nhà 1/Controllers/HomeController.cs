using System.Diagnostics;
using bài_tập_về_nhà_1.Models;
using Microsoft.AspNetCore.Mvc;

namespace bài_tập_về_nhà_1.Controllers
{
    public class HomeController : Controller
    {
        private static List<ToDo> todoList = new List<ToDo>();
        public IActionResult Index()
        {
           
            return View(todoList);
        }

        public IActionResult Privacy()
        {
            return View();
        }
        // 2. TRANG CHI TIẾT CÔNG VIỆC
        public IActionResult Details(int id)
        {
            var item = todoList.FirstOrDefault(t => t.Id == id);
            if (item == null) return NotFound();
            return View(item);
        }

        // 3. MÀN HÌNH THÊM MỚI (Giao diện)
        public IActionResult Create()
        {
            return View();
        }

        // XỬ LÝ LƯU THÊM MỚI (Tự động tăng ID)
        [HttpPost]
        public IActionResult Create(ToDo newTodo)
        {
            // Tự động tính toán ID tiếp theo (nếu danh sách trống thì ID đầu tiên là 1)
            newTodo.Id = todoList.Count > 0 ? todoList.Max(t => t.Id) + 1 : 1;

            todoList.Add(newTodo);
            return RedirectToAction("Index");
        }

        // 4. MÀN HÌNH SỬA CÔNG VIỆC
        public IActionResult Edit(int id)
        {
            var item = todoList.FirstOrDefault(t => t.Id == id);
            if (item == null) return NotFound();
            return View(item);
        }

        [HttpPost]
        public IActionResult Edit(ToDo editedTodo)
        {
            var item = todoList.FirstOrDefault(t => t.Id == editedTodo.Id);
            if (item != null)
            {
                item.Name = editedTodo.Name;
                item.IsCompleted = editedTodo.IsCompleted;
            }
            return RedirectToAction("Index");
        }

        // 5. XỬ LÝ XÓA CÔNG VIỆC
        public IActionResult Delete(int id)
        {
            var item = todoList.FirstOrDefault(t => t.Id == id);
            if (item != null)
            {
                todoList.Remove(item);
            }
            return RedirectToAction("Index");
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
