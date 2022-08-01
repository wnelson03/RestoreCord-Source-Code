using Microsoft.EntityFrameworkCore;
using RestoreCord.Schema;

namespace RestoreCord.Services
{
    public class Database : DbContext
    {
        private readonly string ConnectionString = $"server=localhost;user=root;database=restore;password={Properties.Resources.MySQLPass}";
        protected override void OnConfiguring(DbContextOptionsBuilder options) => options.UseMySql(ConnectionString, ServerVersion.AutoDetect(ConnectionString)).UseLazyLoadingProxies();

        public DbSet<Schema.Log.Errors> Errors { get; set; }
        public DbSet<Member> members { get; set; }
        public DbSet<Server> servers { get; set; }
    }
}
