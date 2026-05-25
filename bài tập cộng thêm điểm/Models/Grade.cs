namespace bài_tập_cộng_thêm_điểm.Models
{
    public class Grade
    {
        public int Gradeid { get; set; }
        public string? GradeName { get; set; }
        public List<Student>? Students {  get; set; }
    }
}
