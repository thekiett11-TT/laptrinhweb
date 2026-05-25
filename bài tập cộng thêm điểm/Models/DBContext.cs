using bài_tập_cộng_thêm_điểm.Models;
using Microsoft.EntityFrameworkCore;

namespace BaiTapCongThemDiem.Models // Thay bằng namespace thực tế của file bạn nếu khác
{
    public class DBContext : DbContext
    {
        // ---> BẠN CẦN CHẮC CHẮN PHẢI CÓ ĐOẠN NÀY <---
        public DBContext(DbContextOptions<DBContext> options) : base(options)
        {
        }
        // ---------------------------------------------

        // Các DbSet của bạn ở bên dưới (đây chỉ là ví dụ)
        public DbSet<Student> Students { get; set; }
        public DbSet<Grade> Grades { get; set; }
        public DbSet<Category> Categories { get; set; }
        public DbSet<Book> Books { get; set; }
    }
}