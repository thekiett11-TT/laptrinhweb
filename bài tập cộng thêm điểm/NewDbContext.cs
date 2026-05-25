using Microsoft.EntityFrameworkCore;

public class NewDbContext(DbContextOptions<NewDbContext> options) : DbContext(options)
{
    public DbSet<bài_tập_cộng_thêm_điểm.Models.Book> Book { get; set; } = default!;
}
