using Discord.WebSocket;
using System.Threading.Tasks;

namespace RestoreCord.Services
{
    public class Custom
    {
        private readonly DiscordShardedClient _client;
        public Custom(DiscordShardedClient client)
        {
            _client = client;
            _client.ShardReady += BotReady;
        }

        private async Task BotReady(DiscordSocketClient bot)
        {
            await bot.SetGameAsync("restorecord.com", null, Discord.ActivityType.Watching);
            await bot.SetStatusAsync(Discord.UserStatus.Idle);
        }
    }
}
