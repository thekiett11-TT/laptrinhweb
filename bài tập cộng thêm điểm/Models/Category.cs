namespace bài_tập_cộng_thêm_điểm.Models
{
    public class Category
    {
        public int Id { get; set; }
        public string? Name { get; set; } // Tên chủ đề (Lập trình, Cuộc sống...)

        // Mối quan hệ 1-N: Một chủ đề có nhiều cuốn sách
        public ICollection<Book>? Books { get; set; }
    }
}
