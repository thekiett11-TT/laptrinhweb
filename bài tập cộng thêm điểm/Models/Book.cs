namespace bài_tập_cộng_thêm_điểm.Models
{
    public class Book
    {
        public int Id { get; set; }
        public string? Title { get; set; } // Tên sách
        public string? Author { get; set; } // Tác giả
        public decimal Price { get; set; } // Giá bán
        public string? Description { get; set; } // Mô tả chi tiết
        public string? ImageUrl { get; set; } // Đường dẫn ảnh bìa sách

        // Khóa ngoại liên kết với bảng Category
        public int CategoryId { get; set; }
        public Category? Category { get; set; }
    }
}
