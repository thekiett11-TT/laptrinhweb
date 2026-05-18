namespace bài_tập_công_điểm.Models
{
    public class Actor
    {
        public required string Name { get; set; }

        // Chiều cao (cm)
        public int Height { get; set; }

        // Vai diễn trong phim
        public required string Role { get; set; }
    }
}
