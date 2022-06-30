using Discord;
using Discord.WebSocket;
using System;
using System.Threading.Tasks;

namespace RestoreCord.Services
{
    public class Log
    {
        private readonly DiscordShardedClient _discord;
        public Log(DiscordShardedClient discord)
        {
            _discord = discord;
            _discord.Log += LogHandler;
        }
        private static Task LogHandler(LogMessage message)
        {
            switch (message.Severity)
            {
                case LogSeverity.Critical:
                case LogSeverity.Error:
                    Console.ForegroundColor = ConsoleColor.Red;
                    break;
                case LogSeverity.Warning:
                    Console.ForegroundColor = ConsoleColor.Yellow;
                    break;
                case LogSeverity.Info:
                    Console.ForegroundColor = ConsoleColor.White;
                    break;
                case LogSeverity.Verbose:
                case LogSeverity.Debug:
                    Console.ForegroundColor = ConsoleColor.Gray;
                    break;
            }
            Console.WriteLine($"{DateTime.Now} [{message.Severity}] {message.Source}: {message.Message} {message.Exception}");
            Console.ResetColor();
            return Task.CompletedTask;
        }
    }
}
