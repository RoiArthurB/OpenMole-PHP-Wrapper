<!-- PROJECT SHIELDS -->
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![Apache2 License][license-shield]][license-url]



<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://github.com/RoiArthurB/OpenMole-PHP-Wrapper">
    <img src="https://i.imgur.com/DW2erAV.png" alt="Logo" width="200" height="83">
  </a>

  <h3 align="center">OpenMole PHP Wrapper</h3>

  <p align="center">
    PHP wrapper to communicate easily with the OpenMole REST API
    <br />
    <a href="https://github.com/RoiArthurB/OpenMole-PHP-Wrapper#table-of-contents"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/issues">Report Bug</a>
    ·
    <a href="https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/issues">Request Feature</a>
  </p>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation from `composer` (the easy way)](#installation-from-composer-the-easy-way)
  * [Installation from git](#installation-from-git)
* [Usage](#usage)
* [Contributing](#contributing)
* [License](#license)
* [Authors](#authors)
* [Acknowledgements](#acknowledgements)



<!-- ABOUT THE PROJECT -->
## About The Project

This library has been made to more easily integrate the communication between your PHP application (I'm using it with the Lumen µFramework) and an OpenMole REST API !

So this library will wrap all the exposed URL, send a curl request and return the result in an easy to use format for your PHP application.

### Built With

* [PHP >= 7.1](https://www.php.net/downloads)
* [php7-libcurl](https://www.php.net/manual/en/book.curl.php)
* [OpenMole >= 10.1](https://openmole.org/Download.html)



<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

This is an example of how to list and check version of things you need to have to use the library.
* php
```sh
$ php -v
PHP 7.4.3 (cli) (built: Feb 18 2020 15:35:13) ( NTS )
Copyright (c) The PHP Group
Zend Engine v3.4.0, Copyright (c) Zend Technologies
```

* curl
```sh
$ curl -V
curl 7.69.0 (x86_64-pc-linux-gnu) libcurl/7.69.0 OpenSSL/1.1.1d zlib/1.2.11 libidn2/2.3.0 libpsl/0.21.0 (+libidn2/2.2.0) libssh2/1.9.0 nghttp2/1.39.2
Release-Date: 2020-03-04
Protocols: dict file ftp ftps gopher http https imap imaps pop3 pop3s rtsp scp sftp smb smbs smtp smtps telnet tftp 
Features: AsynchDNS GSS-API HTTP2 HTTPS-proxy IDN IPv6 Kerberos Largefile libz NTLM NTLM_WB PSL SPNEGO SSL TLS-SRP UnixSockets
```

* composer
```sh
$ composer -V
Composer version 1.9.3 2020-02-04 12:58:49
```

### Installation from `composer` (the easy way)

1. Move to the root folder of your application
```sh
$ cd /path/to/your/app
```

2. Make the library required
```sh
$ composer require roiarthurb/openmole
```

3. Install the required libraries
```sh
$ composer install
```

### Installation from git
 
1. Clone the OpenMole-PHP-Wrapper
```sh
git clone https://github.com/RoiArthurB/OpenMole-PHP-Wrapper.git
```

2. Link/Use the lib in your application



<!-- USAGE EXAMPLES -->
## Usage

### Create a OpenMole Wrapper instance

```php
$myWrapper = new \RoiArthurB\OpenMole\OpenMole( $url = "api.myopenmole.org", $port = 8080, $https = false);
```

### Get full list of jobs running on your OpenMole instance

```php
$result = $myWrapper->getJobs();
var_dump($result); // array(2) { [0]=> object(stdClass)#34 (1) { ["id"]=> string(36) "1b303e8a-b739-46bb-8b9d-323c588e74ff" } [1]=> object(stdClass)#35 (1) { ["id"]=> string(36) "9a1d21e0-c9ed-42e8-b0f3-ba6de6abda53" } } 
```

### Get a single job state

```php
$result = $myWrapper->getJobState("1b303e8a-b739-46bb-8b9d-323c588e74ff");
var_dump($result); // object(stdClass)#34 (1) { ["state"]=> string(8) "finished" } 
```

_For more examples, please refer to the [Documentation](https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/wiki)_


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request



<!-- LICENSE -->
## License

Distributed under the Apache2 License. See `LICENSE` for more information.



<!-- CONTACT -->
## Authors

* **Arthur Brugiere** - *Initial work* - [RoiArthurB](https://github.com/RoiArthurB)

Project Link: [https://github.com/RoiArthurB/OpenMole-PHP-Wrapper](https://github.com/RoiArthurB/OpenMole-PHP-Wrapper)
OpenMole Project Link: [https://openmole.org/index.html](https://openmole.org/index.html)

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/RoiArthurB/OpenMole-PHP-Wrapper.svg?style=flat-square
[contributors-url]: https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/RoiArthurB/OpenMole-PHP-Wrapper.svg?style=flat-square
[forks-url]: https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/network/members
[stars-shield]: https://img.shields.io/github/stars/RoiArthurB/OpenMole-PHP-Wrapper.svg?style=flat-square
[stars-url]: https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/stargazers
[issues-shield]: https://img.shields.io/github/issues/RoiArthurB/OpenMole-PHP-Wrapper.svg?style=flat-square
[issues-url]: https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/issues
[license-shield]: https://img.shields.io/github/license/RoiArthurB/OpenMole-PHP-Wrapper.svg?style=flat-square
[license-url]: https://github.com/RoiArthurB/OpenMole-PHP-Wrapper/blob/master/LICENSE
