## Requirements
1. PHP 5.3x/5.4
2. Redis server
3. Rediska php extension ('pear channel-discover pear.geometria-lab.net' and then 'pear install geometria-lab/Rediska-beta')
4. MongoDB (from !0Gen's repository)
5. MongoDB PHP Extension (pecl install mongo)
6. Swiftmailer Lbrary from pear.swiftmailer.org

##Setup Instructions

1. Clone http://github.com/priyoahiri/chatkeeda

2. Create Apache virtualhost for domain and point it to the public directory inside cloned repository

3. Go into the application directory inside the cloned repo and edit application.php and make the following changes:

	Edit 'url' to the web address where the application resides, without a trailing slash.
	
	Change 'index' to blank value.
	
	Change 'key' to a random 32 character string.
	
	Change 'timezone' to a valid UNIX timezone string like 'Asia/Calcutta'.
	
4. Edit cache.php and change 'driver' to either memcache, apc or redis according to what you run on the server and change 'key' to something unique so keys don't collide. If you use Memcached change the 'memcached' array as well. Best to use Redis, since Redis is an application dependency anyways.

5. Edit session.php and change 'driver' as before accordingly. Change 'cookie' to an unique string.

6. Change error reporting levels as required in error.php

7. Go into public directory inside the cloned repo and edit the constant 'WEBROOT' to point to the directory to where you have the repo, for example, '/mnt/www/chatkeeda', without a trailing slash. Change the PUSHER constants to values from your Pusher account. Change 'MONGOHOST' to your MongoDB host IP, and 'ADMINMAIL' to a valid e-mail address from which all mails will be sent out.




