using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace RestoreCord.Schema.DiscordModels
{
    public class API
    {
        public class RefreshTokenInfo
        {
            public string access_token { get; set; }
            public long expires_in { get; set; }
            public string refresh_token { get; set; }
            public string scope { get; set; }
            public string token_type { get; set; }
        }

        public class JoinGuildInfo
        {
            public string[] roles { get; set; }
            public string nick { get; set; }
            public string avatar { get; set; }
            public string premium_since { get; set; }
            public DateTime joined_at { get; set; }
            public bool is_pending { get; set; }
            public UserJoinInfo user { get; set; }
        }
        public class UserJoinInfo
        {
            public ulong id { get; set; }
            public string username { get; set; }
            public string avatar { get; set; }
            public int discriminator { get; set; }
            public int public_flags { get; set; }
            public bool mute { get; set; }
            public bool deaf { get; set; }
        }
    }
}
