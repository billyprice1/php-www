Olympe Website & Panel
=============

This repository contains the source codes of the [Olympe](http://www.olympe.in/) website and panel.

## Local deployment

### Softwares

You will need the following softwares:

* Apache 2.X.X
 * mod_rewrite
 * mod_vhost_alias
* PHP 5.5.X
 * Imagick extension

### Clone repositories

Create a directory for the Olympe repositories and clone from Github:

```Shell
mkdir olympe && cd olympe
git clone https://github.com/OlympeNetwork/php-www
cd php-www
git submodule init
git submodule update
```

After _submodule update_, you will have the whole source code of the website.

### Create a vhost in Apache 2

We use Apache 2 because of the _required_ .htaccess, you have to add a virtualhost for the address _local.olympe.in_:

```
<VirtualHost *:80>
    ServerAdmin admin@olympe.in
    DocumentRoot "/path/to/the/repository"
    ServerName local.olympe.in
    ServerAlias local.olympe.in
</VirtualHost>
```

### Last actions

You have to add a new entry in your _hosts_ file that matching the virtualhost:
```
127.0.0.1 local.olympe.in
```

And create a file _www.ini_ just in the parent directory of the repository (ie. if repository is in _/home/dev/olympe/php-www_, the _www.ini_ file must be in the _/home/dev/olympe_ folder) with the following content:
```
[Main]
API_TOKEN={YOUR_TOKEN)
API_HOST=api.olympe.in
API_USERNAME={YOUR_USER}
HOSTNAME=www.olympe.in
```

You can find your token in your panel : https://www.olympe.in/panel/settings/tokens.

### Advanced

The _www.ini_ file location is defined in the file [_LIB/config_on.inc](https://github.com/AnotherService/php-libwww/blob/master/config_on.inc):

```PHP
if( $_SERVER["HTTP_HOST"] == 'localhost' || $_SERVER["HTTP_HOST"] == '127.0.0.1' || $_SERVER["HTTP_HOST"] == 'local.olympe.in' )
	$conf = parse_ini_file('../www.ini', true);
elseif( $_SERVER["HTTP_HOST"] == 'hosting.dev.olympe.in' )
	$conf = parse_ini_file('/dns/in/olympe/etc/settings/hosting.dev.ini', true);
elseif( $_SERVER["HTTP_HOST"] == 'hosting.olympe.in' )
	$conf = parse_ini_file('/dns/in/olympe/etc/settings/hosting.ini', true);
else
	$conf = parse_ini_file('/dns/in/olympe/etc/settings/www.ini', true);
