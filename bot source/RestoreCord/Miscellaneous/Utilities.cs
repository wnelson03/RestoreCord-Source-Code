using Discord;
using Discord.Commands;
using Discord.WebSocket;
using Microsoft.EntityFrameworkCore;
using Newtonsoft.Json;
using RestoreCord.Schema.DiscordModels;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;
using System.Threading.Tasks;

namespace RestoreCord.Miscellaneous
{
    public static class Extensions
    {
        public static string getHeader(this WebHeaderCollection header, string key)
        {
            for (int i = 0; i < header.Count; i++)
            {
                if (header.GetKey(i) == key)
                    return header.Get(i);
            }
            return null;
        }


        public static async Task<HttpStatusCode> AddUserToGuild(this SocketSlashCommand cmd, Schema.Member user, Schema.Server server)
        {
            try
            {
                var web = new WebClient();
                web.Headers.Add("Authorization", $"Bot {Properties.Resources.Token}");
                web.Headers.Add("X-RateLimit-Precision", "millisecond");
                web.Headers.Add("User-Agent", "tutorial-restore-system");
                web.Headers.Add("Content-Type", $"application/json");
                string data = null;
                if (server.roleid is null)
                {
                    data = JsonConvert.SerializeObject(new { access_token = user.access_token });
                }
                else
                {
                    data = JsonConvert.SerializeObject(new
                    {
                        access_token = user.access_token,
                        roles = new ulong[]
                        {
                            (ulong)server.roleid
                        },
                    });
                }
                if (JsonConvert.DeserializeObject<API.JoinGuildInfo>
                    (web.UploadString($"https://discord.com/api/guilds/{server.guildid}/members/{user.userid}", WebRequestMethods.Http.Put, data)) is null)
                    return HttpStatusCode.BadRequest;
                return HttpStatusCode.OK;
            }
            catch (WebException webex)
            {
                var response = (HttpWebResponse)webex.Response;
                switch (response.StatusCode)
                {
                    case HttpStatusCode.TooManyRequests:
                        var headervalue = webex.Response.Headers.getHeader("Retry-After");
                        if (headervalue is not null)
                        {
                            Thread.Sleep(Convert.ToInt32(headervalue));
                            if (await cmd.AddUserToGuild(user, server) == HttpStatusCode.OK)
                                return HttpStatusCode.OK;
                        }
                        return response.StatusCode;
                    case HttpStatusCode.NoContent://in the guild already
                        return HttpStatusCode.OK;
                    default:
                        //await cmd.SendEmbedAsync("add user exception", $"{response.StatusCode}\n{webex}\n{response}");
                        return response.StatusCode;
                }
            }
        }

        public static async Task LogErrorAsync(this Exception e)
        {
            try
            {
                var db = new Services.Database();
                await db.AddAsync(new Schema.Log.Errors
                {
                    ErrorTime = DateTime.Now,
                    Location = e.Source,
                    Reason = e.Message,
                    Name = e.TargetSite.Name
                });
                await db.SaveChangesAsync();
            }
            catch (DbUpdateException updateError)
            {
                //error saving the db, txt/email me the error and/or log to discord
            }
            catch (Exception error)
            {

            }
        }

        public static async Task LogErrorAsync(this Exception e, SocketSlashCommand context)
        {
            try
            {
                var db = new Services.Database();
                db.Add(new Schema.Log.Errors
                {
                    ErrorTime = DateTime.Now,
                    Location = e.Source,
                    Reason = e.Message,
                    Name = e.TargetSite.Name
                });
                await db.SaveChangesAsync();
                await context.SendEmbedAsync("Application Error", $"Error has be logged to the database.\nMessage: {e.Message}");
            }
            catch (DbUpdateException updateError)
            {
                //error saving the db, txt/email me the error and/or log to discord
            }
            catch (Exception error)
            {

            }
        }

        public static async Task SendEmbedAsync(this SocketSlashCommand context, string title, string description, int? deleteTimer = null)
        {
            var embed = new EmbedBuilder()
            {
                Title = title,
                Color = Utilities.RandomDiscordColour(),
                Author = new EmbedAuthorBuilder
                {
                    Url = "https://restorecord.com",
                    Name = "RestoreCord",
                    IconUrl = "https://i.imgur.com/Nfy4OoG.png"
                },
                Footer = new EmbedFooterBuilder
                {
                    Text = $"Issued by: {context.User.Username} | {context.User.Id}",
                    IconUrl = context.User.GetAvatarUrl()
                },
                Description = description,
            }.WithCurrentTimestamp().Build();
            IUserMessage msg = null;
            msg = await context.Channel.SendMessageAsync(embed: embed);
            if (msg is not null && deleteTimer is not null)
            {
                _ = Task.Run(async () => { await Task.Delay((int)deleteTimer); await msg.DeleteAsync(); });
            }
        }
        public static async Task ReplyWithEmbedAsync(this SocketSlashCommand context, string title, string description, int? deleteTimer = null)
        {
            var embed = new EmbedBuilder()
            {
                Title = title,
                Color = Utilities.RandomDiscordColour(),
                Author = new EmbedAuthorBuilder
                {
                    Url = "https://restorecord.com",
                    Name = "RestoreCord",
                    IconUrl = "https://i.imgur.com/Nfy4OoG.png"
                },
                Footer = new EmbedFooterBuilder
                {
                    Text = $"Issued by: {context.User.Username} | {context.User.Id}",
                    IconUrl = context.User.GetAvatarUrl()
                },
                Description = description,
            }.WithCurrentTimestamp().Build();
            IUserMessage msg = null;
            await context.RespondAsync(embed: embed);
            if (msg is not null && deleteTimer is not null)
            {
                _ = Task.Run(async () => { await Task.Delay((int)deleteTimer); await msg.DeleteAsync(); });
            }
        }
    }


    public static class Utilities
    {
        public static Color RandomDiscordColour()
        {
            return new Color(new Random().Next(0, 255), new Random().Next(0, 255), new Random().Next(0, 255));
        }
    }
}
