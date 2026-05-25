using System.ComponentModel.DataAnnotations;

namespace bài_tập_về_nhà.Models
{
    public class Category
    {
        public int Id { get; set; }

        [Required(ErrorMessage = "Tên chủ đề là bắt buộc")]
        [StringLength(100)]
        public string? Name { get; set; }

        // Navigation property
        public ICollection<Book>? Books { get; set; }
    }
}
