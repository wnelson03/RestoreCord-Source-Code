using System.ComponentModel.DataAnnotations;

namespace RestoreCord.Schema
{
    public class Server
    {
        [Key]
        public int id { get; set; }
        public string owner { get; set; }
        public string name { get; set; }
        public ulong? guildid { get; set; }
        public ulong? roleid { get; set; }
    }
}
