using Microsoft.EntityFrameworkCore;
namespace bài_tập_về_nhà.Models
{
    public class ApplicationDbContext : DbContext
    {
        // Constructor bắt buộc
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options) : base(options)
        {
        }

        // Khai báo các bảng sẽ có trong Database
        public DbSet<Category> Categories { get; set; }
        public DbSet<Book> Books { get; set; }
    }

}
