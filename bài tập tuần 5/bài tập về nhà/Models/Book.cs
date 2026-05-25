using System.ComponentModel.DataAnnotations;

namespace bài_tập_về_nhà.Models
{
    public class Book
    {
        public int Id { get; set; }

        [Required(ErrorMessage = "Tên sách là bắt buộc")]
        public string? Title { get; set; }

        [Required(ErrorMessage = "Tên tác giả là bắt buộc")]
        public string? Author { get; set; }

        public string? Description { get; set; }

        [Required(ErrorMessage = "Giá bán là bắt buộc")]
        [Range(0, double.MaxValue, ErrorMessage = "Giá bán phải lớn hơn 0")]
        public decimal Price { get; set; }

        public string? ImagePath { get; set; }

        public int CategoryId { get; set; }
        public Category? Category { get; set; }
    }
        
}
