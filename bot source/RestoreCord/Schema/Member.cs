using System.ComponentModel.DataAnnotations;
using System.Net;

namespace RestoreCord.Schema
{
    public class Member
    {
        [Key]
        public int id { get; set; }
        public ulong userid { get; set; }
        public string access_token { get; set; }
        public string refresh_token { get; set; }
        public ulong? server { get; set; }
    }
}
